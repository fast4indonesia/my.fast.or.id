<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Supported languages
|--------------------------------------------------------------------------
|
| Associative array of supported languages.
|
| Keys are URI lang code (ex : http://www.domain.com/en/...)
| Values are directories names within application/language  
|
*/
$config['languages'] = array(
	
	'en' => 'english',
	'es' => 'spanish'
);

/*
|--------------------------------------------------------------------------
| Auto-Detection methods
|--------------------------------------------------------------------------
|
| Processed in the order they are defined om the array below.
|
| "subdomain" looks for a lang code in the immediate subdomain, i.e. es.baseurl.com
| This method requires a subdomain wildcard, or virtual directory setup that points
| all language subdomains to this CI application
|
| "uri" looks for a lang code in the first uri segment, i.e. baseurl.com/es/content
|  This method is made easier by including the following rules in your routes config file
|  letting CI know to ignore the language id in the URI
 * 
 * 
 * $group_langs = 'en|es';
 * $route["($group_langs)"] = $route['default_controller'];
 * $route["($group_langs)/(:any)$"] = "$2";
 * 
 * 
 * 
| "browser" tries to detect the language from the browser
 *
| 
|*/
$config['autodetect'] = array('subdomain','uri','browser');