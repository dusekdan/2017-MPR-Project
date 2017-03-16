<?php

error_reporting(0); // Set E_ALL for debuging

include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'Normalizer'.DIRECTORY_SEPARATOR.'plugin.php';

include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderConnector.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinder.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeDriver.class.php';
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeLocalFileSystem.class.php';
// Required for MySQL storage connector
include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeMySQL.class.php';
// Required for FTP connector support
// include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeFTP.class.php';
// ===============================================

/**
 * # Dropbox volume driver need `composer require dropbox-php/dropbox-php:dev-master@dev`
 *  OR "dropbox-php's Dropbox" and "PHP OAuth extension" or "PEAR's HTTP_OAUTH package"
 * * dropbox-php: http://www.dropbox-php.com/
 * * PHP OAuth extension: http://pecl.php.net/package/oauth
 * * PEAR's HTTP_OAUTH package: http://pear.php.net/package/http_oauth
 *  * HTTP_OAUTH package require HTTP_Request2 and Net_URL2
 */
// // Required for Dropbox.com connector support
// // On composer
// require 'vendor/autoload.php';
// elFinder::$netDrivers['dropbox'] = 'Dropbox';
// // OR on pear
// include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'elFinderVolumeDropbox.class.php';

// // Dropbox driver need next two settings. You can get at https://www.dropbox.com/developers
// define('ELFINDER_DROPBOX_CONSUMERKEY',    '');
// define('ELFINDER_DROPBOX_CONSUMERSECRET', '');
// define('ELFINDER_DROPBOX_META_CACHE_PATH',''); // optional for `options['metaCachePath']`
// ===============================================

// // Required for Google Drive network mount
// // Installation by composer
// // `composer require nao-pon/flysystem-google-drive:~1.1 google/apiclient:~2.0@rc nao-pon/elfinder-flysystem-driver-ext`
// // composer autoload
// require 'vendor/autoload.php';
// // Enable network mount
// elFinder::$netDrivers['googledrive'] = 'FlysystemGoogleDriveNetmount';
// // GoogleDrive Netmount driver need next two settings. You can get at https://console.developers.google.com
// // AND reuire regist redirect url to "YOUR_CONNECTOR_URL?cmd=netmount&protocol=googledrive&host=1"
// define('ELFINDER_GOOGLEDRIVE_CLIENTID',     '');
// define('ELFINDER_GOOGLEDRIVE_CLIENTSECRET', '');
// ===============================================

/**
 * Simple function to demonstrate how to control file access using "accessControl" callback.
 * This method will disable accessing files/folders starting from '.' (dot)
 *
 * @param  string  $attr  attribute name (read|write|locked|hidden)
 * @param  string  $path  file path relative to volume root directory started with directory separator
 * @return bool|null
 **/
function access($attr, $path, $data, $volume) {
	return strpos(basename($path), '.') === 0       // if file/folder begins with '.' (dot)
		? !($attr == 'read' || $attr == 'write')    // set read+write to false, other (locked+hidden) set to true
		:  null;                                    // else elFinder decide it itself
}
// ošetření oprávnění uživatele
$container = require_once __DIR__ . '/../../../../app/bootstrap.php';
$user = $container->getService('user');
/*
Tracy\Debugger::fireLog($user->identity);
Tracy\Debugger::fireLog(__DIR__);
Tracy\Debugger::fireLog(dirname($_SERVER['PHP_SELF']));
$dir = __DIR__."/../../../files/sportModule/user/{$user->identity->id}_user/upload/";
Tracy\Debugger::fireLog(is_dir($dir));
if (is_dir($dir)){
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
		Tracy\Debugger::fireLog($file);
    }
    closedir($dh);
  }
}
 * 
 */
$path = __DIR__ ."/../../../files/sportModule/user/{$user->identity->id}_user/upload";
$url = dirname($_SERVER['PHP_SELF']) ."/../../../files/sportModule/user/{$user->identity->id}_user/upload";
$pathPublic = __DIR__ ."/../../../files/sportModule/user/guest";
$urlPublic = dirname($_SERVER['PHP_SELF']) ."/../../../files/sportModule/user/guest";
// Documentation for connector options:
// https://github.com/Studio-42/elFinder/wiki/Connector-configuration-options


//kontrola složek
/*
if(!(is_dir(__DIR__ ."/../../../files/sportModule/user/{$user->identity->id}_user/upload/"))){
	checkFolder($user);
}
 * 
 */
