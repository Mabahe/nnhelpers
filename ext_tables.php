<?php
defined('TYPO3_MODE') or die();

call_user_func(
    function( $extKey )
    {
        
        // Backend-Modul registrieren (falls im Ext-Config aktiviert)

        if (\nn\t3::Environment()->getExtConf('nnhelpers', 'showMod')) {
            \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
                'Nng.Nnhelpers',
                'tools',
                'tx_nnhelpers_m1',
                'top',
                [
                    'Module' => 'index, test'
                ],
                [
                    'access'    => 'admin',
                    'icon'      => 'EXT:nnhelpers/Resources/Public/Icons/module-icon.svg',
                    'labels'    => 'LLL:EXT:nnhelpers/Resources/Private/Language/locallang_mod.xlf',
                ]
            );
        }
    },
'nnhelpers');
