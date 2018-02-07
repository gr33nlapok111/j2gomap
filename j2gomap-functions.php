<?php

function get_width( $w = '500'){
		$get_gomap_opts = get_option('wp_j2gomap_opts');
		$w = empty($get_gomap_opts['wcss']) ? $w : $get_gomap_opts['wcss'];
		$v = ($get_gomap_opts['wtcss'] == 'pt') ? '%' : 'px';
		
		return $w.$v;
}

function get_height( $h = '400'){
		$get_gomap_opts = get_option('wp_j2gomap_opts');
		$h = empty($get_gomap_opts['hcss']) ? $h : $get_gomap_opts['hcss'];
		$v = ($get_gomap_opts['htcss'] == 'pt') ? '%' : 'px';
		
		return $h.$v;
}

function get_zoom(){
		$get_gomap_opts = get_option('wp_j2gomap_opts');
		$zoom = empty($get_gomap_opts['zoom']) ? '12' : strtoupper($get_gomap_opts['zoom']);
		
		return $zoom;
}
function get_map_type(){
		$get_gomap_opts = get_option('wp_j2gomap_opts');
		$map_type = empty($get_gomap_opts['m_type']) ? 'ROADMAP' : strtoupper($get_gomap_opts['m_type']);
		
		return $map_type;
}
function get_marker_icon(){
		$get_gomap_opts = get_option('wp_j2gomap_opts');
		$marker_icon = empty($get_gomap_opts['marker_icon']) ? 'http://maps.google.com/mapfiles/marker_green.png' : $get_gomap_opts['marker_icon'];
		
		return $marker_icon;
}
function get_gapi(){		$get_gomap_opts = get_option('wp_j2gomap_opts');		$api = empty($get_gomap_opts['marker_api']) ? null : $get_gomap_opts['marker_api'];				return $api;}
?>