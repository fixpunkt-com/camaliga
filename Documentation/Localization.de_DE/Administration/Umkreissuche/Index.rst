.. include:: /Includes.rst.txt


Umkreissuche
^^^^^^^^^^^^

Das umfangreichste Beispiel-Template stellt eine Umkreissuche dar.
Für die Umkreissuche benötigt man allerdings noch weitere Tabellen.
Vorausgesetzt wird allerdings nur eine Tabelle, die man aber aus mehreren anderen Tabellen generieren muss.
Es handelt sich hierbei um die OpenGeoDB-Tabellen. Die Dokumentation zu OpenGeoDB findet man hier:

http://opengeodb.org/wiki/OpenGeoDB_Dokumentation

Die benötigten Tabellen findet man nicht mehr online!

Davon werden 4 Tabellen benötigt: opengeodb-begin.sql, opengeodb-end.sql, opengeodb_hier.sql und
eine der Ländertabellen, z.B. DE.sql. Achtung 2/4 Tabellen sind riesig groß. Man kann die wahrscheinlich nur
über die mysql-Konsole fehlerfrei importieren. Aus diesen 4 Tabellen muss man eine eine weitere Tabelle erzeugen.
Die ganze Anleitung dazu findet man unter: `http://opengeodb.org/wiki/OpenGeoDB_-_Umkreissuche
<http://opengeodb.org/wiki/OpenGeoDB_-_Umkreissuche>`_.

Jedenfalls muss man nach dem Import noch folgende SQL-Statements ausführen (ersetze "de" durch dein Länderkürzel)::

  CREATE TABLE `geodb_zip_coordinates` (
    zc_id INT NOT NULL auto_increment PRIMARY KEY,
    zc_loc_id INT NOT NULL ,
    zc_zip VARCHAR( 10 ) NOT NULL ,
    zc_location_name VARCHAR( 255 ) NOT NULL ,
    zc_lat DOUBLE NOT NULL ,
    zc_lon DOUBLE NOT NULL
  )

und::

  INSERT INTO geodb_zip_coordinates (zc_loc_id, zc_zip, zc_location_name, zc_lat, zc_lon)
  SELECT gl.loc_id, plz.text_val, name.text_val, coord.lat, coord.lon
  FROM geodb_textdata plz
  LEFT JOIN geodb_textdata name     ON plz.loc_id = name.loc_id
  LEFT JOIN geodb_locations gl      ON plz.loc_id = gl.loc_id
  LEFT JOIN geodb_hierarchies tier  ON plz.loc_id = tier.loc_id
  LEFT JOIN geodb_coordinates coord ON plz.loc_id = coord.loc_id
  WHERE plz.text_type  = 500300000
  AND   name.text_type = 500100000
  AND   tier.id_lvl1 = 104
  AND   tier.id_lvl2 = 105
  AND   name.text_locale = "de"
  AND   gl.loc_type IN ( 100600000, 100700000 );

Das wars. Achtung: die Tabelle muss geodb_zip_coordinates und nicht nur zip_coordinates heissen!
Die neue Tabelle ist nur 1 MB groß und kann problemlos exportiert oder importiert werden.
Zur Not kann man die Tabelle also auf einem lokalen Server erzeugen und dann exportieren.
Die anderen geodb-Tabellen werden nicht mehr benötigt und können wieder gelöscht werden!

Nachdem man die Tabelle erzeugt hat, kann man sie wie folgt benutzen:

- Zuerst schaltete man die erweiterte Version ein. Mehr dazu findet man im vorherigen Kapitel.

- Dann muss man noch angeben, welche Radius-Werte zur Auswahl stehen sollen.

Wer wissen will, wie das aussieht, findet den Link zu einem Beispiel im Kapitel "Administration / HTML-Templates"
beim Template Map.html.
