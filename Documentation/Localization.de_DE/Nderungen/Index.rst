.. include:: /Includes.rst.txt

Änderungen
----------

- Hier findet man die Änderungen...

==========  =====================================================================================================================
Version     Änderungen
==========  =====================================================================================================================
1.0.0       Mehr TypoScript- und FlexForm-Einstellungen. Karussell-Beispiel upgedatet.
1.1.0       Einige Beispiele hinzugefügt. Karussell-Import verbessert.
1.2.0       Schwerer Bug gefixt: falscher Pfad zu den Templates. Einige Beispiele hinzugefügt.
1.3.0       S Gallery und jQuery.Flipster Template hinzugefügt.
            Template Carousel.html verbessert.
            Weitere Größen-Variablen hinzugefügt.
            Bug gefixt: man kann die 0 auch in den FlexForms benutzen.
1.4.0       Update-Skript hinzugefügt. Bitte nach einen Update auf Typo3 6.2 ausführen,
            falls man in der Version 6.0 oder 6.1 Kategorien benutzt hat!
            Kategorien zu den FlexForms hinzugefügt.
2.0.0       Die Kategorie-Ausgabe ist nun sprachabhängig. categoryMode-Einstellung hinzugefügt.
            {content.categories} wurde in {content.categoriesAndParents} umbenannt. Ersteres liefert nun eine andere Liste!
            Siehe Kapitel Administration/Kategorien.

            Template-Layouts hinzugefügt: damit man mehrere Layouts in einem Template verwenden kann
            (siehe Kapitel Seiten-TSconfig).

            3 neue Felder hinzugefügt: Telefon, Handy und E-Mail.

            3 neue HTML-Templates hinzugefügt (SKDslider, OWL carousel 2, Responsive Carousel).

            Hooks für die Extensions linkvalidator und ke_search hinzugefügt.
3.0.0       Die Kategorien-Suche läuft nun mit allen Templates, nicht nur mit den erweiterten Templates.

            Neue Felder: 4 weitere Bilder mit Beschreibung für die Detail-Ansicht.

            Ordner-Bild hinzugefügt.

            Fast alle Templates wurden verbessert (z.B. optimiert für Bootstrap 3).

            Erfolgreich getestet mit Typo3 7.0 und der Extension compatibility6. Min. Voraussetzung auf Typo3 6.2.2
            geändert.
3.1.0       Template Tab.html (für Bootstrap) und Lightslider.html hinzugefügt.

            Option hinzugefügt: automatische Suche nach Latitude und Longitude.

            Möglichkeit eingebaut, die Camaliga-Tabelle zu erweitern.

            Typo3 7 Kompatibilität erhöht (läuft noch nicht ganz mit Typo3 7.1).
3.2.0       Bug gefixt: Fehler beim tt_news-Import.
            Typo3 7 Kompatibilität erhöht.

            Neues Backend-Formular: sortierbare Bilderübersicht.

            Neue Templates: Isotope, jQuery Full Width Image Slider, Coolcarousel.
4.0.0       Template-Liste in den FlexForms anders sortiert/gegliedert. Demo-Link zu den Templates in diese Doku eingebaut.

            Neue Templates: slick carousel, Bootstrap Collapse/Accordion, Bootstrap Modal.

            Neue FlexForms für die Konfiguration der 4 Bootstrap-Templates.

            Zahlreiche Verbesserungen (z.B. bei der Suche nach Kategorien bei normalen Templates).
5.0.0       Erweiterte Templates können nun durch eine Option eingeschaltet werden. Siehe Kapitel "Updaten auf camaliga 5.0.0".

            3 Templates sind nun veraltet und sollten nicht mehr benutzt werden. Siehe Kapitel "Updaten auf camaliga 5.0.0".

            Neue Backend-Module: CSV-Import und mv_cooking-Import.

            Brandneu: Volltextsuche und Umkreissuche.

            Neue Optionen: Sortierung nach crdate, settings.limit, settings.extended.*

            Neue Templates: search (siehe Kapitel "Administration / Erweiterte Templates").

            ke_search-Indexer umbenannt.

            Bug gefixt: Sortierung bei normalen Templates mit Kategorien.
