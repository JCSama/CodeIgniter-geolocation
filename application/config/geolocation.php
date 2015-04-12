<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| API URI
|--------------------------------------------------------------------------
|
| http://ipinfodb.com/ Offer a free IP Geolocation tools,
| The API returns the location of an IP address (country, region, city, zipcode,
| latitude, longitude) and the associated timezone in XML or JSON format.
|
*/
$config['api'] = 'http://api.ipinfodb.com/';

/*
|--------------------------------------------------------------------------
| API VERSION
|--------------------------------------------------------------------------
|
| Version of the API
|
*/
$config['api_version'] = 'v3';

/*
|--------------------------------------------------------------------------
| API KEY
|--------------------------------------------------------------------------
|
| The API KEY : You can get yours from here http://ipinfodb.com/register.php
|
*/
$config['api_key'] = 'YOUR_API_KEY';

/*
|--------------------------------------------------------------------------
| FORMAT
|--------------------------------------------------------------------------
|
| The default format is JSON, but you can change it to XML or RAW format
|
| $config['format'] = 'json';
|
| $config['format'] = 'xml';
|
| $config['format'] = 'raw';
|
*/
$config['format'] = 'json';
