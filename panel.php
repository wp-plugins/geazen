<?PHP
function geazen_panel() {

    if (!current_user_can('manage_options'))  {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }
     
      // Read Config
      $gz_user = get_option('gz_user' );
      $gz_pass = get_option('gz_pass' );
      $gz_aid = get_option('gz_aid' );
      $gz_htmllinks = stripslashes(get_option('gz_htmllinks' ));
      $gz_htmlproducts = stripslashes(get_option('gz_htmlproducts' ));
      $gz_autolink_keywords = get_option('gz_autolink_keywords' );
      $gz_autolink_htmllinks = stripslashes(get_option('gz_autolink_htmllinks'));


if(get_option ('gz_aid')==''){echo '<div id="message" class="error fade"><p>El plugin Geazen no está configurado correctamente. Visita la <a href="'.get_bloginfo('url').'/wp-admin/admin.php?page=geazen_conection" target="_parent">página de conexión</a></p></div>';return;}    
if(get_option ('gz_panel_xml')==''){echo '<div id="message" class="updated fade"><p>Aún no se dispone de datos, estos son actualizados cada hora. Vuelva más tarde.</p></div>';return;}


libxml_use_internal_errors(true);




$panel_xml = simplexml_load_string(get_option ('gz_panel_xml'));

    
      // Now display the settings editing screen
  
      echo '<div class="wrap">';
  
      // header
      
        
  
      //echo '<h1><img src="'.plugins_url().'/geazen/images/logo-geazen-dark.png">' . __( 'Configuración Geazen', 'geazen_menu' ) . '</h1>';
      echo '<table cellspacing="10"><tr><td style="vertical-align: middle;">
            <tr> 
            <td><img src="'.plugins_url().'/geazen/images/logo-geazen-dark.png" width="80" height="80"></td>
            <td style="vertical-align: middle;"><h1>'
            . __( 'Panel Geazen', 'geazen_menu' ).
            '</h1></td></tr>
            </tr></table>';
            
        
echo '
<div class="wrap alternate">
        <h2>Datos generales</h2>
        <p>Datos de afiliado y totales acumulados de tu cuenta.</p>      
<table class="form-table">
<tbody>
<tr>
<td>
<p>Afiliado: <strong>'.$panel_xml->nombre.'</strong></p>
<p>Nº de comisiones pendientes: <strong>'.number_format((double)$panel_xml->pending, 0, ',', '.').'</strong></p>
<p>Importe de las comisiones pendientes: <strong>'.number_format((double)$panel_xml->cpending, 2, ',', '.').' €</strong></p>
<p>Nº de comisiones confirmadas: <strong>'.number_format((double)$panel_xml->confirmed, 0, ',', '.').'</strong></p>
<p>Importe confirmado y pendiente de pago: <strong>'.number_format((double)$panel_xml->cconfirmed, 2, ',', '.').' €</strong></p>
</td>
</tr>
</table></div>


<div class="wrap alternate">
        <h2>Estadísticas</h2>
        <p>Estadísticas de tu cuenta de afiliado generadas en los últimos 30 días.</p>';




// if (count($links_xml->link)==0){echo '<div class="postbox"><center><h4>No se encontraron enlaces.</h4></center></div>';exit();}

echo'<table width="700">
<tr>
<td>
<p>Impresiones: <strong>'.number_format((double)$panel_xml->totalimpresions, 0, ',', '.').'</strong></p>
<p>Clicks: <strong>'.number_format((double)$panel_xml->totalclicks, 0, ',', '.').'</strong></p>
</td>
<td>
<p>Conversiones: <strong>'.number_format((double)$panel_xml->totalconversions, 0, ',', '.').'</strong></p>
<p>Comisiones: <strong>'.number_format((double)$panel_xml->totalcommissions, 2, ',', '.').' €</strong></p>
</td>
</tr>
<tr>
<td><img src="'.$panel_xml->impressionsgraph.'&chs=220x125">
</td>
<td><img src="'.$panel_xml->clicksgraph.'&chs=220x125">
</td>

</tr>
<tr>
<td><img src="'.$panel_xml->conversiongraph.'&chs=220x125">
</td>
<td><img src="'.$panel_xml->commissiongraph.'&chs=220x125">
</td>
</tr>
</table>
</tr>

</table></div>';


echo'<div class="wrap alternate">
        <h2>Transacciones</h2>
        <p>Listado de las transacciones generadas en los últimos 30 días.</p>
        <table class="widefat"> 
			<thead>
				<tr>
				<th scope="col">Logo</th>
				<th scope="col">Programa</th>
				<th scope="col">Estado</th>
        <th scope="col">Tipo</th>
				<th scope="col" style="text-align:right">Total</th>
				<th scope="col" style="text-align:right">Comisión</th>
				<th scope="col">Fecha</th>
				<th scope="col">Hora</th>
				<th scope="col">Canal</th>
				<th scope="col">Data 1</th>
				</tr>
			</thead>';		

foreach($panel_xml->transactions->transaction as $transaction)
{
  echo '<tr class="alternate">';
	echo '<td><img src="'.$transaction->logo.'" width="32" height="32"></td>';
	echo '<td>'.$transaction->programa.'</td>';
	echo '<td>'.$transaction->estado.'</td>';
	echo '<td>'.$transaction->tipo.'</td>';
	echo '<td style="text-align:right">'.number_format((double)$transaction->total, 2, ',', '.').' €</td>';
	echo '<td style="text-align:right"><strong>'.number_format((double)$transaction->comision, 2, ',', '.').' €</strong></td>';
	echo '<td>'. date_i18n(get_option('date_format') ,strtotime((double)$transaction->fecha)).'</td>';
	echo '<td>'. date_i18n(get_option('time_format') ,strtotime((double)$transaction->fecha)).'</td>';
	echo '<td>'.$transaction->canal.'</td>';
	echo '<td>'.$transaction->data1.'</td>';
	echo '<tr>';
}

echo '</table></div>';

}

?>