6.0.0       Camaliga ist nun TYPO3 7 LTS kompatibel:

            - Vendor-Name geändert -> man muss nach dem Updaten den allgemeinen Cache löschen!
            - alte Methoden ersetzt.
            - Pfad zu den Templates geändert -> siehe Kapitel Konfiguration/TypoScript-Referenz und Updaten auf camaliga 6.0.0.

            Planer-Task für CSV-Export hinzugefügt.

            Veraltete actions und Templates entfernt: galleryviewExtended, adGalleryExtended und mapExtended.
6.0.3       TCA-Problem mit TYPO3 7 gefixt (evt. den allg. Cache löschen).

            double7-Validator gefixt.

            TS settings.googleMapsKey hinzugefügt.
6.0.6       TYPO3 7 Bugfix.

            TS hinzugefügt: settings.maps.key, zoom, startLatitude und startLongitude. googleMapsKey wieder entfernt.
6.1.0       Template Parallax hinzugefügt.

            Update-Skript für camaliga 6.0.0 hinzugefügt.

            TYPO3 7 Bugfix und neues Icon.
6.2.0       TypoScript und FlexForm hinzugefügt: settings.more.* Variablen hinzugefügt: {contents.moduloBegin}, {contents.moduloEnd}.

            Template hinzugefügt: Ekko.

            Geänderte Templates: AdGallery, Flexslider2, Galleryview, Parallax, Slick.
            Die meisten dieser Templates können nun per TypoScript oder FlexForms gesteuert werden.

            3 Templates sind nun veraltet: AdGalleryFancyBox, GalleryviewFancyBox, OwlSimpleModal.
            Siehe Kapitel "Administration/HTML-Templates".

            Bugfix: Validation-Fehlermeldung?
6.3.0       2 ViewHelper hinzugefügt: content- und addPublicResources-ViewHelper. Siehe Kapitel "Administration/ViewHelpers".

            Die zusätzliche Extension camaliga_addon ist nun verfügbar. Siehe Kapitel "Administration/Camaliga-Tabellen erweitern".

            Bugfix: Kleinigkeiten.
6.3.1       Bugfix: Kleinigkeiten.
6.4.0       Template Revolution-Slider und FracionSlider hinzugefügt.

            Optionale Felder können nun auch im Extension-Manager ausgeblendet werden.

            Die Volltextsuche sucht jetzt auch in custom1.

            Kleinere Optimierungen.
7.0.0       TYPO3 6.2 Kompatibilität entfernt.

            Die Templates AdGalleryFancyBox, GalleryviewFancyBox und OwlSimpleModal entfernt.

            TS seo.*, maps.language, maps.dontIncludeAPI und maps.includeRoute hinzugefügt.

            Partial für eine Routenplannung hinzugefügt.

            Den CSV-Import verschoben. Neuer Ort: Scheduler.

            Den PicasaWeb-Import entfernt, da es PicasaWeb nicht mehr gibt.

            Neues DB-Feld: Kontaktperson. Mehr Ausschalt-Optionen bei der Konfiguration im Extension-Manager.

            Neue Variable in den Templates verfügbar: {content.links}
7.1.0       Setting extended.saveSearch hinzugefügt.
            TYPO3 8.7 Kompatibilität hinzugefügt. Achtung: von TYPO3 8.7 erzeugte Links können noch nicht ausgewertet werden.
7.1.6       Kleinere Bugs gefixt. Kleinere Änderungen in dieser Doku.
8.0.0       Man kann nun auch FAL-Bilder benutzen. Diese können in der Konfiguration im Extension Manager eingeschaltet werden.

            Alle Templates aktualisiert. Z.B. alle Links zu f:link.typolink geändert.

            Das Owl-Template gelöscht. Nutze stattdessen das Owl2-Template.

            mv_cooking import removed.
8.0.1       Bugs gefixt: getImgConfig und tx_camaliga_double7 entfernt.
8.0.2       Update-Skript für falsche FAL-Relationen.
            Bitte das Aktualisierungs-Skript im Extension-Manager benutzen, falls schon FAL benutzt wird.
8.1.0       Planer-Task hinzugefügt: man kann jetzt uploads-Bilder zu FAL-Bildern konvertieren.
            Lies auch das Kapitel Administration → Scheduler-Tasks dazu.

            Layout Backend7.html durch Backend.html ersetzt.

            tx_camaliga_double7 endgültig entfernt, da TYPO3 sich manchmal daran störte (Cache-Problem).
