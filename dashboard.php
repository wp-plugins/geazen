<?PHP

// Create the function to output the contents of our Dashboard Widget

function geazen_dashboard_widget_function() {
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

// Hook into the 'wp_dashboard_setup' action to register our other functions

add_action('wp_dashboard_setup', 'geazen_add_dashboard_widgets' );

?>