/*
Tracy\Debugger::fireLog($user->isAllowed('fileAdmin', 'edit'));
Tracy\Debugger::fireLog((!$user->isAllowed('fileAdmin', 'remove')));
*/
$opts = array(
	'debug' => false,
	'locale' => 'cs-CZ.UTF-8',
	'roots' => array(
		array(
			'driver'        => 'LocalFileSystem',           // driver for accessing file system (REQUIRED)
			'utf8fix'		=> true,
			'fileMode'		=> 0666,         // new files mode
			'dirMode'		=> 0777,         // new folders mode
			'tmbPathMode'	=> 0777,
			'path'          => $path.'/documents/',                 // path to files (REQUIRED)
			'URL'           => $url.'/documents/', // URL to files (REQUIRED)
			'uploadDeny'    => array('all'),                // All Mimetypes not allowed to upload
			'uploadAllow'   => array('image', 'text/plain'),// Mimetype `image` and `text/plain` allowed to upload
			'uploadOrder'   => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only
			'uploadMaxSize'	=> '5M',
			'accessControl' => 'access',                     // disable and hide dot starting files (OPTIONAL)
			'alias' => 'Dokumenty'
		),
		array(
			'driver'        => 'LocalFileSystem',           // driver for accessing file system (REQUIRED)
			'path'          => $path.'/images/',                 // path to files (REQUIRED)
			'URL'           => $url.'/images/', // URL to files (REQUIRED)
			'utf8fix'		=> true,
			'fileMode'		=> 0666,         
			'dirMode'		=> 0777,         
			'tmbPathMode'	=> 0777,
			'uploadDeny'    => array('all'),                // All Mimetypes not allowed to upload
			'uploadAllow'   => array('image', 'text/plain'),// Mimetype `image` and `text/plain` allowed to upload
			'uploadOrder'   => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only
			'uploadMaxSize'	=> '5M',
			'accessControl' => 'access',                     // disable and hide dot starting files (OPTIONAL)
			'alias' => 'Obrázky'
		),
		array(
			'driver'        => 'LocalFileSystem',           // driver for accessing file system (REQUIRED)
			'path'          => $path.'/others/',                 // path to files (REQUIRED)
			'URL'           => $url.'/others/', // URL to files (REQUIRED)
			'utf8fix'		=> true,
			'fileMode'		=> 0666,         
			'dirMode'		=> 0777,         
			'tmbPathMode'	=> 0777,
			'uploadDeny'    => array('all'),                // All Mimetypes not allowed to upload
			'uploadAllow'   => array('all'),// Mimetype `image` and `text/plain` allowed to upload
			'uploadOrder'   => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only
			'uploadMaxSize'	=> '5M',
			'accessControl' => 'access',                     // disable and hide dot starting files (OPTIONAL)
			'alias' => 'Ostatní'
		),
		array(
			'driver'        => 'LocalFileSystem',           // driver for accessing file system (REQUIRED)
			'path'          => $pathPublic.'/public/',                 // path to files (REQUIRED)
			'URL'           => $urlPublic.'/public/', // URL to files (REQUIRED)
			'utf8fix'		=> true,
			'fileMode'		=> 0666,         
			'dirMode'		=> 0777,         
			'tmbPathMode'	=> 0777,
			'uploadDeny'    => array('all'),                // All Mimetypes not allowed to upload
			'uploadAllow'   => array('all'),// Mimetype `image` and `text/plain` allowed to upload
			'uploadOrder'   => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only
			'uploadMaxSize'	=> '5M',
			'accessControl' => 'access',                     // disable and hide dot starting files (OPTIONAL)
			'alias' => 'Veřejné',
			'tmbBgColor' => 'transparent',
			'defaults' => array('read' => true, 'write' => false),
			'attributes' => array(
				array(
					'pattern' => '/^./',
					'read'    => true,
					'write'   => $user->isAllowed('fileAdmin', 'edit'),
					'locked'  => (!$user->isAllowed('fileAdmin', 'remove'))
				),
				array(
					'pattern' => '/Admin/',
					'read'    => $user->isAllowed('fileAdminPublic', 'view'),
					'write'   => $user->isAllowed('fileAdminPublic', 'edit'),
					'locked'  => (!$user->isAllowed('fileAdminPublic', 'remove'))
				),
				array(
					'pattern' => '/Coach/',
					'read'    => $user->isAllowed('fileTrainerPublic', 'view'),
					'write'   => $user->isAllowed('fileTrainerPublic', 'edit'),
					'locked'  => (!$user->isAllowed('fileTrainerPublic', 'remove'))
				),
				array(
					'pattern' => '/Sportovec/',
					'read'    => $user->isAllowed('fileAthletePublic', 'view'),
					'write'   => $user->isAllowed('fileAthletePublic', 'edit'),
					'locked'  => (!$user->isAllowed('fileAthletePublic', 'remove'))
				)
			),
			'disabled' => array('mkdir')
		),
		array(
			'driver'        => 'MySQL',
			'host'          => 'localhost',
			'user'          => 'root',
			'pass'          => '',
			'db'            => 'sportovni_web',
			'files_table'   => 'elfinder_file',
			'path'          => 1
		)
	)

);

// run elFinder
$connector = new elFinderConnector(new elFinder($opts));
$connector->run();
/*
function checkFolder($user){
	/*
	 * user
	 * --plan
	 * --upload
	 * ----documents
	 * ----images
	 * ----others
	 * --diary
	 * 
	 */
/*
	$path = __DIR__ ."/../../../files/sportModule/user/";
	if(!is_dir($path."{$user->identity->id}_user/")){
		mkdir($path."{$user->identity->id}_user/");
	}
	if(!is_dir($path."{$user->identity->id}_user/plan/")){
		mkdir($path."{$user->identity->id}_user/plan/");
	}
	if(!is_dir($path."{$user->identity->id}_user/upload/")){
		mkdir($path."{$user->identity->id}_user/upload/");
	}
	if(!is_dir($path."{$user->identity->id}_user/upload/documents/")){
		mkdir($path."{$user->identity->id}_user/upload/documents/");
	}
	if(!is_dir($path."{$user->identity->id}_user/upload/images/")){
		mkdir($path."{$user->identity->id}_user/upload/images/");
	}
	if(!is_dir($path."{$user->identity->id}_user/upload/others/")){
		mkdir($path."{$user->identity->id}_user/upload/others/");
	}
	if(!is_dir($path."{$user->identity->id}_user/diary/")){
		mkdir($path."{$user->identity->id}_user/diary/");
	}
}

*/
