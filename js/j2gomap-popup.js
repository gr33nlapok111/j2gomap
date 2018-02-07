j2Query('body').append('<div class="j2gomap_overlay" style="display:none;"></div><div class="j2gomap_popup_wrapper" style="display:none;"><a href="javascript:void(0);" class="close_gmap">close</a><div id="j2gomap_popup"></div></div>');
j2Query( '.loadj2goMap' ).on( 'click', function() {
	var post_id = j2Query(this).attr('id');
	var post = j2Query(this).attr('alt');
	var j2gomap_val = post.split(";");
	var markers = j2gomap_val[1].split("+");
	var address = (markers[0] == "") ? j2gomap_val[0] : markers[0];
	var desc = j2gomap_val[2];
	var zoom = parseInt(j2gomap_val[3]);
	var type = j2gomap_val[4].toString();
	var m_icon = j2gomap_val[5];	var arr_markers = [];	var m;			// if(markers.length <= 1){		// arr_markers = {address: address, data: desc, options:{icon: m_icon}};	// }else{				for(m=0;m < markers.length; m++){		arr_markers.push({address: markers[m], data: markers[m], options:{icon: m_icon}});		}		// console.log(arr_markers);	// }		
	j2Query('#j2gomap_popup').width("100%").height("100%").gmap3({
		marker:{
				values:arr_markers,					
				options:{
					draggable:false
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
			zoom: zoom,
			mapTypeId: google.maps.MapTypeId.ROADMAP
			}
		}
	});
		j2Query(".j2gomap_overlay,.j2gomap_popup_wrapper").fadeIn(300);
});
j2Query('.close_gmap').click(function(){
	j2Query(".j2gomap_overlay,.j2gomap_popup_wrapper").hide();
});