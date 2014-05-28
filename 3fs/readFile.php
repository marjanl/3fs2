<?php
set_time_limit(5);
require_once './CountryCode.php';
require_once 'PHP/PMD/AbstractRule.php'; 
require_once 'PHP/PMD/Rule/IClassAware.php';
/*
  1. Create a package (namespace) with following requirements:
  - PHP 5.5
  - needs to take MSISDN as an input
  - returns MNO identifier, country dialling code, subscriber number and 
    country identifier as defined with ISO 3166-1-alpha-2
  - do not care about number portability

  For example, MSISDN + 38640123456 returns si.mobil, 386, 40123456, SI.

  2. Write all needed tests.

  3. Code needs to pass following checks (please include the script as well):

  - php -l
  - phpcs --standard=PSR2
  - phpmd  codesize,design,naming,unusedcode,controversial --strict
  - phpcpd --min-lines 3 --min-tokens 50

  4. Expose the package through an RPC API, select one and explain why have you chosen it. *

 *  */
echo "zacenjam";
$countryCode = new \CountryCode\CountryCode();
$ret = $countryCode->searchPhone("+437088");
echo "<hr>" . $ret;
echo "<br>Koncal";
?>

