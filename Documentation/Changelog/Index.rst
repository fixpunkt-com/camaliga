.. include:: /Includes.rst.txt


ChangeLog
---------

- Here you find all the changes through the versions.

==========  ==============================================================================================================================
Version     Changes
==========  ==============================================================================================================================
1.0.0       More TypoScript- and FlexForms-Settings. Carousel-Example updated.
1.1.0       More examples added. Karussell-Import improved.
1.2.0       Major bug fixed: wrong path to the templates. More examples added.
1.3.0       S Gallery and jQuery.Flipster template added.
            Template Carousel.html improved.
            More size variables added.
            Bug fixed: you can use the 0 in the FlexForms too.
1.4.0       Update-script added. Execute it, if you have used the categories in Typo3 6.0 or
            6.1, after updating to Typo3 6.2.
            Categories to FlexForms added.
2.0.0       Category localisation. categoryMode to the configuration added.
            {content.categories} renamed to {content.categoriesAndParents}. The first one shows you another list now!
            See chapter Administration/Categories.

            Template-Layouts added: you can use now more layouts in one template (see chapter Page TSconfig).

            3 new fields: phone, mobile and email.

            3 new HTML-Templates (SKDslider, OWL carousel 2, Responsive Carousel).

            Hooks for the extensions linkvalidator and ke_search added.
3.0.0       The category selection works now with all examples and not only with the extended ones.

            8 new fields for the single view: images and their caption.

            Folder-image added.

            Mostly all examples modified (only improvements, e.g. for Bootstrap 3).

            Successfully tested with Typo3 7.0 and the extension compatibility6. Requirements set to Typo3 6.2.2
3.1.0       Template Tab.html (for Bootstrap) and Lightslider.html added.

            Option added: automatic search for Latitude and Longitude.

            Possibility to extend the Camaliga-table-fields.

            Typo3 7 compatibility increased (does still not work with Typo3 7.1).
3.2.0       Bug fixed: tt_news import.
            Typo3 7 compatibility increased.

            New backend form: sortable thumbnail overview.

            New templates: Isotope, jQuery Full Width Image Slider, Coolcarousel.
4.0.0       Template-list in the FlexForms rearranged. Demo-link to the templates added in this documentation.

            New FlexForms for Bootstrap components.

            New templates: slick carousel, Bootstrap Collapse/Accordion, Bootstrap Modal.

            ke_search-Indexer renamed.

            Several improvements (e.g. category-search in the normal templates).
5.0.0       Extended templates can be enabled now by an option. See chapter "Updating to camaliga 5.0.0".

            3 templates are now deprecated. See chapter "Updating to camaliga 5.0.0".

            Brand new: full-text search and proximity search.

            New backend modules: CSV-Import and mv_cooking-Import.

            New options: sort after crdate, settings.limit, settings.extended.*

            New templates: search (see chapter "Administration / Extended templates").

            ke_search-indexer renamed!

            Bug fixed: sorting of categories at normal templates.
6.0.0       Camaliga is now TYPO3 7 LTS compatible:

            - Vendor name changed. You need to flush the general cache.
            - old methods replaced.
            - path to the templates changed: please read the chapter Configuration/TypoScript reference and Updating to camaliga 6.0.0.

            Scheduler-task for CSV export added.

            Deprecated actions and templates removed: galleryviewExtended, adGalleryExtended and mapExtended.
6.0.3       TCA-problem with TYPO3 7 fixed (maybe you need to flush the general cache).

            double7-validator fixed.

            TS settings.googleMapsKey added.
6.0.6       TYPO3 7 bugfix.

            TS added: settings.maps.key, zoom, startLatitude and startLongitude. googleMapsKey removed.
6.1.0       Template Parallax added.

            Update-Script for camaliga-version 6.0.0 added.

            TYPO3 7 related bugfix again. New icon.
6.2.0       TypoScript and FlexForm settings added: settings.more.* Added variables: {contents.moduloBegin}, {contents.moduloEnd}.

            Added templates: Ekko.

            Modified templates: AdGallery, Flexslider2, Galleryview, Parallax, Slick.
            Some of this templates can now be controller by TypoScript or FlexForms too.

            3 templates are now deprecated: AdGalleryFancyBox, GalleryviewFancyBox, OwlSimpleModal. See chapter "Administration/HTML-Templates".

            Bugfix: validation error?
