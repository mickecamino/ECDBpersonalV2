# Changelog
This is a list of changes made to my version of ecDB personal V2.

## [Unreleased]
* Update ecDB.sql file from a mysqldump of MariaDB
* Add export for Shopping list  
* Add Fulfill for Shopping list, updates the quantity and resets the Shopping list except for backorder items  

## [2026-09.23]
* Added display numner of units in the project list

## [2026-09-22]
* Added function to disable the register tab. Edit include/include_disable_register.php and change false to true.  
Change from
```
$disable_register = false; // Set to true to disable the Register functions
```
to:
```
$disable_register = true; // Set to true to disable the Register functions
```
to disable the Register tab.
## [2026-09-20]
* Added total cost for all projects list.
* Fixed a lot of internals and cleaned up a couple of SQL-commands.

* Followed the instructions to test that the code is working when cloning the repository. It did, had to fix a couple of translations.

## [2026-09-18]
* Rewrote currency display to use php Intl, functions numfmt_create and numfmt_format_currency.  
Now all prices that are displayed use correct formatting depending on language and currency setting in my.php
* Added English UK in language

* ** NOTE ** You need to run this command in a shell on the server:
```
sudo apt install php-intl
sudo systemctl restart apache2
```
## [2026-09-17]
* Fixed currency format for shoppinglist and projectlist

## [2026-09-16]
* Switched from Fontawesome v4 to v5.
* Replaced a couple of images
* Fixed formatting in sum för projects and shoppinglist
* Removed a bunch of directories and files that was not used in the code

## [2026-09-15]
* Added images of resistors for E12 and E24 series.
* Updated all import files for resistors to link the image.  
If you are testing this out you can do a quick delete of all resistors in the database by running this commands:
```
sudo mysql
use ecdb
DELETE FROM data WHERE category = '1301';
DELETE FROM data WHERE category = '1302';
DELETE FROM data WHERE category = '1303';
```
Then import all resistor CSV-files.

## [2026-09-14]
* Added new view to component page:  
* If a component is included in one or more projects, show all projects on the Component View page, with hyperlinks to the project.
* Also, if there are no projects created, do not show the dropdown in component view.

## [2026-09-13]
* Fixed duplicate check in import export, a duplicate is now when the name, category and location is the same in the csv as in the database. A component can exist in many different places.

## [2026-09-12]
* Fixed a couple of bugs, removed the About tab, it was an remnant from the online version.
* Added localization to register-success.

## [2026-09-10]
# BREAKING CHANGES
* I have switched from int to unsigned smallint on all int-fields and from varchar to smallint on others. Run the script below to change the database.  
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

ALTER TABLE category_head MODIFY projects_data_quantity smallint UNSIGNED;
ALTER TABLE category_sub MODIFY projects_data_quantity smallint UNSIGNED;

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
