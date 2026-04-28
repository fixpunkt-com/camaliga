.. include:: /Includes.rst.txt


Page TSconfig
^^^^^^^^^^^^^

- You can use the Page TSconfig to configure the backend. E.g. you can define some template layouts.

Example
~~~~~~~

Here an example with 3 layouts for your templates:

::

  tx_camaliga.templateLayouts {
    0 = Standard-Layout
    1 = Layout for the left column
    2 = Layout for the right column
  }


- You can use every number and description for the layouts.
- Now you can select a layout in the FlexForm of every page.
- Finally you can use now different layouts in your templates.

Example
~~~~~~~

Here an example for a template (extract) with 2 layouts:

::

	<f:if condition="{settings.templateLayout} == 1">
		<f:then>
			<h3>{content.title}</h3>
		</f:then>
		<f:else>
			<p>Phone: {content.phone}<br />
			Mobile: {content.mobile}<br />
			Email: <a href="mailto:{content.email}">{content.email}</a></p>
		</f:else>
	</f:if>

- Furthermore you can use TSconfig to rename or hide camaliga-fields. Here two important examples:

::

   TCEFORM.tx_camaliga_domain_model_content.custom2.disabled = 1
   TCEFORM.tx_camaliga_domain_model_content.custom1.label = Date:

.. figure:: /Images/camaliga_tsconfig.png
   :width: 100%

   *Image 17: You find this on the Ressources tab of a page*

- Furthermore you can use TSconfig to hide/remove FlexForm-settings. Example that wont work anymore:

::

	TCEFORM {
		tt_content {
			pi_flexform {
				camaliga_pi1 {
					sDEF {
						switchableControllerActions.removeItems = Content->adGallery;Content->search;Content->show,Content->coolcarousel;Content->search;Content->show,Content->ekko;Content->search;Content->show,Content->elastislide;Content->search;Content->show,Content->fancyBox;Content->search;Content->show,Content->flipster;Content->search;Content->show,Content->fractionSlider;Content->search;Content->show,Content->fullwidth;Content->search;Content->show,Content->galleryview;Content->search;Content->show
					}
					sMORE {
						settings\.more\.setModulo.disabled = 1
						settings\.more\.slidesToShow.disabled = 1
						settings\.more\.slidesToScroll.disabled = 1
					}
				}
			}
		}
	}

Note: from Camaliga 12 you must replace camaliga_pi1 with the used Plugin type, e.g. camaliga_list.
And there is no field switchableControllerActions anymore.
