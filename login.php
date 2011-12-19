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

if (count($datos_xml)==0){echo '<img src="'.plugins_url().'/geazen/images/error.png"> Los datos son incorrectos.';return;}

    update_option( 'gz_aid', (string)$datos_xml->refid );
    $xml=simplexml_load_file('http://affiliation.geazen.com/gz-plugin/gz-panel.php?user='.$_POST['user'].'&password='.$_POST['password']);
    update_option ('gz_panel_xml',$xml->saveXML());
    update_option( 'gz_user', $_POST['user'] );
		update_option( 'gz_pass', $_POST['password'] );
    echo '<img src="'.plugins_url().'/geazen/images/ok.png"> Los datos son correctos.';
    

?>