# Setup ecDBpersonal on Debian Trixie
* This is from memory, will update it later
Download the netinstall ISO from Debian  
Boot from the ISO  
Chose English  
Swedish keyboard  
In Software selection remove everything except SSH server and Standard System Utilities  

When the installation is done and the server has rebooted:  
Install sudo  
Login as root  
run 
```
apt install sudo
usermod -a -G sudo <your user>
```

* Set static IP
```
sudo nano /etc/network/interfaces
```
* Edit the file and replace XXX and YYY with your local network
```
auto eth0
iface eth0 inet static  
        address 192.168.XXX.YYY  
        netmask 255.255.255.0  
        gateway 192.168.XXX.YYY
        dns-domain XXXXX.lokal
        dns-nameservers 192.168.XXX.YYY
```
# Disable ipv6
```
sudo nano /etc/sysctl.d/99-disable-ipv6.conf
```
* Paste the following at the end of the file
```
net.ipv6.conf.all.disable_ipv6 = 1
net.ipv6.conf.default.disable_ipv6 = 1
```
* Activate it
```
sudo sysctl --system
```

# Add Swedish language
```
sudo dpkg-reconfigure locales
```
* Select sv_SE.utf8
```
sudo update-locale
```

# Now install apache, mariadb and php
```
sudo apt install apache2
sudo apache2ctl -v
sudo systemctl enable apache2
sudo apt install mariadb-server mariadb-client
sudo systemctl enable mariadb
```
* Make sure that they are started
```
sudo systemctl start apache2
sudo systemctl start mariadb
```

* Add your user to groups www-data and adm.
```
sudo usermod -a -G www-data <your user> 
sudo usermod -a -G adm <your user>
```

* Start mariadb
```
sudo systemctl start mariadb
```

# Secure the mariadb
```
sudo mariadb-secure-installation
```

# Install php
```
sudo apt install php libapache2-mod-php php-cli php-common php-zip php-curl php-mysql php-xml php-mbstring php-gd
sudo systemctl restart apache2
```

# Install gettext utilities
```
sudo apt gettext
```

# Create database
```
sudo mysql
CREATE DATABASE IF NOT EXISTS `ecdb` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_swedish_ci;
exit
```
# Import the default datbase
```
sudo mysql ecdb < ecdb.sql
```
# Create user with password and assign right
```
sudo mysql
CREATE USER 'ecdb'@'localhost' IDENTIFIED BY 'your-secure-password';
GRANT ALL PRIVILEGES ON ecdb.* TO 'ecdb'@'localhost';
FLUSH PRIVILEGES;
```