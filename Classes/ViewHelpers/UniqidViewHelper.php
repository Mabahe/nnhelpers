<?php
namespace Nng\Nnhelpers\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * Gibt eine eindeutige, einmalige ID zurück.
 * 
 * Hilfreich z.B. für eindeutige IDs oder Klassen-Namen in Fluid-Templates.
 * ```
 * {nnt3:uniqid()}
 * ```
 * ```
 * <div id="box-{nnt3:uniqid()}"> ... </div>
 * ```
 * @return string
 */
class UniqidViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\FlashMessagesViewHelper {

	use CompileWithRenderStatic;

	protected $escapeOutput = false;

	public static function renderStatic( array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext ) {
		return uniqid('uid-');
	}
    
}
