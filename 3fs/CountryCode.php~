<?php

namespace CountryCode;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CountryCode
 *
 * @author marjanl
 */
class CountryCode
{

    public function getFoundCountryCode()
    {
        return $this->foundCountryCode;
    }

    public function getFoundCountryPrefix()
    {
        return $this->foundCountryPrefix;
    }

    public function getFoundMNO()
    {
        return $this->foundMNO;
    }

    public function getFoundPhonenoWithoutCountry()
    {
        return $this->foundPhonenoWithoutCountry;
    }

    private $codes = array();
    private $keys;
    private $values;

    const CODES_FILE = 'CountryCodes.txt';
    const MNO_FILE = 'MNO.txt';

    public function __construct()
    {
        $this->readFile(self::CODES_FILE);
        $this->codes = array_combine($this->keys, $this->values);
        $this->readFile(self::MNO_FILE);
        //print_r($this->codes);
    }

    private function readFile($fileToRead)
    {
        $handle = fopen($fileToRead, "r");
        if ($handle) {
            while (($buffer = fgets($handle, 4096)) !== false) {
                $this->parseLine($fileToRead, $buffer);
            }
            if (!feof($handle)) {
                echo "Error: unexpected fgets() fail in file " . $fileToRead . "\n";
            }
            fclose($handle);
        }
    }

    private function parseLine($fileToRead, $buffer)
    {
        if ($fileToRead == self::CODES_FILE) {
            $this->parseCountryLine($buffer);
        } elseif ($fileToRead == self::MNO_FILE) {
            $this->parseMnoLine($buffer);
        }
    }

    private function parseCountryLine($buffer)
    {
        if (preg_match('/^(.+)\t(.+)\/(.+)\t(.+)$/', $buffer, $matches)) {
            $this->addCountry($this->trimAndRemoveSpace($matches[2]), $this->trimAndRemoveSpace($matches[4]));
        }
    }

    private function parseMnoLine($buffer)
    {
        if (preg_match('/^(.+)\t(.+)\t(.+)$/', $buffer, $matches)) {
            $this->addMno($this->trimAndRemoveSpace($matches[1]), $this->trimAndRemoveSpace($matches[2]), $this->trimAndRemoveSpace($matches[3])
            );
        }
    }

    private function addMno($countryPrefix, $mnoPrefix, $mnoName)
    {
        if (!array_key_exists($countryPrefix, $this->codes)) {
            throw new Exception("country prefix " . $countryPrefix . " does not exist!");
        }
        $arr = $this->codes[$countryPrefix] + array($mnoPrefix => $mnoName);
        $this->codes[$countryPrefix] = $arr;
    }

    private function trimAndRemoveSpace($in)
    {
        return str_replace(array(" ", "\n", "\r", "\t"), "", trim($in));
    }

    private function addCountry($inCountryCode, $inPrefix)
    {
        if ($inCountryCode == null or trim($inCountryCode) == "") {
            return;
        }
        if ($inPrefix == null or trim($inPrefix) == "") {
            return;
        }
        $this->keys = $this->addToArray($this->keys, $inPrefix);
        $this->values = $this->addToArray($this->values, array("country" => $inCountryCode));
    }

    private function addToArray($arr1, $string)
    {
        if ($arr1 == null) {
            $arr1 = array($string);
        } else {
            array_push($arr1, $string);
        }
        return $arr1;
    }

    public function searchPhone($phoneNumber)
    {
        $this->foundCountryCode = $this->foundCountryPrefix = $this->foundMNO = "";
        if (strlen($phoneNumber) < 5 || !$this->startsWith($phoneNumber, "+")) {
            return "Searched phone number is invalid:" . $phoneNumber;
        }
        $shortPhoneNo = substr($phoneNumber, 1);
        $arr = $this->getCountry($shortPhoneNo); //prvi je +...ga odstranim
        if ($arr == null) {
            return " not found";
        }
        $this->foundPhonenoWithoutCountry=substr($shortPhoneNo, strlen($this->foundCountryPrefix));
        $this->getMno($arr, substr($shortPhoneNo, strlen($this->foundCountryPrefix)));
        return $this->foundMNO . ", " . $this->foundCountryPrefix
                . ", " . $this->foundPhonenoWithoutCountry . ", "
                . $this->foundCountryCode; // si.mobil, 386, 40123456, SI
    }

    private function getMno($arr, $phoneno)
    {
//        echo "iščem getMno:>" . $phoneno . "<br>\n";
        if (array_key_exists($phoneno, $arr)) {
            $this->foundMNO = $arr[$phoneno];
            return $this->foundMNO;
        } else {
            $s = substr($phoneno, 0, strlen($phoneno) - 1);
            if (strlen($s) > 0) {
                return $this->getMno($arr, $s);
            } else {
                return null;
            }
        }
    }

    private function getCountry($phonenumber)
    {
//        echo "iščem tel:>" . $phonenumber . "<br>\n";
        if (array_key_exists($phonenumber, $this->codes)) {
            $this->foundCountryPrefix = $phonenumber;
            if (array_key_exists("country", $this->codes[$phonenumber])) {
                $this->foundCountryCode = $this->codes[$phonenumber]["country"];
            }
            return $this->codes[$phonenumber];
        } else {
            $s = substr($phonenumber, 0, strlen($phonenumber) - 1);
            if (strlen($s) > 0) {
                return $this->getCountry($s);
            } else {
                return null;
            }
        }
    }

    private function startsWith($haystack, $needle)
    {
        return $needle === "" || strpos($haystack, $needle) === 0;
    }
}

?>
