To translate to a new language go to your language folder, currently these are:
de_DE - German
es_ES - Spanish
fr_FR - French
it_IT - Italian
For example, translate to Italian langauage
cd /var/www/html/include/i18n/it_IT/LC_MESSAGES
You will find the file ecdbpersonalv2.po here. Edit this file and translate all the strings. 
Either with sudo nano ecdbpersonalv2.po or by copying the whole file to your local desktop and use poedit.
Download it from https://poedit.com/ 

When done, compile it with:
sudo msgfmt -cv -o ecdbpersonalv2.mo ecdbpersonalv2.po

restart apache with sudo systemctl restart apache2

Go to "My settings" and select Italian as language and refresh your browser.

