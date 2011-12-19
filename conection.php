<?PHP
function geazen_conection() {

    if (!current_user_can('manage_options'))  {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }
     
      // Read Config
      $gz_user = get_option('gz_user' );
      $gz_pass = get_option('gz_pass' );
      $gz_aid = get_option('gz_aid' );
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
         
echo '<p4>Introduce a continuación tu usuario y contraseña de afiliado en Geazen.</p>      
<table>
<tbody>


<form id="loginForm" action="'.plugins_url().'/geazen/login.php" method="post" name="loginForm">

<tr>
<td>
  <label><strong>Usuario:</strong></label>
</td>
<td>  
  <input id="inputuser" type="text" name="user"  value="'.$gz_user.'"/>
<td>
</tr>
<tr>
<td>
  <label><strong>Contraseña:</strong></label>
</td>
<td>  
  <input id="inputpass" type="password" name="password"  value="'.$gz_pass.'"/>
<td>
</tr>
<tr>
</tr>
<tr> 
<td>
</td>
<td> 
  
  <input class="button-primary" type="submit" name="submit" value="Conectar" />
  <span>
   <img id="loader" style="display:none;" src="'.plugins_url().'/geazen/images/loader.gif'.'"> <label id="respuesta"></label>
  </span>
</td>
    
</tr>
  
</form>  

</tbody>
</table>';
	


}