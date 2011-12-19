<?PHP

// Create the function to output the contents of our Dashboard Widget

function geazen_dashboard_widget_function() {
if(get_option ('gz_aid')==''){
echo '<div id="message" class="error fade"><p>El plugin Geazen no está configurado correctamente. Visita la <a href="'.get_bloginfo('url').'/wp-admin/admin.php?page=geazen_conection" target="_parent">página de conexión</a></p></div>';}
else
{
  echo '<h4>Estadísticas</h4><p>Correspondientes a los últimos 30 días</p>';
  $panel_xml = simplexml_load_string(get_option ('gz_panel_xml'));
  echo'<table width="100%">
<tr>
<td>
<p>Nº de comisiones pendientes: <strong>'.number_format((double)$panel_xml->pending, 0, ',', '.').'</strong></p>
<p>Importe de las comisiones pendientes: <strong>'.number_format((double)$panel_xml->cpending, 2, ',', '.').' €</strong></p>
</td>

<td>
<img src="'.$panel_xml->impressionsgraph.'&chs=110x62">
<img src="'.$panel_xml->clicksgraph.'&chs=110x62">
</td>
</tr>
<tr>
<td>
<p>Nº de comisiones confirmadas: <strong>'.number_format((double)$panel_xml->confirmed, 0, ',', '.').'</strong></p>
<p>Importe confirmado y pendiente de pago: <strong>'.number_format((double)$panel_xml->cconfirmed, 2, ',', '.').' €</strong></p></td>
<td>
<img src="'.$panel_xml->conversiongraph.'&chs=110x62">
<img src="'.$panel_xml->commissiongraph.'&chs=110x62">
</td>
</tr>
<tr></table>';
}
	// Display whatever it is you want to show
	echo '<h4>Últimas noticias</h4>';
$rss = fetch_feed( "http://www.geazen.es/feed" );
 
     if ( is_wp_error($rss) ) {
          if ( is_admin() || current_user_can('manage_options') ) {
               echo '<p>';
               printf(__('<strong>RSS Error</strong>: %s'), $rss->get_error_message());
               echo '</p>';
          }
     return;
}
 
if ( !$rss->get_item_quantity() ) {
     echo '<p>De momento no hay noticias!</p>';
     $rss->__destruct();
     unset($rss);
     return;
}
 
echo "<div class='rss-widget'><ul>";
 
if ( !isset($items) )
     $items = 3;
 
     foreach ( $rss->get_items(0, $items) as $item ) {
          $publisher = '';
          $site_link = '';
          $title = '';
          $link = '';
          $content = '';
          $pubdate = '';
          $link = esc_url( strip_tags( $item->get_link() ) );
          $title = $item->get_title();
          $pubdate = date_i18n(get_option('date_format') ,strtotime($item->get_date()));
          $content = $item->get_content();
          $content = wp_html_excerpt($content, 200) . ' ...';
 
         echo "<li><a class='rsswidget' href='$link' target ='_blank'>$title</a> <span class='rss-date'>$pubdate</span><div class='rssSummary'>$content</div></li>";
}
 
echo "</ul></div>";
$rss->__destruct();
unset($rss);


	
} 



// Create the function use in the action hook

function geazen_add_dashboard_widgets() {
  
  if(current_user_can('manage_options')){
	wp_add_dashboard_widget('geazen_dashboard_widget', 'Geazen', 'geazen_dashboard_widget_function');
  // Globalize the metaboxes array, this holds all the widgets for wp-admin

	global $wp_meta_boxes;
	
	// Get the regular dashboard widgets array 
	// (which has our new widget already but at the end)

	$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
	
	// Backup and delete our new dashbaord widget from the end of the array

	$geazen_widget_backup = array('geazen_dashboard_widget' => $normal_dashboard['geazen_dashboard_widget']);
	unset($normal_dashboard['geazen_dashboard_widget']);

	// Merge the two arrays together so our widget is at the beginning

	$sorted_dashboard = array_merge($geazen_widget_backup, $normal_dashboard);

	// Save the sorted array back into the original metaboxes 

	$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
  }	
} 

// Hook into the 'wp_dashboard_setup' action to register our other functions


add_action('wp_dashboard_setup', 'geazen_add_dashboard_widgets' );


?>