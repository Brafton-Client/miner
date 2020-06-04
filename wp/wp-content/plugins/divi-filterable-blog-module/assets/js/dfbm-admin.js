(function($){
	$(function(){
	"use strict";

		var dfbmAdmin = function( $opt )
		{

			this.init( $opt );

		};

		$.extend( dfbmAdmin.prototype,
		{

			init : function( $opt )
			{

				this.vars( $opt );

				this.load();

			}, // end init

			vars : function( $opt )
			{

				this.opt = $.extend( {},
				{

					prefix  : 'et_pb_templates_',
					prfix   : '',
					newVers : '',
					error   : '',
					slugs   : '',

				}, $opt );

				this.prfix   = new RegExp( this.opt.prfix );

				this.newVers = parseInt( this.opt.newVers );

			}, // end vars

			load : function()
			{

				var $this = this, checkStorage = setInterval( function()
				{

					if ( 'string' == typeof localStorage.et_pb_templates_settings_product_version )
					{

						clearInterval( checkStorage );

						setTimeout( function()
						{

							if ( $this.newVers )
								$this.rebuild( false );

							else $this.check();

						}, 1000 );
					}
				}, 300 );
			}, // end load

			check : function()
			{

				if ( ! this.local() )
					return;

				var item, temp, mods = [];

				for ( item in localStorage )
				{

					if ( -1 !== item.indexOf( this.prfix ) )
					{

						mods.push( item );

					}
				}

				if ( mods.length != this.opt.slugs.length )
					this.rebuild( true, mods );

			}, // end check

			local : function()
			{

				return 'localStorage' in window && window.localStorage !== null;

			},

			rebuild : function( clear, mods )
			{

				var $this = this,
					mods  = mods || false,
					pref  = 'et_pb_templates_';

				if ( ! clear )
					this.clear();

				if ( mods )
					var get = this.opt.slugs.filter( function( item )
					{

						return mods.indexOf( pref + item ) < 0

					});

				else
					get = this.opt.slugs;

				$.ajax(
				{

					type     : 'post',
					dataType : 'json',
					url      : et_pb_options.ajaxurl,
					data:
					{

						action              : 'et_pb_get_backbone_template',
						et_post_type        : et_pb_options.post_type,
						et_admin_load_nonce : et_pb_options.et_admin_load_nonce,
						et_modules_slugs    : JSON.stringify({ missing_modules_array: get }),

					},
					success: function( data )
					{

						if ( 'undefined' != typeof data.templates && data.templates.length > 0 )
						{

							$.each( data.templates, function( i, item )
							{

								var template = $this.template( item['template'], data.unique );

								if ( $this.local() )
								{

									try
									{

										localStorage.setItem( pref + item['slug'], LZString.compressToUTF16( template ) );

									}

									catch(e)
									{

										// nothing needs to happen here

									}
								}

								$( '#et-builder-' + item['slug'] + '-module-template' ).remove();

								$( 'body' ).append( template );

							});
						} // end if
					},

					error: function( r )
					{

						console.log( r );

			        }
				});
			}, // end rebuild

			template : function( template, map )
			{

				if ( 'undefined' == typeof map )
					return template;

				var str = /<!-- (\d+) -->/g;

				return template.replace( str, function( match, key )
				{

					return map[key];

				} );
			},

			clear : function()
			{

				for ( var item in localStorage )
				{

					if ( -1 !== item.indexOf( this.prfix ) )
						localStorage.removeItem( item );

				}
			}, // end clear

			error : function()
			{

				this.clear();

				alert( this.opt.error );

			}, // end error

			local : function()
			{

				return 'localStorage' in window && window.localStorage !== null;

			}, // end local
		}); // end dfbmAdmin

		new dfbmAdmin(
		{

			prfix   : dfbmPHP.prfix,
			newVers : dfbmPHP.new,
			error   : dfbmPHP.error,
			slugs   : dfbmPHP.slugs,

		});

	});
}(jQuery));
