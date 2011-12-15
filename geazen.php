<?php
/*

Plugin Name: Geazen
Description: Plugin para afiliados de <a href="http://www.geazen.es">Geazen Affiliate Network</a>. Permite la generación de enlaces trackeados de las landings de los programas y de todos los productos de los catálogos.
Version: 0.1.0
Author: Geazen
Author URI: http://www.geazen.es

*/
if ( ! defined( 'WPCD_PLUGIN_BASENAME' ) )
	define( 'WPCD_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

if ( ! defined( 'WPCD_PLUGIN_NAME' ) )
	define( 'WPCD_PLUGIN_NAME', trim( dirname( WPCD_PLUGIN_BASENAME ), '/' ) );

if ( ! defined( 'WPCD_PLUGIN_DIR' ) )
	define( 'WPCD_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . WPCD_PLUGIN_NAME );

if ( ! defined( 'WPCD_PLUGIN_URL' ) )
	define( 'WPCD_PLUGIN_URL', WP_PLUGIN_URL . '/' . WPCD_PLUGIN_NAME );
	
gz_plugin_start();
	
// Administration
add_action('admin_menu', 'geazen_menu');

function geazen_menu() {
  //add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position )
  //add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
  
  add_menu_page('Geazen', 'Geazen', 'manage_options', 'geazen_conection','geazen_menu',plugins_url().'/geazen/images/logo-menu.png');
  
  add_submenu_page('geazen_conection', 'Conexión', 'Conexión', 'manage_options', 'geazen_conection', 'geazen_conection');
  
  add_submenu_page('geazen_conection', 'Enlaces de editor', 'Enlaces de editor', 'manage_options', 'geazen_links', 'geazen_links');
  

}
//Tinymce
function tinymce_gzplugin_addbuttons()
{

  // Don't bother doing this stuff if the current user lacks permissions
  if ( current_user_can('edit_posts') && current_user_can('edit_pages') ) {
    if ( get_user_option('rich_editing') == 'true') {
      add_filter("mce_external_plugins", "add_tinymce_gzplugin_plugin");
      add_filter('mce_buttons', 'register_tinymce_gzplugin_buttons');
    }
  }

}


function register_tinymce_gzplugin_buttons($buttons)
{
  array_push($buttons, "separator", "geazen-products");
  array_push($buttons, "geazen-links");
  return $buttons;
}


// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
function add_tinymce_gzplugin_plugin($plugin_array)
{

  $plugin_name = preg_replace('/\.php/','',basename(__FILE__));
  $plugin_array['gzplugin'] = WP_PLUGIN_URL .'/'.$plugin_name.'/mce/gzplugin/editor_plugin.dev.js';
  return $plugin_array;
}
add_action('init', 'tinymce_gzplugin_addbuttons');



include('conection.php');

include('links.php');
include('dashboard.php');


function gz_plugin_start() {

	wp_enqueue_script( array( '' ) );
	wp_enqueue_script( array( 'jquery' ) );
}

function geazen_activate() {

geazen_defaults();
    
}
register_activation_hook( __FILE__, 'geazen_activate' );

function geazen_defaults(){
		if(get_option('gz_aid')=='')
		{
				update_option( 'gz_htmlproducts', '<table style="border: 1px solid #CCCCCC;">
		    <tr>
		    <td style="vertical-align: middle;"> 
		    <img src="%product_image%" width="80" height="80">
		    </td>
		    <td style="vertical-align: middle;">
		    <a href="%product_url%" rel="nofollow">%product_title%</a>: %product_description%
		    </td>
		    </tr>
		    <tr>
		    <td></td>
		    <td><strong>%product_price% %product_currency%</strong></td>
		    </tr>
		    </table>' );
		    update_option( 'gz_htmllinks', '<a href="%link_url%" rel="nofollow">%link_text%</a>' );
		    update_option( 'gz_autolink_htmllinks', '<a href="%link_url%" target="blank" rel="nofollow" alt="%link_title%" title="%link_title%">%link_text%</a>' );
		    
		}			      	
}

function geazen_getsuggest_keywords()
{
	
	$links_xml = simplexml_load_file('http://affiliation.geazen.com/gz-plugin/gz-autolinks-suggest.php');


if(count($links_xml)!=0){

	return $links_xml->name;

}
}

?>