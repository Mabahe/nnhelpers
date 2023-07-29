<?php
namespace Nng\Nnhelpers\ViewHelpers\Menu;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * 
 * ```
 * {nnt3:menu.rootline()}
 * ```
 */
class RootlineViewHelper extends AbstractViewHelper {

	use CompileWithRenderStatic;

	protected $escapeOutput = false;

	public function initializeArguments() {
	   $this->registerArgument('pageUid', 'int', 'PID der root-Seite', false);
	   $this->registerArgument('levels', 'int', 'wieviele Hierarchien rendern?', false, 99);
	}

	public static function renderStatic( array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext ) 
	{
		$pid = $arguments['pageUid'] ?: \nn\t3::Page()->getPid();
		$levels = $arguments['levels'];

		return \nn\t3::Menu()->getRootline( $pid );
	}
    
}
