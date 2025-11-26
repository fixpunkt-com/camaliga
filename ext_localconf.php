<?php
use TYPO3\CMS\Core\Information\Typo3Version;

defined('TYPO3') || die();

(function () {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'List',
        [ \Quizpalme\Camaliga\Controller\ContentController::class => 'list, search, show'  ],
        [ \Quizpalme\Camaliga\Controller\ContentController::class => 'search'  ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Listextended',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'listExtended, search, showExtended'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'search' ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Show',
        [   \Quizpalme\Camaliga\Controller\ContentController::class => 'show'        ],
        [   \Quizpalme\Camaliga\Controller\ContentController::class => ''        ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Showextended',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'showExtended, show'        ],
        [   \Quizpalme\Camaliga\Controller\ContentController::class => ''        ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Carousel',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'carousel'       ],
        [   \Quizpalme\Camaliga\Controller\ContentController::class => ''     ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Carouselseparated',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'carouselSeparated'        ],
        [   \Quizpalme\Camaliga\Controller\ContentController::class => ''        ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Map',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'map, search, show'        ],
        [   \Quizpalme\Camaliga\Controller\ContentController::class => 'search'        ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Openstreetmap',
        [   \Quizpalme\Camaliga\Controller\ContentController::class => 'openstreetmap, search, show'      ],
        [   \Quizpalme\Camaliga\Controller\ContentController::class => 'search'       ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Search',
        [   \Quizpalme\Camaliga\Controller\ContentController::class => 'search'        ],
        [   \Quizpalme\Camaliga\Controller\ContentController::class => 'search'        ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Random',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'random'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'random'   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Responsive',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'responsive'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => ''   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Teaser',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'teaser, show'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => ''   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Elegant',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'elegant'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => ''   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'New',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'new, create'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'new, create'   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Bootstrap',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'bootstrap, search, show'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'search'   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Collapse',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'collapse, search, show'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'search'   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Modal',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'modal, search, show'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'search'   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Tab',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'tab, search, show'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'search'   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Ekko',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'ekko, search, show'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'search'   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Elastislide',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'elastislide, search, show'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'search'   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Fancybox',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'fancybox, search, show'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'search'   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Flexslider2',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'flexslider2, search, show'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'search'   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Flipster',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'flipster, search, show'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'search'   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Fullwidth',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'fullwidth, search, show'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'search'   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Galleryview',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'galleryview, search, show'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'search'   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Innerfade',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'innerfade, search, show'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'search'   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Isotope',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'isotope, search, show'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'search'   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Lightslider',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'lightslider, search, show'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'search'   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Magnific',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'magnific, search, show'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'search'   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Nanogallery2',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'nanogallery2, search, show'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'search'   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Owl2',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'owl2, search, show'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'search'   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Parallax',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'parallax, search, show'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'search'   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Responsivecarousel',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'responsiveCarousel, search, show'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'search'   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Roundabout',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'roundabout, search, show'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'search'   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Sgallery',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'sgallery, search, show'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'search'   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Skdslider',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'skdslider, search, show'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'search'   ]
    );
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Camaliga',
        'Slick',
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'slick, search, show'   ],
        [  \Quizpalme\Camaliga\Controller\ContentController::class => 'search'   ]
    );


    // wizards
    if ((new Typo3Version())->getMajorVersion() < 13) {
        // @extensionScannerIgnoreLine
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:camaliga/Configuration/TSconfig/ContentElementWizard.tsconfig">');

        // Add page TSConfig für den Linkvalidator
        if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('linkvalidator')) {
            // @extensionScannerIgnoreLine
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:camaliga/Configuration/TSconfig/Page/mod.linkvalidator.tsconfig">');
        }
    }


    //BE Hook für Koordinaten
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['camaliga'] = \Quizpalme\Camaliga\Hooks\DataHandlerHook::class;

    // Hooks for ke_search
    if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('ke_search')) {
        // register custom indexer hook
        // adjust this to your namespace and class name
        // adjust the autoloading information in composer.json, too!
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['registerIndexerConfiguration'][] = \Quizpalme\Camaliga\Hooks\KeSearchIndexer::class;
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['ke_search']['customIndexer'][] = \Quizpalme\Camaliga\Hooks\KeSearchIndexer::class;
    }

    // Add CSV-export task (sheduler)
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\Quizpalme\Camaliga\Task\CsvExportTask::class] = [
        'extension' => 'camaliga',
        'title' => 'LLL:EXT:camaliga/Resources/Private/Language/locallang_be.xlf:tasks.title',
        'description' => 'LLL:EXT:camaliga/Resources/Private/Language/locallang_be.xlf:tasks.description',
        'additionalFields' => \Quizpalme\Camaliga\Task\CsvExportAdditionalFieldProvider::class
    ];

    // Add CSV-import task (sheduler)
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\Quizpalme\Camaliga\Task\CsvImportTask::class] = [
        'extension' => 'camaliga',
        'title' => 'LLL:EXT:camaliga/Resources/Private/Language/locallang_be.xlf:itasks.title',
        'description' => 'LLL:EXT:camaliga/Resources/Private/Language/locallang_be.xlf:itasks.description',
        'additionalFields' => \Quizpalme\Camaliga\Task\CsvImportAdditionalFieldProvider::class
    ];

    // TCA-Validator
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tce']['formevals'][\Quizpalme\Camaliga\Evaluation\Double9Evaluation::class] = '';


    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update']['switchableControllerActionsPluginUpdaterCamaliga']
        = \Quizpalme\Camaliga\Updates\SwitchableControllerActionsPluginUpdater::class;

})();