6.3.0       2 ViewHelpers added: content- and addPublicResources-ViewHelper. See chapter Administration/ViewHelper.

            The additional extension camaliga_addon is now available. See chapter Administration/Extend the Camaliga tables.

            Bugfix: minor things.
6.3.1       Bugfix: minor things.
6.4.0       Template Revolution-Slider and FractionSlider added.

            Additional fields can now be disabled in the Extension-Manager.

            Fulltextsearch searches now in custom1 too.

            Some small improvements.
7.0.0       TYPO3 6.2 compatibility removed.

            Templates AdGalleryFancyBox, GalleryviewFancyBox and OwlSimpleModal removed.

            TS seo.*, maps.language, maps.dontIncludeAPI and maps.includeRoute added.

            Partial for route planner added.

            The CSV-import moved to the Scheduler.

            The PicasaWeb-Import removed.

            New db-field: contact-person. More disable-options in the extension-configuration-manager.

            New variable in the templates available: {content.links}
7.1.0       Setting extended.saveSearch added.
            TYPO3 8.7 compatibility added. Note: there is still no way to parse links from TYPO3 8.
7.1.6       Some minor bugs fixed. Some changes in the documentation.
8.0.0       Support for FAL images added. FAL images can be enabled at the configuration in the extension manager.

            All templates updated. E.g. links switched to f:link.typolink.

            The Owl template removed. Use the Owl2 template instead!

            mv_cooking import removed.
8.0.1       Bugs fixed: getImgConfig and tx_camaliga_double7 removed.
8.0.2       Update-script for wrong FAL relations. Please run the update-script in the extension manager if you use FAL.
8.1.0       Scheduler task added: you can now convert uploads-images to FAL-images! Read the chapter Administration → Scheduler-Tasks.

            Layout Backend7.html replaced with Backend.html.

            tx_camaliga_double7 completely removed, because TYPO3 has sometimes a cache-problem with it.
8.2.0       Template Openstreetmap added. Clustering option added. Flexforms for maps added.

            ke_search-Indexer replaced.
8.2.8       TYPO3 8 bugfix.

            The field mother is now lazy.

            Slick template and other things improved.

            The linkvalidator works now.

            Minor bug in addPublicResources ViewHelper fixed.
8.2.9       Geocoding fixed. The geocode feature requires now a google maps api key!

            Elegant Responsive Pure CSS3 Slider added.
8.3.0       Important change: Optimized for TYPO3 8, Bootstrap 4 and jQuery 3.
8.4.0       Now for TYPO3 9 too (if typo3db_legacy is installed).
            TYPO3_DLOG removed. Now only settings.debug enables the debug mode.
            Karussell and tt_news import removed.
8.4.4       TYPO3 9 bugfix.
8.5.0       TYPO3 9 and documentation adjustments. typo3db_legacy still necessary.
9.0.0       Extension configuration categoryMode removed! The categories are now get by a TYPO3 core method.
            Correct ordering of categories in the options.
            TS category.storagePids, category.sortBy and category.orderBy added.
            The field "childs" of {content.categoriesAndParents} is now an array, not a string.
            The repository works now without the typo3db_legacy extension.
9.1.0       New configuration option: actionForLinks (for ke_search).
            Bugfix: the thumbnail-view in the backend-module is now sortable again.
            Bugfix: AddPublicResourcesViewHelper.
            Update-script is now deprecated and will be removed in version 10.0.
9.2.0       slug-field added. If you want to use, you should generate slugs via a scheduler task.

            Switch to the QueryBuilder at the tasks.

            exclude=1 at the backend-fields.

            Bugfix: getLinkResolved.

            Using the uploads-folder is now deprecated and will be removed in version 10.0. Switch to FAL (see Administration/Scheduler)!
9.3.0       Bugfix: categoriesAndParents contains now again deeper parents in the child list.

            Bugfix: extended fields now working again.

            Update-script deleted. Use an older version of camaliga (below 9.2.6) to use it.

            Slug-task: updates now only entries without a slug.

            Now compatible with TYPO3 10.
