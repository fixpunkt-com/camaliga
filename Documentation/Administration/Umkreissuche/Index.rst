.. include:: /Includes.rst.txt


Proximity search
^^^^^^^^^^^^^^^^

The most extensive example template represents a radius search.
For the proximity search you, however, still needs more tables.
Provided is only a table, but we need to generate it from several other tables.
This are the OpenGeoDB tables. The documentation for OpenGeoDB can be found here:

http://opengeodb.org/wiki/OpenGeoDB_Dokumentation

The required tables are no longer online!

These 4 tables are required: opengeodb-begin.sql, opengeodb-end.sql, opengeodb_hier.sql
and one of the country tables, for example, DE.sql. Warning 2/4 tables are huge in size. One can probably only
import them error-free on the mysql console. With these 4 tables you must produce another table.
You will find all instructions here: `http://opengeodb.org/wiki/OpenGeoDB_-_Umkreissuche
<http://opengeodb.org/wiki/OpenGeoDB_-_Umkreissuche>`_.

Anyway, you have to run after import the following SQL statements (replace "de" by your country code)::

  CREATE TABLE `geodb_zip_coordinates` (
    zc_id INT NOT NULL auto_increment PRIMARY KEY,
    zc_loc_id INT NOT NULL ,
    zc_zip VARCHAR( 10 ) NOT NULL ,
    zc_location_name VARCHAR( 255 ) NOT NULL ,
    zc_lat DOUBLE NOT NULL ,
    zc_lon DOUBLE NOT NULL
  )

and::

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

That's it. Note: the table must be renamed to geodb_zip_coordinates and not only zip_coordinates!
The new table is just 1MB in size and can be easily exported and imported.
In a pinch, you can create thus tables on a local server and then export them.
The other GeoDB tables are no longer needed and can be deleted!

Once you have created the table, you can use it as follows:

- First you need tu turn on the extended version. More can be found in the previous chapter.

- Then you have to specify what radius values are available for selection.

Who wants to know what it looks like, will find the link to an example in the chapter "Administration / HTML templates"
the template Map.html.
