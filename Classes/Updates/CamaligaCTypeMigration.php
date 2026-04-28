<?php


declare(strict_types=1);

namespace Quizpalme\Camaliga\Updates;

use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\AbstractListTypeToCTypeUpdate;

#[UpgradeWizard('camaligaCTypeMigration')]
final class CamaligaCTypeMigration extends AbstractListTypeToCTypeUpdate
{
    public function getTitle(): string
    {
        return 'Migrate "Camaliga" plugins to content elements.';
    }

    public function getDescription(): string
    {
        return 'The "Camaliga" plugins are now registered as content element. Update migrates existing records and backend user permissions.';
    }

    /**
     * This must return an array containing the "list_type" to "CType" mapping
     *
     * @return array<string, string>
     */
    protected function getListTypeToCTypeMapping(): array
    {
        return [
            'camaliga_carousel' => 'camaliga_carousel',
            'camaliga_carouselseparated' => 'camaliga_carouselseparated',
            'camaliga_list' => 'camaliga_list',
            'camaliga_listextended' => 'camaliga_listextended',
            'camaliga_show' => 'camaliga_show',
            'camaliga_showextended' => 'camaliga_showextended',
            'camaliga_map' => 'camaliga_map',
            'camaliga_search' => 'camaliga_search',
            'camaliga_openstreetmap' => 'camaliga_openstreetmap',
            'camaliga_random' => 'camaliga_random',
            'camaliga_responsive' => 'camaliga_responsive',
            'camaliga_teaser' => 'camaliga_teaser',
            'camaliga_elegant' => 'camaliga_elegant',
            'camaliga_new' => 'camaliga_new',
            'camaliga_bootstrap' => 'camaliga_bootstrap',
            'camaliga_collapse' => 'camaliga_collapse',
            'camaliga_modal' => 'camaliga_modal',
            'camaliga_tab' => 'camaliga_tab',
            'camaliga_ekko' => 'camaliga_ekko',
            'camaliga_elastislide' => 'camaliga_elastislide',
            'camaliga_fancybox' => 'camaliga_fancybox',
            'camaliga_flexslider2' => 'camaliga_flexslider2',
            'camaliga_flipster' => 'camaliga_flipster',
            'camaliga_fullwidth' => 'camaliga_fullwidth',
            'camaliga_galleryview' => 'camaliga_galleryview',
            'camaliga_innerfade' => 'camaliga_innerfade',
            'camaliga_isotope' => 'camaliga_isotope',
            'camaliga_lightslider' => 'camaliga_lightslider',
            'camaliga_magnific' => 'camaliga_magnific',
            'camaliga_nanogallery2' => 'camaliga_nanogallery2',
            'camaliga_owl2' => 'camaliga_owl2',
            'camaliga_parallax' => 'camaliga_parallax',
            'camaliga_responsivecarousel' => 'camaliga_responsivecarousel',
            'camaliga_roundabout' => 'camaliga_roundabout',
            'camaliga_sgallery' => 'camaliga_sgallery',
            'camaliga_skdslider' => 'camaliga_skdslider',
            'camaliga_slick' => 'camaliga_slick'
        ];
    }
}
