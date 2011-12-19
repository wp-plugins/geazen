<?PHP
function geazen_conection() {

    if (!current_user_can('manage_options'))  {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }
     
      // Read Config
      $gz_user = get_option('gz_user' );
      $gz_pass = get_option('gz_pass' );
      $gz_aid = get_option('gz_aid' );

          if( isset($_POST['gz_aid'])) {

			          if ($_POST['gz_aid']!='')
			          {
			          $gz_user=$_POST['gz_user' ];
        			  $gz_pass=$_POST['gz_pass' ];
        			  $gz_aid=$_POST['gz_aid' ];
			          update_option( 'gz_user', $gz_user );
			          update_option( 'gz_pass', $gz_pass );
			          update_option( 'gz_aid', $gz_aid );


                 
			          // Put an settings updated message on the screen
			          echo '<div id="message" class="updated fade"><p>Los datos fueron actualizados.</p></div>';
			         }
			         else
			         {
			         	// Put an settings updated message on the screen
			          echo '<div id="message" class="error fade"><p>Los datos no fueron actualizados. Datos de conexión a Geazen incorrectos.</p></div>';
			         }
  
   
        }
                              
   
          ?>
                 
                 
<?php 
//Javascript 

echo '<script language="javascript">
jQuery(document).ready(function() {
   
    jQuery(document).ajaxStart(function() {
        jQuery(\'#loader\').fadeIn(\'slow\');
        jQuery(\'#respuesta\').hide();
    }).ajaxStop(function() {
        jQuery(\'#loader\').hide();
        jQuery(\'#respuesta\').fadeIn(\'slow\');
    });
   // Interceptamos el evento submit
    jQuery(\'#form, #fat, #loginForm\').submit(function() {
  // Enviamos el formulario usando AJAX
        jQuery.ajax({
            type: \'POST\',
            url: jQuery(this).attr(\'action\'),
            data: jQuery(this).serialize(),
            // Mostramos un mensaje con la respuesta de PHP
            success: function(data) {
                jQuery(\'#respuesta\').html(data);
            }
        })        
        return false;
    });
})  
</script>';


      // Now display the settings editing screen
  
      echo '<div class="wrap">';
  
      // header
      
        
  
      //echo '<h1><img src="'.plugins_url().'/geazen/images/logo-geazen-dark.png">' . __( 'Configuración Geazen', 'geazen_menu' ) . '</h1>';
      echo '<table cellspacing="10"><tr><td style="vertical-align: middle;">
            <tr> 
            <td><img src="'.plugins_url().'/geazen/images/logo-geazen-dark.png" width="80" height="80"></td>
            <td style="vertical-align: middle;"><h1>'
            . __( 'Datos de conexión', 'geazen_menu' ).
            '</h1></td></tr>
            </tr></table>';
            
             if ($gz_aid=='')
                {
                 echo '<div class="postbox"><div class="inside"><p>Completa los datos de conexión del plugin con tu usuario y contraseña de afiliado en Geazen.</br>
                 Si aún no eres afiliado, puedes darte de alta desde <a href="http://affiliation.geazen.com/scripts/click.php?aid=4d4c235924e76&gid=f8e454ab&chan=code19" target="_blank">este formulario</a>. Una vez hayas obtenido tu usuario y contraseña, vuelve a esta página y completa los datos de conexión.
                 </p></div></div>';
                }     
         
echo '      
<table class="form-table">
<tbody>
<tr>
<th style="text-align:left; vertical-align:top;" scope="row">
<h2>Conexión</h2>
</th>
<td>
</td>  
</tr>


<form id="loginForm" action="'.plugins_url().'/geazen/login.php" method="post" name="loginForm">

<tr>
<td>
  <label><strong>Usuario:</strong></label>
</td>
<td>  
  <input id="inputuser" type="text" name="user" onchange="document.getElementById(\'gz_user\').value=document.getElementById(\'inputuser\').value;" value="'.$gz_user.'"/>
<td>
</tr>
<td>
  <label><strong>Contraseña:</strong></label>
</td>
<td>  
  <input id="inputpass" type="password" name="password" onblur="document.getElementById(\'gz_pass\').value=document.getElementById(\'inputpass\').value;" value="'.$gz_pass.'"/>
<td>
</tr>
<tr> 
<td>
</td>
<td> 
  
  <input class="button-secondary" type="submit" name="submit" value="Prueba de conexión" />
  <span>
   <img id="loader" style="display:none;" src="'.plugins_url().'/geazen/images/loader.gif'.'"> <label id="respuesta"></label>
  </span>
  </td>
    
</tr>  
</form>  
<tr>
<td>
<form method="post" action="" name="formu">
<input name="gz_user" id="gz_user" type="hidden" value="'.$gz_user.'">
<input name="gz_pass" id="gz_pass" type="hidden" value="'.$gz_pass.'">
<input name="gz_aid" id="gz_aid" type="hidden" value="'.$gz_aid.'">
</td>
<td>
<p><input class="button-primary" type="submit" name="submit" value="Actualizar" /></p>
</form>
</td>
</tr>
</tbody>
</table>';
	


}