::php -l *.php
for /r %%i in (*.php) do call php -l  %%i


::phpcs --standard=PSR2 
for /r %%i in (*.php) do call phpcs --standard=PSR2 %%i


::phpcpd
call phpcpd . --min-lines 3 --min-tokens 50

