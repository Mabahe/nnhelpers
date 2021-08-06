<?php

namespace Nng\Nnhelpers\Utilities;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 * Fluid Templates rendern und Pfade zu Templates im View manipulieren.
 */
class Template implements SingletonInterface {

	/**
	 * 	Entfernt den Pfad des Controller-Names z.B. /Main/...
	 * 	aus der Suche nach Templates.
	 *	```
	 *	\nn\t3::Template()->removeControllerPath( $this->view );
	 *	```
	 * 	@return void
	 */
	public function removeControllerPath( &$view ) {
		if (\nn\t3::t3Version() < 9) return;
		$view->getRenderingContext()->setControllerName('');
	} 
	
	/**
	 * 	Holt die Variables des aktuellen Views, sprich:
	 * 	Alles, was per assign() und assignMultiple() gesetzt wurde.
	 * 
	 * 	Im ViewHelper:
	 *	```
	 *	\nn\t3::Template()->getVariables( $renderingContext );
	 *	```
	 * 	Im Controller:
	 *	```
	 *	\nn\t3::Template()->getVariables( $this->view );
	 *	```
	 * 	@return array
	 */
	public function getVariables( &$view ) {
		if ($view instanceof \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface) {
			return $view->getVariableProvider()->getSource() ?: [];
		}
		return $view->getRenderingContext()->getVariableProvider()->getSource() ?: [];
	}

	/**
	 * 	Ein Fluid-Templates rendern per StandAlone-Renderer
	 *	```
	 *	\nn\t3::Template()->render( 'Templatename', $vars, $templatePaths );
	 *	\nn\t3::Template()->render( 'Templatename', $vars, 'myext' );
	 *	\nn\t3::Template()->render( 'Templatename', $vars, 'tx_myext_myplugin' );
	 *	\nn\t3::Template()->render( 'fileadmin/Fluid/Demo.html', $vars );
	 *	```
	 * 	@return string
	 */
	public function render ( $templateName = null, $vars = [], $templatePaths = [] ) {
		
		$view = \nn\t3::injectClass(StandaloneView::class);
		
		if ($templatePaths) {
			// String wurde als TemplatePath übergeben
			if (is_string($templatePaths)) {
				if ($paths = \nn\t3::Settings()->getPlugin($templatePaths)) {
					$templatePaths = $paths['view'];
				}
			}
			if ($templateName) {
				$templatePaths['template'] = $templateName;
			}
			$this->setTemplatePaths( $view, $templatePaths );
			$this->removeControllerPath( $view );
		} else {
			$view->setTemplatePathAndFilename( $templateName );
		}
		$view->assignMultiple( $vars );

		return $view->render();
	}
	
	/**
	 * 	einfachen Fluid-Code rendern per StandAlone-Renderer
	 *	```
	 * 	\nn\t3::Template()->renderHtml( '{_all->f:debug()} Test: {test}', $vars );
	 * 	\nn\t3::Template()->renderHtml( ['Name: {name}', 'Test: {test}'], $vars );
	 * 	\nn\t3::Template()->renderHtml( ['name'=>'{firstname} {lastname}', 'test'=>'{test}'], $vars );
	 *	```
	 * 	@return string
	 */
	public function renderHtml ( $html = null, $vars = [], $templatePaths = []) {
		
		$returnArray = is_array($html);
		if (!$returnArray) $html = [$html];

		$view = \nn\t3::injectClass(StandaloneView::class);
		if ($templatePaths) {
			$this->setTemplatePaths( $view, $templatePaths );
			$this->removeControllerPath( $view );
		}
		
		$view->assignMultiple( $vars ?: [] );

		foreach ($html as $k=>$v) {
			if (is_string($v) && trim($v)) {
				$view->setTemplateSource( $v );
				$html[$k] = $view->render();
			} else {
				$html[$k] = $v;
			}
		}
		return $returnArray ? $html : $html[0];
	}


	/**
	 * 	Setzt Templates, Partials und Layouts für einen View.
	 * 	$additionalTemplatePaths kann übergeben werden, um Pfade zu priorisieren
	 *	```
	 *	\nn\t3::Template()->setTemplatePaths( $this->view, $templatePaths );
	 *	```
	 * 	@return array
	 */
	public function setTemplatePaths ( $view = null, $defaultTemplatePaths = [], $additionalTemplatePaths = []) {
		
		$mergedPaths = $this->mergeTemplatePaths( $defaultTemplatePaths, $additionalTemplatePaths );

		if ($paths = $mergedPaths['templateRootPaths']) {
			$view->setTemplateRootPaths($paths);
		}
		if ($paths = $mergedPaths['partialRootPaths']) {
			$view->setPartialRootPaths($paths);
		}
		if ($paths = $mergedPaths['layoutRootPaths']) {
			$view->setLayoutRootPaths($paths);
		}
	   	if ($path = $mergedPaths['template']) {
			$view->setTemplate($path);
		}

		return $mergedPaths;
	}

	/**
	 * 	Findet ein Template in einem Array von möglichen templatePaths des Views
	 *	```
	 *	\nn\t3::Template()->findTemplate( $this->view, 'example.html' );
	 *	```
	 *	@return string
	 */
	public function findTemplate( $view = null, $templateName = '' ) {
		$paths = array_reverse($view->getTemplateRootPaths());
		$templateName = pathinfo( $templateName, PATHINFO_FILENAME );

		foreach ($paths as $path) {
			if (\nn\t3::File()->exists( $path . $templateName . '.html')) {
				return $path . $templateName . '.html';
			}
			if (\nn\t3::File()->exists( $path . $templateName)) {
				return $path . $templateName;
			}
		}
		return false;
	}

	/**
	 * 	Pfade zu Templates, Partials, Layout mergen
	 *	```
	 *	\nn\t3::Template()->mergeTemplatePaths( $defaultTemplatePaths, $additionalTemplatePaths );
	 *	```
	 * 	@return array
	 */
	public function mergeTemplatePaths ( $defaultTemplatePaths = [], $additionalTemplatePaths = [] ) {

		$pathsToMerge = ['templateRootPaths', 'partialRootPaths', 'layoutRootPaths'];
		foreach ($pathsToMerge as $field) {
			if ($paths = $additionalTemplatePaths[$field]) {
				if (!$defaultTemplatePaths[$field]) {
					$defaultTemplatePaths[$field] = [];
				}
				ArrayUtility::mergeRecursiveWithOverrule($defaultTemplatePaths[$field], $paths);
			}
		}
		if ($path = $additionalTemplatePaths['template']) {
			$defaultTemplatePaths['template'] = $path;
		}

		return $defaultTemplatePaths;
	}

}