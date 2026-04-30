.. include:: /Includes.rst.txt


ViewHelpers
^^^^^^^^^^^

- Camaliga comes with one ViewHelper: one for the camaliga content and the one to include JS- or CSS-files was removed.

- The ViewHelper for the camaliga content can be used at single pages. Why?
  If you want to display camaliga-content on different places on your page, you can use this ViewHelper in your
  page-template to display some informations. You can use it like this in your page-template::

    {namespace cam=Quizpalme\Camaliga\ViewHelpers}

  And later on::

    <cam:content param="<h1>camaliga_title</h1><br><small>camaliga_shortdesc</small>" />

  You can use this variables in the param-parameter:
  camaliga_title, camaliga_shortdesc, camaliga_link, camaliga_image, camaliga_street, camaliga_zip, camaliga_city, camaliga_country,
  camaliga_phone, camaliga_mobile, camaliga_email, camaliga_latitude, camaliga_longitude, camaliga_custom1, camaliga_custom_2, camaliga_custom3.
