<?php

function searchPhone($method_name, $args)
{
    $countryCode = new \CountryCode\CountryCode();
    return $countryCode->searchPhone($args[0]);
}

require_once './CountryCode.php';
$request_xml = file_get_contents("php://input");

$xmlrpc_server = xmlrpc_server_create();
xmlrpc_server_register_method($xmlrpc_server, "searchPhone", "searchPhone");
header('Content-Type: text/xml');
print xmlrpc_server_call_method($xmlrpc_server, $request_xml, array());
?>