10.0.0      Support for the uploads-folder removed! Default-mode changed! Switch to FAL before you update.

            Magnific Popup-template added.

            Revolution- and scrollable-template removed. (Use fp_fractionslider instead.)
10.1.0      Evaluation for coordinates added again.

            Get geocode now with file_get_contents instead of curl.

            Debug-output now in the template. Deprecated DevLog removed.

            Templates changed: new partials.

            TCA-Bugfix for TYPO3 10.
10.2.0      New and create action added.

            The test-class uses now PHPUnit.
10.3.0      Layout of list templates changed. Using now div instead of table.

            Teaser template added.

            The fields crdate, tstamp and sorting can be used now in the FE-templates too.
10.4.0      Settings extended.template added.

            ke-search hook updated.

            AddPublicResourcesViewHelper: addSlash-argument activated again.

            TCA-Bugfix for TYPO3 10.
11.0        Now for TYPO3 11.3 too. Support for TYPO3 9 dropped.

            Using the Openstreetmap-API for finding a position is now possible too.

            Breaking: Template Fractionslider removed (use fp_fractionslider instead)! Template nanogallery2 added.

            Breaking: Slug-task replaced with a Slug-command. You should delete the task before updating.
            Otherwise you need to execute "Rebuild PHP Autoload Information" after the update.

            Breaking: the old variable {fal} removed.

            Bugfix: don´t ignore selected pages on category-search.
11.0.3      Bugfix for TYPO3 11.5.0.

            Folder css renamed to Css!

            ListExtended-Template: the search uses now the search-action too.
11.1        Replacement of the Viewhelper cam:addPublicResources. It is now deprecated. Use f:asset.css or f:asset.script instead.

            New method for changing the page title and metatags. Utility PageTitle removed.

            Bugfix for TYPO3 11 (e.g. backend-layout adapted for TYPO3 11.) and PHP 8.

11.2        The ke_search Indexer needs now at least ke_search version 4.0.0.

            searchCoordinatesInBE added to the extension configuration. Searching for coordinates is now possible in the BE too.

            Important refactoring: clearing cache is necessary after update!

            Bugfix for PHP 8.

11.3        Setting extendedCategoryMode added. Empty category entries will be ignored at the search options.

            Bugfix: metadata for images now working again.

            Bugfix: don´t ignore given storage PIDs in the show actions. Prevent viewing all camaliga-entries at one place.

12.0        Breaking: all plugins must be changed via an update-script (in the install-tool)!

            Breaking: the Viewhelper cam:addPublicResources was removed.

            Breaking: removed the templates AdGallery, Coolcarousel and Test.

            Breaking: the slug-task was removed.

            New configuration option: pluginForLinks (for ke_search).

            Note: if you use own templates, you need to add e.g. pluginName="show" to links to single-pages if pageUid="{settings.showId}"
            is set.

12.0.3      Allow the show-action at a showExtended-plugin. Allow the search-action at a map-plugin.

            Bugfix: plugin-updater.

12.1.0      Important change: the Bootstrap templates supports now Bootstrap 5 instead of Bootstrap 4.

13.0.0      Refactored with the rector tool.

            Setting errorId added: if no uid given, a redirect to an error page can be configured.

            Ignore validation in show and showExtended action removed!

13.0.3      Sorting in the backend module works now again.

            Bugfix: backend preview.

            Bugfix: old TYPO3 fields removed.

13.0.5      Bugfix: data handler hook.

            Bugfix for sql_mode=only_full_group_by.

13.0.6      Bugfix: prevent warnings.

13.1.0      First version for TYPO3 13.

            SwitchableControllerActionsPluginUpdater (update script) removed.

13.1.1/2    Bugfix: tasks fixed for TYPO3 13.

13.1.3      Bugfix: plugin wizard.

13.1.4/5    Documentation.

13.2.0      Refactoring. You need to use "Flush TYPO3 and PHP Cache"!

13.2.2      New home url: https://github.com/fixpunkt-com/camaliga

            Bugfix: don´t show every category if there is no category at the result list.

13.2.3      Bugfix: fancybox-action repaired.

13.2.5      Upgrade script added again.
==========  ==============================================================================================================================
