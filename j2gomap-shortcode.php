<?php/** Add these functions to your functions.php file* add the shortcode handler for j2gomap* [j2gomap]*/

function j2gomap_shortcode( $atts, $content = null,$post ){
	extract(shortcode_atts(array(
		'marker_id' => 'j2gom4p_2'.$post->ID,
		'address' => 'cebu,visayas,philippines',
		'marker' => null,
		'desc' => null,
		'zoom' => 16,		'popup' => "false",		'width' => "100%",		'height' => "300px",
	), $atts));
	ob_start(); //ob_start able to capture html and corvert it to string
	$get_gomap_opt = get_option('wp_j2gomap_opts');
	$marker_icon = empty($get_gomap_opt['marker_icon']) ? 'http://maps.google.com/mapfiles/marker_yellow.png' : $get_gomap_opt['marker_icon'];
	$map_type = empty($get_gomap_opt['m_type']) ? 'ROADMAP' : strtoupper($get_gomap_opt['m_type']);
	$markers = explode('+',$marker);
	$ctr = count($markers);
?><?php if($popup == "true"):$alt = $address.";".$marker.";".$desc.";".$zoom.";".get_map_type().";".get_marker_icon();?><a href="javascript:void(0);" id="<?php echo $marker_id; ?>" class="loadj2goMap" alt="<?php echo $alt; ?>">Show map</a><?php else: ?>
<div class="gomap_wrapper">
	<script type="text/javascript">
	j2Query(function(){
        j2Query('#<?php echo $marker_id; ?>').width("<?php echo $width; ?>").height("<?php echo $height; ?>").gmap3({
          marker:{
            values:[
			  <?php
				if($marker){
					for($i = 0; $i < $ctr; $i++){
						if($i <= $ctr){	$nl = ",";	}else{	$nl = "";	}
						echo '{ address: "'.$markers[$i].'", data: "'.$markers[$i].'", options:{icon: "'.$marker_icon.'"}}'.$nl;
					}
				}else{
					echo '{ address: "'.$address.'", data: "'.$desc.'", options:{icon: "'.$marker_icon.'"}}';
				}
			  ?>],
            options:{
              draggable: false
            }, 
            events:{
			  dragend: function(marker){
				j2Query(this).gmap3({
				  getaddress:{
					latLng:marker.getPosition()
				  }
				});
			  },mouseover: function(marker, event, context){
					var map = j2Query(this).gmap3("get"),
					infowindow = j2Query(this).gmap3({get:{name:"infowindow"}});
				if (infowindow){
				  infowindow.open(map, marker);
				  infowindow.setContent(context.data);
				} else {
				  j2Query(this).gmap3({
					infowindow:{
					  anchor:marker, 
					  options:{content: context.data}
					}
				  });
				}
			  },
			  mouseout: function(){
				var infowindow = j2Query(this).gmap3({get:{name:"infowindow"}});
				if (infowindow){
				  infowindow.close();
				}
			  }
			}
          },
			map:{
				options:{
				zoom: <?php echo $zoom;	?>,
				mapTypeId: google.maps.MapTypeId.<?php echo $map_type;	?>
				}
			}
        });
	});
	</script>
	<div id="<?php	echo $marker_id;	?>" class="gmap3"></div>
</div><?php endif; ?>
	<?php
		$output_string = ob_get_contents();
		ob_end_clean();
	?>
<?php
	return $output_string;
}
add_shortcode( 'j2gomap', 'j2gomap_shortcode' );
function add_j2gomap_button() {
   // Don't bother doing this stuff if the current user lacks permissions
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
     return;
   // Add only in Rich Editor mode
   if ( get_user_option('rich_editing') == 'true') {
     add_filter("mce_external_plugins", "add_j2gomap_tinymce_plugin");
     add_filter('mce_buttons', 'register_j2gomap_button');
   }
}
function register_j2gomap_button($buttons) {
   array_push($buttons, "|", "j2gomap");
   return $buttons;
}
// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
function add_j2gomap_tinymce_plugin($plugin_array) {
   $plugin_array['j2gomap'] = plugins_url( '/js/editor_plugin.js' , __FILE__ );
   return $plugin_array;
}
function my_refresh_mce($ver) {
  $ver += 3;
  return $ver;
}
// init process for button control
add_filter( 'tiny_mce_version', 'my_refresh_mce');
add_action('init', 'add_j2gomap_button');
?>