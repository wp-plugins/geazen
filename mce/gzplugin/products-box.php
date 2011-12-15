<?php
//include wp-config or wp-load.php

$root = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))));

if (file_exists($root.'/wp-load.php')) {

// WP 2.6

require_once($root.'/wp-load.php');

} else {

// Before 2.6

require_once($root.'/wp-config.php');

}
?>

<html>
<script type="text/javascript" src="<?php get_bloginfo('url'); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<link rel='stylesheet' href='<?php get_bloginfo('url'); ?>/wp-admin/load-styles.php?c=1&amp;dir=ltr&amp;load=global,wp-admin&amp;ver=6fc53cd39ae6e24cbe8675674f4082af' type='text/css' media='all' />
<link rel='stylesheet' id='thickbox-css'  href='<?php get_bloginfo('url'); ?>/wp-includes/js/thickbox/thickbox.css?ver=20090514' type='text/css' media='all' />
<link rel='stylesheet' id='colors-css'  href='<?php get_bloginfo('url'); ?>/wp-admin/css/colors-fresh.css?ver=20110703' type='text/css' media='all' />

<head>

<script type="text/javascript">
function inserta_enlace(code)
{
tinyMCEPopup.editor.execCommand('mceInsertContent', false, code); 
tinyMCEPopup.close();
}
</script>
<TITLE>Productos relacionados con: <?php echo $_GET['content']; ?></TITLE>
</head>

<body>

 
<div id="container" >	

	
<?php


$contenido = $_GET['content'];
$gz_aid = get_option('gz_aid');
if($gz_aid=='')
{
  echo '<center><h4>El plugin Geazen no está configurado correctamente.</br> Visita la <a href="'.get_bloginfo('url').'/wp-admin/admin.php?page=geazen_conection" target="_parent">página de configuración</a></h4></center>';exit();
}
  echo '<center><h3>Productos relacionados con: '.$contenido.'</h3></center>';


libxml_use_internal_errors(true);

$productos_xml = simplexml_load_file('http://affiliation.geazen.com/gz-plugin/gz-products.php?aid='.$gz_aid.'&content='.utf8_encode($contenido));

if (count($productos_xml->product)==0){echo '<div class="postbox"><center><h4>No se encontraron productos.</h4></center></div>';exit();}

foreach ($productos_xml->product as $product) {

	echo '<div class="postbox">';


echo '<div class="inside">';

						echo '<img style="border:1px solid;padding:2px;color:#DFDFDF;float: left;margin-right:10px;"  src="'.$product->imageurl.'" width="80" height="80">';
						
						echo '<div style="margin-left:95px;width:410px;">';
            
            
            
            if ($product->campaignid<>'')
            {
              echo '<p><h4>'.$product->title.'</h4> <img style="border:1px solid;padding:2px;color:#DFDFDF;float:right;margin:5px;"  src="'.$product->clogo.'" width="40" height="40"></p>';
              echo '<p>'.substr($product->description,0,200).'...</p>';
              echo '<p style="align:right;"> <b><span style="margin-right:15px;">'.$product->price.' '.$product->currency.'</span></b>';
              echo '<span style="margin-right:15px;"> <a class="button-secondary" href="'.$product->destinationurl.'" target="_blank">Visitar página</a></span>';
              $code = str_replace('%product_url%',$product->url,stripcslashes(get_option('gz_htmlproducts' )));
              $code = str_replace('%product_text%',$contenido,$code);
              $code = str_replace('%product_image%',$product->imageurl,$code);
              $code = str_replace('%product_title%',$product->title,$code);
              $code = str_replace('%product_description%',$product->description,$code);
              $code = str_replace('%product_price%',$product->price,$code);
              $code = str_replace('%product_currency%',$product->currency,$code);
              $code = str_replace('%product_logo%',$product->clogo,$code);
              
              $code = str_replace('"','\'',$code);
              $code = str_replace(chr(10),'',$code);
              $code = str_replace(chr(13),'',$code);
              
              echo '<a class="button-primary" href="#" onclick="inserta_enlace(\''.js_encode(utf8_decode($code)).'\');">Insertar enlace</a></p>';
            }
            else
            {
              //Desactivado
              echo '<p><h4 style="font-weight:bold;color:#BBBBBB;">'.$product->title.'</h4> <img style="border:1px solid;padding:2px;color:#DFDFDF;float:right;margin:5px;"  src="'.$product->clogo.'" width="40" height="40"></p>';
              echo '<p style="color:#BBBBBB;">'.$product->description.'</p>';
              echo '<p style="align:right;color:#BBBBBB;"> <b><span style="margin-right:15px;">'.$product->price.' '.$product->currency.'</span></b>';
              echo '<span style="margin-right:15px;"> <a class="button-secondary" href="'.$product->destinationurl.'" target="_blank">Visitar página</a> </span>';
            
              echo '<label class="button-primary button-disabled" onclick="" title="Aún no estás aprobado en el programa.">Insertar enlace</label></p>';
            }
            echo '</div>';
            
            
            
            echo '</div>';
            
            echo '</div>';
            }
function js_encode($s){ 
    $texto=''; 
    $lon=strlen($s); 
    for($i=0;$i<$lon;++$i){ 
        $num=ord($s[$i]); 
        if($num<16) $texto.='\x0'.dechex($num); 
        else $texto.='\x'.dechex($num); 
    } 
    return $texto; 
} 
?>

</div>

</body>
</html>