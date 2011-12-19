<?php
//include wp-config or wp-load.php

$root = dirname(dirname(dirname(dirname(__FILE__))));

if (file_exists($root.'/wp-load.php')) {

// WP 2.6

require_once($root.'/wp-load.php');

} else {

// Before 2.6

require_once($root.'/wp-config.php');

}




$datos_xml = simplexml_load_file('https://affiliation.geazen.com/gz-plugin/gz-login.php?user='.$_POST['user'].'&password='.$_POST['password'].'&url='.urlencode(get_bloginfo('url')));

if (count($datos_xml)==0){echo '<img src="'.plugins_url().'/geazen/images/error.png"> Los datos son incorrectos.<script language="javascript">document.getElementById(\'gz_aid\').value=\'\';</script>';return;}

    update_option( 'gz_aid', (string)$datos_xml->refid );
    echo '<img src="'.plugins_url().'/geazen/images/ok.png"> Los datos son correctos.<script language="javascript">document.getElementById(\'gz_aid\').value=\''.$datos_xml->refid.'\';</script>';


?>