./propel sql:build --overwrite
./propel model:build
./propel sql:insert
php composer.phar dump-autoload
