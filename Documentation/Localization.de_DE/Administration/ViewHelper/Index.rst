.. include:: /Includes.rst.txt


ViewHelpers
^^^^^^^^^^^

- Camaliga besitzt(e) einen ViewHelper für Camaliga-Elemente und einen ViewHelper, der gelöscht wurde, um JS- oder CSS-Dateien zu laden.

- Den ViewHelper für Camaliga-Elemente kann man bei Seiten-Templates benutzen. Wozu?
  Nun, wenn man Infos eines Elements an verschiedenen Stellen darstellen will, muss man nicht mehrere Plugins benutzen.
  Stattdessen kann man auch das Seiten-Template anpassen und dort diesen ViewHelper benutzen.
  Das ganze funktioniert freilich nur auf Camaliga-Single-Seiten und ist nützlich, wenn man z.B. den Titel
  in einem Jumbotron darstellen will. Man kann den ViewHelper wie folgt im Seiten-Template benutzen. Am Anfang::

    {namespace cam=Quizpalme\Camaliga\ViewHelpers}

  Und weiter unten::

    <cam:content param="<h1>camaliga_title</h1><br><small>camaliga_shortdesc</small>" />

  Man kann diese param-Parameter benutzen:
  camaliga_title, camaliga_shortdesc, camaliga_link, camaliga_image, camaliga_street, camaliga_zip, camaliga_city, camaliga_country,
  camaliga_phone, camaliga_mobile, camaliga_email, camaliga_latitude, camaliga_longitude, camaliga_custom1, camaliga_custom_2, camaliga_custom3.
