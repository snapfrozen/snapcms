SnapCMS7
========

## Installation

1. Navigate to your website's home directory

2. Clone the SnapCMS git repository
```
git clone https://github.com/snapfrozen/snapcms.git .
```
Make sure to include the . (dot) to avoid SnapCMS being created in it's own folder

3. Install Composer:
```
curl -sS https://getcomposer.org/installer | php
```
Or you may need to do something like this to enable some "dangerous" PHP features
```
curl -sS https://getcomposer.org/installer | php -d allow_url_fopen=On -d suhosin.executor.include.whitelist=phar
```

4. Setup and edit db.php
```
mv db.php.default db.php
vi db.php
```

5. Make sure backend/yiic is executable
```
chmod u+x backend/yiic
```

6. Install SnapCMS
```
php composer.phar install
```
Or to enable PHP features:
```
php -d allow_url_fopen=On -d suhosin.executor.include.whitelist=phar -d disable_functions= composer.phar install
```
Choose "yes" to create the *frontend* folder when asked

Done!