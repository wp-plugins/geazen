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

<TITLE>Enlaces relacionados con: <?php echo $_GET['content']; ?></TITLE>
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

echo '<center><h3>Enlaces relacionados con: '.$contenido.'</h3></center>';



libxml_use_internal_errors(true);

$links_xml = simplexml_load_file('http://affiliation.geazen.com/gz-plugin/gz-links.php?aid='.$gz_aid.'&content='.utf8_encode($contenido));

if (count($links_xml->link)==0){echo '<div class="postbox"><center><h4>No se encontraron enlaces.</h4></center></div>';exit();}

foreach ($links_xml->link as $link) {

echo '<div class="postbox">';


echo '<div class="inside">';

						echo '<img style="border:1px solid;padding:2px;color:#DFDFDF;float: left;margin-right:10px;"  src="'.$link->clogo.'" width="80" height="80">';
						
						echo '<div style="margin-left:95px;">';
            
            
            
            if ($link->campaignid<>'')
            {
              echo '<p><h4>'.$link->title.'</h4>';
              echo '<p>'.$link->description.'</p>';
              echo '<span style="margin-right:15px;"> <a class="button-secondary" href="'.$link->destinationurl.'" target="_blank">Visitar página</a></span>';
              $code = str_replace('%link_url%',$link->url,stripcslashes(get_option('gz_htmllinks' )));
              $code = str_replace('%link_text%',$contenido,$code);
              $code = str_replace('%link_title%',$link->campaign,$code);
              $code = str_replace('%link_logo%',$link->clogo,$code);
              $code = str_replace('"','\'',$code);
              $code = str_replace(chr(10),'',$code);
              $code = str_replace(chr(13),'',$code);
              
              echo '<a class="button-primary" href="#" onclick="inserta_enlace(\''.addslashes($code).'\');">Insertar enlace</a></p>';
            }
            else
            {
              //Desactivado
              echo '<p><h4 style="font-weight:bold;color:#BBBBBB;">'.$link->title.'</h4>';
              echo '<p style="color:#BBBBBB;">'.$link->description.'</p>';
              echo '<span style="margin-right:15px;"> <a class="button-secondary" href="'.$link->destinationurl.'" target="_blank">Visitar página</a> </span>';
            
              echo '<label class="button-primary button-disabled" onclick="" title="Aún no estás aprobado en el programa.">Insertar enlace</label></p>';
            }
            echo '</div>';
            
            
            
            echo '</div>';
            
            echo '</div>';
            }

?>

</div>

</body>
</html>