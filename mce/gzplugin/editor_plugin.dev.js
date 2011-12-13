(function() {
	// Load plugin specific language pack
	tinymce.PluginManager.requireLangPack('gzplugin');

	tinymce.create('tinymce.plugins.gzplugin', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {

			ed.addButton('geazen-products', {
				title : 'Insertar enlaces a productos Geazen',
				cmd : 'mcegzplugin-products',
				image : url + '/images/gzplugin-products.gif'
			});
			ed.addButton('geazen-links', {
				title : 'Insertar enlaces a landings Geazen',
				cmd : 'mcegzplugin-links',
				image : url + '/images/gzplugin-links.gif'
			});			

      ed.addCommand('mcegzplugin-products', function() {
      var selectedText = ed.selection.getContent({format : 'text'});
      if(selectedText!='' && selectedText.length>2)
      {
        ed.windowManager.open({
        title: "Buscando productos para: " + selectedText + '...',        
        file : url + '/products-box.php?content=' + selectedText ,
        width : 550 + parseInt(ed.getLang('gzplugin.delta_width', 0)),
        height : 500 + parseInt(ed.getLang('gzplugin.delta_height', 0)),
        inline : 1
        }, {
        plugin_url : url
        });
      }
      });
      ed.addCommand('mcegzplugin-links', function() {
      var selectedText = ed.selection.getContent({format : 'text'});
      if(selectedText!='' && selectedText.length>2)
      {
        ed.windowManager.open({
        title: "Buscando enlaces para: " + selectedText + '...',
        file : url + '/links-box.php?content=' + selectedText ,
        width : 550 + parseInt(ed.getLang('gzplugin.delta_width', 0)),
        height : 500 + parseInt(ed.getLang('gzplugin.delta_height', 0)),
        inline : 1
        }, {
        plugin_url : url
        });
      }
      });      

      ed.onNodeChange.add(function(ed, cm, n, co) {
         // Activates the link button when the caret is placed in a anchor element
         var DOM = tinymce.DOM;
         p = DOM.getParent(n, 'A');
         if (c = cm.get('geazen-products')) {
             if (!p || !p.name) {
                 c.setDisabled(!p && co);
                 c.setActive(!!p);
             }
         }
         if (c = cm.get('geazen-links')) {
             if (!p || !p.name) {
                 c.setDisabled(!p && co);
                 c.setActive(!!p);
             }
         }         
      });

		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'gzplugin',
				author : 'Geazen',
				authorurl : 'http://www.geazen.es',
				version : "0.0.1"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('gzplugin', tinymce.plugins.gzplugin);
})();

