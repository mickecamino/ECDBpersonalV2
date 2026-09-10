# Changelog
This is a list of changes made to my version of ECDB personal V2.


## [2026-09-10]
# BREAKING CHANGES
* I have switched from int to unsigned smallint on and from varchar to smallint. Run the script below to change the database. 
It might break a few things, I have tested a lot, but there might be some quirks lingering around in the code.
```
sudo mysql
use ecdb;
ALTER TABLE data MODIFY id smallint UNSIGNED NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=702; 
ALTER TABLE data MODIFY owner smallint UNSIGNED NOT NULL;
ALTER TABLE data MODIFY pins smallint UNSIGNED NOT NULL;
ALTER TABLE data MODIFY quantity smallint UNSIGNED NOT NULL;
ALTER TABLE data MODIFY order_quantity smallint UNSIGNED NOT NULL;
ALTER TABLE data MODIFY category smallint UNSIGNED NOT NULL;

ALTER TABLE members MODIFY member_id smallint UNSIGNED NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1801;

ALTER TABLE projects MODIFY project_id smallint UNSIGNED NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
ALTER TABLE projects MODIFY project_owner smallint UNSIGNED NOT NULL;

ALTER TABLE projects_data MODIFY projects_data_id smallint UNSIGNED NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
ALTER TABLE projects_data MODIFY projects_data_owner_id smallint UNSIGNED;
ALTER TABLE projects_data MODIFY projects_data_project_id smallint UNSIGNED;
ALTER TABLE projects_data MODIFY projects_data_component_id smallint UNSIGNED;
ALTER TABLE projects_data MODIFY projects_data_quantity smallint UNSIGNED;
```
* Updated importexport.php, fixed a bunch of bugs, added output for success and errors and a lot of checking before importing.



## [2026-09-03]

* Removed Email from the code, it was not used, no need to keep it.
* Localized more files, removed localization code from a bunch of files as it was already included in include/header.php
* Update of the statistics page, now it only display components and projects belonging to the logged in user

## [2026-09-01]

* Removed all instances of the SMD checkbox. There is no need to use it as the Package should contain the proper package type.
* Removed smd from the database.
* Removed Price from all component listings except Shoplist.
* Added Location to all component listings.
* Replaced the All section with statistics that shows each head category and the number of components in each category.
* Started to localize all text strings to be able to use php i18n
* Clean up code, switch from tabs to 4 spaces

## 

* Fixed some bugs in the code.
* Changed the database collation to utf8mb3_swedish_ci.
* Removed some dead code.
* Changed css to display a wider area.
* Fixed some things in the database.