8.2.0       Template Openstreetmap hinzugefügt. Clustering-Option für Karten hinzugefügt. Flexforms für Karten hinzugefügt.

            Den ke_search-Indexer ausgetauscht (neue Variante).
8.2.8       TYPO3 8 Bugfix.

            Das mother-Feld ist nun lazy.

            Das Slick-Template und anderes verbessert.

            Der Linkvalidator sollte nun funktionieren mit Camaliga-Elementen.

            Kleiner Bug im addPublicResources ViewHelper gefixt.
8.2.11      Geocoding fixed. Für das Feature "automatisch die Position zu einer Adresse finden" braucht man nun einen Google
            maps API key! Die bisherige Lösung funktionierte nicht mehr!

            Elegant Responsive Pure CSS3 Slider hinzugefügt.
8.3.0       Wichtige Änderung: Optimierung für TYPO3 8, Bootstrap 4 und jQuery 3.
8.4.0       Jetzt auch für TYPO3 9 (wenn typo3db_legacy installiert ist).
            TYPO3_DLOG entfernt. Nur noch settings.debug aktiviert den debug mode.
            Karusell- und tt_news-import entfernt.
8.4.4       TYPO3 9 Bugfix.
8.5.0       Anpassungen an TYPO3 9 und die neue Dokumentation-Struktur bei typo3.org. typo3db_legacy noch notwendig.
9.0.0       Extension-Konfiguration categoryMode entfernt! Die Kategorien werden nun durch eine TYPO3-Core-Methode geholt!
            Die Kategorien in den Optionen werden nun richtig sortiert.
            TS category.storagePids, category.sortBy und category.orderBy hinzugefügt.
            Das Feld "childs" von {content.categoriesAndParents} ist jetzt ein Array und kein String mehr.
            Siehe Kapitel "Updaten auf Camaliga 9.0.0".
            Das Repository läuft nun auch ohne die Extension typo3db_legacy.
9.1.0       Neue Konfigurationsmöglichkeit: actionForLinks (für ke_search).
            Bugfix: Thumbnail-Ansicht im Backend kann wieder sortiert werden.
            Bugfix: AddPublicResourcesViewHelper.
            Deprecation: das Update-Skript wird in Version 10 entfernt.
9.2.0       slug-Feld hinzugefügt. Bevor man es benutzt, sollte man den zugehörigen Scheduler-Task ausführen.

            Wechsel zum QueryBuilder bei den Tasks.

            exclude=1 bei den Backend-Feldern.

            Bugfix: getLinkResolved.

            Deprecation: der uploads-Ordner wird ab Version 10 nicht mehr unterstützt! Wechsele zu FAL (siehe Admin./Scheduler)!
9.3.0       Bugfix: categoriesAndParents enthält nun wieder auch tiefer gelegene "parents" bei den "childs".

            Bugfix: erweiterte Felder funktionieren nun wieder.

            Update-Skript gelöscht! Benutze eine ältere Camaliga-Version (unter 9.2.6), falls es noch benötigt wird.

            Slug-Task: es werden nun nur Einträge ohne Slug aktualisiert.

            Jetzt TYPO3 10 kompatibel.
10.0.0      Support für den uploads-Ordner gelöscht. Default-Verhalten geändert! Wechsele zu FAL vor dem Update.

            Magnific Popup-Template hinzugefügt.

            Revolution- und Scrollable-Template gelöscht. Benutze evtl. die Extension fp_fractionslider stattdessen.
10.1.0      Eval für Koordinaten erneut hinzugefügt.

            Geocode benutzt nun file_get_contents anstatt curl.

            Templates geändert: neue Partials eingebaut.

            Debug-Ausgabe jetzt im Template. DevLog-Aufruf entfernt.

            TCA-Bugfix für TYPO3 10.
10.2.0      New und create action hinzugefügt.

            Die Test-Klasse nutzt nun PHPUnit.
10.3.0      Layout der List-Templates geändert. Jetzt mit div statt table.

            Teaser-Template hinzugefügt.

            Die Felder crdate, tstamp und sorting können nun in FE-Templates benutzt werden.
10.4.0      Settings extended.template hinzugefügt.

            ke-search Hook aktualisiert.

            AddPublicResourcesViewHelper: addSlash-argument erneut aktiviert.

            TCA-Bugfix für TYPO3 10.
