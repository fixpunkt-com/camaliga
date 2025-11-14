<?php

declare(strict_types=1);

/*
 * This file is part of the Extension "plain_faq" for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Quizpalme\Camaliga\Upgrades;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Service\FlexFormService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

#[UpgradeWizard('camaliga_switchablecontrolleractionsplugin')]
class SwitchableControllerActionsPluginUpdater implements UpgradeWizardInterface {
    private const MIGRATION_SETTINGS = [
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->carousel',
            'targetListType' => 'camaliga_carousel',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->carouselSeparated',
            'targetListType' => 'camaliga_carouselseparated',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->list;Content->search;Content->show',
            'targetListType' => 'camaliga_list',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->listExtended;Content->search;Content->showExtended',
            'targetListType' => 'camaliga_listextended',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->show',
            'targetListType' => 'camaliga_show',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->showExtended',
            'targetListType' => 'camaliga_showextended',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->show;Content->showExtended',
            'targetListType' => 'camaliga_showextended',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->map;Content->search;Content->show',
            'targetListType' => 'camaliga_map',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->search;Content->showExtended',
            'targetListType' => 'camaliga_search',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->openstreetmap;Content->search;Content->show',
            'targetListType' => 'camaliga_openstreetmap',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->random',
            'targetListType' => 'camaliga_random',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->responsive',
            'targetListType' => 'camaliga_responsive',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->teaser;Content->show',
            'targetListType' => 'camaliga_teaser',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->elegant',
            'targetListType' => 'camaliga_elegant',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->new;Content->create',
            'targetListType' => 'camaliga_new',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->bootstrap;Content->search;Content->show',
            'targetListType' => 'camaliga_bootstrap',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->collapse;Content->search;Content->show',
            'targetListType' => 'camaliga_collapse',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->modal;Content->search;Content->show',
            'targetListType' => 'camaliga_modal',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->tab;Content->search;Content->show',
            'targetListType' => 'camaliga_tab',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->ekko;Content->search;Content->show',
            'targetListType' => 'camaliga_ekko',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->elastislide;Content->search;Content->show',
            'targetListType' => 'camaliga_elastislide',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->fancyBox;Content->search;Content->show',
            'targetListType' => 'camaliga_fancybox',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->flexslider2;Content->search;Content->show',
            'targetListType' => 'camaliga_flexslider2',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->flipster;Content->search;Content->show',
            'targetListType' => 'camaliga_flipster',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->fullwidth;Content->search;Content->show',
            'targetListType' => 'camaliga_fullwidth',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->galleryview;Content->search;Content->show',
            'targetListType' => 'camaliga_galleryview',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->innerfade;Content->search;Content->show',
            'targetListType' => 'camaliga_innerfade',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->isotope;Content->search;Content->show',
            'targetListType' => 'camaliga_isotope',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->lightslider;Content->search;Content->show',
            'targetListType' => 'camaliga_lightslider',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->magnific;Content->search;Content->show',
            'targetListType' => 'camaliga_magnific',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->nanogallery2;Content->search;Content->show',
            'targetListType' => 'camaliga_nanogallery2',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->owl2;Content->search;Content->show',
            'targetListType' => 'camaliga_owl2',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->parallax;Content->search;Content->show',
            'targetListType' => 'camaliga_parallax',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->responsiveCarousel;Content->search;Content->show',
            'targetListType' => 'camaliga_responsivecarousel',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->roundabout;Content->search;Content->show',
            'targetListType' => 'camaliga_roundabout',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->sgallery;Content->search;Content->show',
            'targetListType' => 'camaliga_sgallery',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->skdslider;Content->search;Content->show',
            'targetListType' => 'camaliga_skdslider',
        ],
        [
            'sourceListType' => 'camaliga_pi1',
            'switchableControllerActions' => 'Content->slick;Content->search;Content->show',
            'targetListType' => 'camaliga_slick',
        ]
    ];

    protected FlexFormService $flexFormService;

    public function __construct()
    {
        $this->flexFormService = GeneralUtility::makeInstance(FlexFormService::class);
    }

    public function getIdentifier(): string
    {
        return 'camaliga_switchablecontrolleractionsplugin';
    }

    public function getTitle(): string
    {
        return 'Migrates plugin and settings of existing camaliga plugins using switchableControllerActions';
    }

    public function getDescription(): string
    {
        $description = 'The old camaliga plugin using switchableControllerActions has been split into separate plugins. ';
        $description .= 'This update wizard migrates all existing plugin settings and changes the Plugin (list_type) ';
        $description .= 'to use the new plugins available.';
        return $description;
    }

    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class,
        ];
    }

    public function updateNecessary(): bool
    {
        return $this->checkIfWizardIsRequired();
    }

    public function executeUpdate(): bool
    {
        return $this->performMigration();
    }

    public function checkIfWizardIsRequired(): bool
    {
        return count($this->getMigrationRecords()) > 0;
    }

    public function performMigration(): bool
    {
        $records = $this->getMigrationRecords();

        foreach ($records as $record) {
            $flexFormData = GeneralUtility::xml2array($record['pi_flexform']);
            $flexForm = $this->flexFormService->convertFlexFormContentToArray($record['pi_flexform']);
            $targetListType = $this->getTargetListType(
                $record['list_type'],
                $flexForm['switchableControllerActions']
            );
            $allowedSettings = $this->getAllowedSettingsFromFlexForm($targetListType);

            // Remove flexform data which do not exist in flexform of new plugin
            foreach ($flexFormData['data'] as $sheetKey => $sheetData) {
                foreach ($sheetData['lDEF'] as $settingName => $setting) {
                    if (!in_array($settingName, $allowedSettings, true)) {
                        unset($flexFormData['data'][$sheetKey]['lDEF'][$settingName]);
                    }
                }

                // Remove empty sheets
                if (!count($flexFormData['data'][$sheetKey]['lDEF']) > 0) {
                    unset($flexFormData['data'][$sheetKey]);
                }
            }

            if (count($flexFormData['data']) > 0) {
                $newFlexform = $this->array2xml($flexFormData);
            } else {
                $newFlexform = '';
            }

            $this->updateContentElement($record['uid'], $targetListType, $newFlexform);
        }

        return true;
    }

    protected function getMigrationRecords(): array
    {
        $checkListTypes = array_unique(array_column(self::MIGRATION_SETTINGS, 'sourceListType'));

        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $connectionPool->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));

        $checkListTypesNamed = [];
        foreach ($checkListTypes as $checkListType) {
            $checkListTypesNamed[] = $queryBuilder->createNamedParameter($checkListType);
        }

        return $queryBuilder
            ->select('uid', 'list_type', 'pi_flexform')
            ->from('tt_content')
            ->where(
                $queryBuilder->expr()->in(
                    'list_type',
                    $checkListTypesNamed
                )
            )
            ->executeQuery()
            ->fetchAllAssociative();
    }

    protected function getTargetListType(string $sourceListType, string $switchableControllerActions): string
    {
        foreach (self::MIGRATION_SETTINGS as $setting) {
            if ($setting['sourceListType'] === $sourceListType &&
                $setting['switchableControllerActions'] === $switchableControllerActions
            ) {
                return $setting['targetListType'];
            }
        }

        return '';
    }

    protected function getAllowedSettingsFromFlexForm(string $listType): array
    {
        $settings = [];
        $flexFormFile = $GLOBALS['TCA']['tt_content']['columns']['pi_flexform']['config']['ds'][$listType . ',list'];
        if ($flexFormFile) {
            $flexFormContent = file_get_contents(GeneralUtility::getFileAbsFileName(substr(trim($flexFormFile), 5)));
            $flexFormData = GeneralUtility::xml2array($flexFormContent);

            // Iterate each sheet and extract all settings
            foreach ($flexFormData['sheets'] as $sheet) {
                foreach ($sheet['ROOT']['el'] as $setting => $tceForms) {
                    $settings[] = $setting;
                }
            }
        }
        return $settings;
    }

    /**
     * Updates list_type and pi_flexform of the given content element UID
     *
     * @param int $uid
     * @param string $newListType
     * @param string $flexform
     */
    protected function updateContentElement(int $uid, string $newListType, string $flexform): void
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        $queryBuilder->update('tt_content')
            ->set('list_type', $newListType)
            ->set('pi_flexform', $flexform)
            ->where(
                $queryBuilder->expr()->in(
                    'uid',
                    $queryBuilder->createNamedParameter($uid, Connection::PARAM_INT)
                )
            )
            ->executeStatement();
    }

    /**
     * Transforms the given array to FlexForm XML
     *
     * @param array $input
     * @return string
     */
    protected function array2xml(array $input = []): string
    {
        $options = [
            'parentTagMap' => [
                'data' => 'sheet',
                'sheet' => 'language',
                'language' => 'field',
                'el' => 'field',
                'field' => 'value',
                'field:el' => 'el',
                'el:_IS_NUM' => 'section',
                'section' => 'itemType',
            ],
            'disableTypeAttrib' => 2,
        ];
        $spaceInd = 4;
        $output = GeneralUtility::array2xml($input, '', 0, 'T3FlexForms', $spaceInd, $options);
        $output = '<?xml version="1.0" encoding="utf-8" standalone="yes" ?>' . LF . $output;
        return $output;
    }
}