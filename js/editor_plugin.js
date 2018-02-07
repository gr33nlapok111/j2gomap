(function() {
	tinymce.create('tinymce.plugins.j2gomap', {
		init : function(ed, url) {
			ed.addButton('j2gomap', {
				title : 'j2gomap',
				image : url+'/gmap.png',
				onclick : function() {
						ed.execCommand('mceInsertContent', false, '[j2gomap marker_id="j2gom4p" address="cebu,visayas,philippines" marker="" desc="marker description" zoom="10" popup="false" width="100%" height="300px"]');
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		},
		getInfo : function() {
			return {
				longname : "j2gomap Shortcode",
				author : 'Johndy Dejito',
				authorurl : '',
				infourl : '',
				version : "1.0"
			};
		}
	});
	tinymce.PluginManager.add('j2gomap', tinymce.plugins.j2gomap);
})();