11.0        Erste Version für TYPO3 11. Kein Support mehr für TYPO3 9.

            Positionsbestimmung mittels Openstreetmap-API ist nun auch möglich.

            Breaking: Template Fractionslider entfernt! Dafür das Template Nanogallery2 hinzugefügt.

            Breaking: den Slug-Task durch einen Slug-Command ersetzt. Man sollte den Task vor dem Update löschen.
            Andernfalls muss man "Rebuild PHP Autoload Information" ausführen.

            Breaking: die nicht mehr benötigte Variable {fal} entfernt.

            Bugfix: ignoriere nicht die ausgewählten Ordner (Datensatzsammlung) bei einer Kategorien-Suche.
11.0.3      Bugfix für TYPO3 11.5.0.

            Ordner css nach Css umbenannt!

            ListExtended-Template: die Suche nutzt jetzt auch die search-Action.
11.1        Den Viewhelper cam:addPublicResources ersetzt (da "deprecated"). Benutze f:asset.css oder f:asset.script stattdessen.

            Neue Methode zum ändern des Seitentitels und der Metatags. Utility PageTitle entfernt.

            Bugfix für TYPO3 11 (z.B. das Backend-Layout an TYPO3 11 angepasst) und PHP 8.

11.2        Der ke_search Indexer braucht nun mind. ke_search Version 4.0.0.

            searchCoordinatesInBE hinzugefügt zur Extension-Konfiguration. Damit kann man die Suche nach den Koordinaten einer Adresse im Backend einschalten.

            Refactoring. Wichtig: der System-Cache muss nach dem Update geleert werden!

            Bugfix für PHP 8.

11.3        Setting extendedCategoryMode hinzugefügt. Leere Kategorie-Einträge werden nun beim Suchformular ignoriert.

            Bugfix: Metadaten der Bilder werden nun wieder richtig ausgegeben.

            Bugfix: ignoriere die Datensatzsammlung nicht. Verhindert, dass man sich alle Camaliga-Elemente ansehen kann.

12.0        Breaking: alle Plugins müssen per Update-Skript (im Install-Tool) umgestellt werden!

            Breaking: der Viewhelper cam:addPublicResources wurde entfernt.

            Breaking: die Templates AdGallery, Coolcarousel und Test wurden entfernt.

            Breaking: der Slug-Task wurde gelöscht.

            Neue Konfigurationsmöglichkeit: pluginForLinks (für ke_search).

            Achtung: wenn man eigene Templates benutzt, muss man z.B. pluginName="show" zu Links zu Single-Seiten hinzufügen,
            falls man pageUid="{settings.showId}" benutzt.

12.0.3      Die show-/search-action ist nun in einem showExtended/map-Plugin auch erlaubt.

            Bugfix: Plugin-Updater.

12.1.0      Wichtige Änderung: die Bootstrap-Templates unterstützen nun Bootstrap 5 statt Bootstrap 4.

13.0.0      Refactored mit dem rector-Tool.

            Setting errorId ist neu: wenn keine uid angegeben ist, kann eine Weiterleitung eingerichtet werden.

            Ignore validation in der show- und showExtended-action entfernt!

13.0.3      Sortierung im Backend-Modul klappt wieder.

            Bugfix: Backend-Vorschau.

            Bugfix: von TYPO3 entfernte Felder entfernt.

13.0.5      Bugfix: data handler hook.

            Bugfix für sql_mode=only_full_group_by.

13.0.6      Bugfix: Warnungen verhindern.

13.1.0      Erste Version für TYPO3 13.

            SwitchableControllerActionsPluginUpdater (Update-Skript) wieder entfernt.

13.1.1/2    Bugfix: Tasks fixed für TYPO3 13.

13.1.3      Bugfix: Plugin-Wizard.

13.1.4/5    Dokumentation.

13.2.0      Refactoring. Man muss alle Caches leeren!

13.2.2      Neue Adresse: https://github.com/fixpunkt-com/camaliga

            Bugfix: zeige bei Ergebnissen nicht jede Kategorie an, wenn keine Kategorie da ist.

13.2.3      Bugfix: fancybox-Action repariert.

13.2.5/6    Upgrade-Skript erneut hinzugefügt.

13.3.0      Update-Skript für list_type nach CType Konvertierung hinzugefügt.

14.0.0      Erste Version für TYPO3 14.

            Upgrade-Skripte wieder entfernt. Backend-Modul zurückgebaut.
==========  =====================================================================================================================
