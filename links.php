<?PHP
function geazen_links() {

    if (!current_user_can('manage_options'))  {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }
     
      // Read Config
      $gz_user = get_option('gz_user' );
      $gz_pass = get_option('gz_pass' );
      $gz_aid = get_option('gz_aid' );
      $gz_htmllinks = stripslashes(get_option('gz_htmllinks' ));
      $gz_htmlproducts = stripslashes(get_option('gz_htmlproducts' ));

          if( isset($_POST['gz_htmllinks'])) {
          // Save the posted value in the database

	        			  $gz_htmllinks=$_POST['gz_htmllinks' ];
        			  $gz_htmlproducts=$_POST['gz_htmlproducts' ];
			          update_option( 'gz_htmllinks', $gz_htmllinks );
			          update_option( 'gz_htmlproducts', $gz_htmlproducts );
         			  $gz_htmllinks=stripslashes($_POST['gz_htmllinks' ]);
        			  $gz_htmlproducts=stripslashes($_POST['gz_htmlproducts' ]);
                 
			          // Put an settings updated message on the screen
			          echo '<div id="message" class="updated fade"><p>Los datos fueron actualizados.</p></div>';
			         }
			         /*else
			         {
			         	// Put an settings updated message on the screen
			          echo '<div id="message" class="error fade"><p>Los datos no fueron actualizados. Datos de conexión a Geazen incorrectos.</p></div>';
			         }*/
  
         
        
                              
   

      // Now display the settings editing screen
  
      echo '<div class="wrap">';
  
      // header
      
        
  
      //echo '<h1><img src="'.plugins_url().'/geazen/images/logo-geazen-dark.png">' . __( 'Configuración Geazen', 'geazen_menu' ) . '</h1>';
      echo '<table cellspacing="10"><tr><td style="vertical-align: middle;">
            <tr> 
            <td><img src="'.plugins_url().'/geazen/images/logo-geazen-dark.png" width="80" height="80"></td>
            <td style="vertical-align: middle;"><h1>'
            . __( 'Enlaces de editor', 'geazen_menu' ).
            '</h1></td></tr>
            </tr></table>';

echo '<div class="postbox"><div class="inside"><p>Los enlaces de editor son aquellos que el plugin nos permite insertar desde el editor de artículos de Wordpress.</br>
En la barra de botones del editor de texto aparecerán 2 nuevos botones <img src="'.plugins_url().'/geazen/mce/gzplugin/images/gzplugin-products.gif"> <img src="'.plugins_url().'/geazen/mce/gzplugin/images/gzplugin-links.gif"> para insertar enlaces. Uno nos permitirá añadir enlaces a productos y el otro enlaces a las landings de los programas de afiliación de Geazen.</br>
Solo tienes que seleccionar un texto de tu artículo y pulsar uno de los botones, el plugin te mostrará una lista de los enlaces más adecuados a insertar.</br>                                                                 
A continuación puedes personalizar las plantillas HTML del código generado para los enlaces. 
                 </p></div></div>';            
        
echo '      
<table class="form-table">
<tbody>

<form method="post" action="" name="formu">
<tr>
<th style="text-align:left; vertical-align:top;" scope="row">
<h2>Plantillas</h2>
</th>
</tr>


<tr>
<td><strong>Platilla HTML para productos</strong></td>
<td>
  <p>Edita la plantilla, puedes utilizar código HTML. Las variables contenidas entre "%" serán sustituidas por sus valores. Consulta las lista más abajo.</p> 
  <textarea rows="8" cols="80" id="inputhtmlproducts" name="gz_htmlproducts" />'.$gz_htmlproducts.'</textarea>
  <p>Variables disponibles</p>
  <ul>
  <li><code>%product_text%</code> - Texto tomado del post (Keyword utilizada en la búsqueda).</li>
  <li><code>%product_url%</code> - URL trackeada de la página del producto.</li> 
  <li><code>%product_image%</code> - URL de la imagen del producto.</li>
  <li><code>%product_title%</code> - Nombre completo del producto.</li>
  <li><code>%product_description%</code> - Pequeña descripción acerca del producto.</li>
  <li><code>%product_price%</code> - Precio.</li>
  <li><code>%product_currency%</code> - Moneda.</li>
  <li><code>%product_logo%</code> - Logo del anunciante.</li>
  </ul>
</td>
</tr>

<tr>
<td><strong>Platilla HTML para enlaces</strong></td>
<td>
<p>Edita la plantilla, puedes utilizar código HTML. Las variables contenidas entre "%" serán sustituidas por sus valores. Consulta las lista más abajo.</p>
<textarea rows="4" cols="80" id="inputhtmllinks" name="gz_htmllinks" />'.$gz_htmllinks.'</textarea>
  <p>Variables disponibles</p>
  <ul>
  <li><code>%link_text%</code> - Texto tomado del post (Keyword utilizada en la búsqueda).</li>
  <li><code>%link_url%</code> - URL trackeada a la landing del programa.</li> 
  <li><code>%link_title%</code> - Título del programa.</li>
  <li><code>%link_logo%</code> - Logo del anunciante.</li>
  </ul>
</td>  
</tr>



</table>


<input name="gz_user" id="gz_user" type="hidden" value="'.$gz_user.'">
<input name="gz_pass" id="gz_pass" type="hidden" value="'.$gz_pass.'">
<input name="gz_aid" id="gz_aid" type="hidden" value="'.$gz_aid.'">
<p><input class="button-primary" type="submit" name="submit" value="Actualizar" /></p>
</form>';
	

}
?>