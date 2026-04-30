<?php
declare(strict_types=1);

namespace Quizpalme\Camaliga\Backend\EventListener;

use TYPO3\CMS\Backend\Utility\BackendUtility as BackendUtilityCore;
use TYPO3\CMS\Backend\View\BackendViewFactory;
use TYPO3\CMS\Backend\View\Event\PageContentPreviewRenderingEvent;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class PreviewEventListener
{
    /**
     * Extension key
     *
     * @var string
     */
    public const KEY = 'camaliga';

    /**
     * Path to the locallang file
     *
     * @var string
     */
    public const LLPATH = 'LLL:EXT:camaliga/Resources/Private/Language/locallang_be.xlf:';

    /**
     * Max shown settings
     */
    public const SETTINGS_IN_PREVIEW = 10;

    protected $recordMapping = [
        'listId' => [
            'table' => 'pages',
            'multiValue' => false,
        ],
        'showId' => [
            'table' => 'pages',
            'multiValue' => false,
        ],
        'teaserIDs' => [
            'table' => 'tx_camaliga_domain_model_content',
            'multiValue' => false,
        ]
    ];

    /**
     * pi-Dinger
     *
     * @var array
     */
    protected $pis = ['camaliga_list','camaliga_listextended','camaliga_show','camaliga_showextended','camaliga_carousel','camaliga_carouselseparated','camaliga_map','camaliga_search','camaliga_openstreetmap','camaliga_random','camaliga_teaser','camaliga_responsive','camaliga_elegant','camaliga_bootstrap','camaliga_collapse','camaliga_modal','camaliga_tab','camaliga_ekko','camaliga_elastislide','camaliga_fancybox','camaliga_flexslider2','camaliga_flipster','camaliga_fullwidth','camaliga_galleryview','camaliga_innerfade','camaliga_isotope','camaliga_lightslider','camaliga_magnific','camaliga_nanogallery2','camaliga_owl2','camaliga_parallax','camaliga_responsivecarousel','camaliga_roundabout','camaliga_sgallery','camaliga_skdslider','camaliga_slick'];

    /**
     * Table information
     *
     * @var array
     */
    protected $tableData = [];

    /**
     * Flexform information
     *
     * @var array
     */
    protected $flexformData = [];

    /**
     * @var IconFactory
     */
    protected $iconFactory;

    public function __construct(private readonly BackendViewFactory $backendViewFactory)
    {
        $this->iconFactory = GeneralUtility::makeInstance(IconFactory::class);
    }

    public function __invoke(PageContentPreviewRenderingEvent $event): void
    {
        if ($event->getTable() !== 'tt_content') {
            return;
        }
        if (in_array($event->getRecordType(), $this->pis)) {
            $this->tableData = [];
            $pi = substr((string) $event->getRecordType(), strpos((string) $event->getRecordType(), '_')+1);
            $header = '<strong>' . htmlspecialchars((string) $this->getLanguageService()->sL(self::LLPATH . 'template.' . $pi)) . '</strong>';
            $record = $event->getRecord()->getRawRecord()->toArray();
            if (isset($record['pi_flexform'])) {
                $this->flexformData = GeneralUtility::xml2array($record['pi_flexform']);
                $this->getStartingPoint($record['pages']);
            }
            if (is_array($this->flexformData)) {
                foreach ($this->recordMapping as $fieldName => $fieldConfiguration) {
                    $value = $this->getFieldFromFlexform('settings.' . $fieldName);
                    if (isset($value) && $value) {
                        $content = $this->getRecordData($value, $fieldConfiguration['table']);
                        $this->tableData[] = [
                            $this->getLanguageService()->sL(self::LLPATH . 'layout.' . $fieldName),
                            $content
                        ];
                    }
                }
            }
            $event->setPreviewContent($this->renderSettingsAsTable($header, $record['uid']));
        }
    }


    /**
     * Get the rendered page title including onclick menu
     *
     * @param int $id
     * @param string $table
     * @return string
     */
    public function getRecordData($id, $table = 'pages')
    {
        $record = BackendUtilityCore::getRecord($table, $id);

        if (is_array($record)) {
            $data = '<span data-toggle="tooltip" data-placement="top" data-title="id=' . $record['uid'] . '">'
                . $this->iconFactory->getIconForRecord($table, $record, \TYPO3\CMS\Core\Imaging\IconSize::SMALL)->render()
                . '</span> &nbsp;';
            $content = BackendUtilityCore::wrapClickMenuOnIcon($data, $table, $record['uid']);
            $content .= htmlspecialchars(BackendUtilityCore::getRecordTitle($table, $record));
        } else {
            $text = sprintf($this->getLanguageService()->sL(self::LLPATH . 'pagemodule.pageNotAvailable'),
                $id);
            $content = $this->generateCallout($text);
        }

        return $content;
    }

    /**
     * Get the startingpoint
     *
     * @param string $pids
     * @return void
     */
    public function getStartingPoint($pids): void
    {
        if (!empty($pids)) {
            $pageIds = GeneralUtility::intExplode(',', $pids, true);
            $pagesOut = [];

            foreach ($pageIds as $id) {
                $pagesOut[] = $this->getRecordData($id, 'pages');
            }

            $recursiveLevel = (int)$this->getFieldFromFlexform('settings.recursive');
            $recursiveLevelText = '';
            if ($recursiveLevel === 250) {
                $recursiveLevelText = $this->getLanguageService()->sL('LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:recursive.I.5');
            } elseif ($recursiveLevel > 0) {
                $recursiveLevelText = $this->getLanguageService()->sL('LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:recursive.I.' . $recursiveLevel);
            }

            if (!empty($recursiveLevelText)) {
                $recursiveLevelText = '<br />' .
                    $this->getLanguageService()->sL(self::LLPATH . 'recursive') . ' ' .  $recursiveLevelText;
            }

            $this->tableData[] = [
                $this->getLanguageService()->sL(self::LLPATH . 'startingpoint'),
                implode(', ', $pagesOut) . $recursiveLevelText
            ];
        }
    }

    /**
     * Render an alert box
     *
     * @param string $text
     * @return string
     */
    protected function generateCallout($text)
    {
        return '<div class="alert alert-warning">' . htmlspecialchars($text) . '</div>';
    }

    /**
     * Render the settings as table for Web>Page module
     * System settings are displayed in mono font
     *
     * @param string $header
     * @param int $recordUid
     * @return string
     */
    protected function renderSettingsAsTable($header = '', $recordUid = 0)
    {
        $view = $this->backendViewFactory->create($GLOBALS['TYPO3_REQUEST'], ['quizpalme/camaliga']);
        $view->assignMultiple([
            'header' => $header,
            'rows' => [
                'above' => array_slice($this->tableData, 0, self::SETTINGS_IN_PREVIEW),
                'below' => array_slice($this->tableData, self::SETTINGS_IN_PREVIEW)
            ],
            'id' => $recordUid
        ]);
        return $view->render('Backend/PageLayoutView');
    }

    /**
     * Get field value from flexform configuration,
     * including checks if flexform configuration is available
     *
     * @param string $key name of the key
     * @param string $sheet name of the sheet
     * @return string|NULL if nothing found, value if found
     */
    public function getFieldFromFlexform($key, $sheet = 'sDEF')
    {
        $flexform = $this->flexformData;
        if (isset($flexform['data'])) {
            $flexform = $flexform['data'];
            if (isset($flexform) && isset($flexform[$sheet]) && isset($flexform[$sheet]['lDEF'])
                && isset($flexform[$sheet]['lDEF'][$key]) && isset($flexform[$sheet]['lDEF'][$key]['vDEF'])
            ) {
                return $flexform[$sheet]['lDEF'][$key]['vDEF'];
            }
        }

        return null;
    }

    /**
     * Return language service instance
     *
     * @return \TYPO3\CMS\Lang\LanguageService
     */
    public function getLanguageService()
    {
        return $GLOBALS['LANG'];
    }
}