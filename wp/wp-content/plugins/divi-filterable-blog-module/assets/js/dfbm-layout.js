(function($){
	$(function(){
	"use strict";

		$( document )
			.on( 'mousedown', 'a.et-pb-settings, ul.et-pb-all-modules > li', function()
			{

				var title = $( '#titlewrap' ).children( '#title' ).val();

				if ( ( -1 !== title.indexOf( 'DFBM-' ) ) && ( $(this).parent().hasClass( 'et_pb_module_block' ) || $(this).parent().hasClass( 'et-pb-all-modules' ) ) )
				{

					var int = setInterval( function()
					{

						var settings = $( 'div.et_pb_modal_settings_container' );

						if ( settings.length > 0 && 'module_settings' == settings.data( 'open_view' ) )
						{

							clearInterval( int );

							var module = settings
											.children( 'div.et-pb-modal-container' )
											.children( 'div.et_pb_module_settings' )
											.data( 'module_type' );

							if ( -1 !== module.indexOf( 'et_pb_dfbm_blog' ) )
							{

								if ( -1 === title.indexOf( 'DFBM-Shop' ) )
								{

									settings.find( '#et_pb_custom_posttypes, #et_pb_include_post_categories, #et_pb_exclude_post_categories')
										.parent().parent().hide();

									settings.find( '#et_pb_show_category_filter').closest( 'div.et-pb-option' ).hide();

								}

								else settings.find( '#et_pb_show_order_options').closest( 'div.et-pb-option' ).hide();

							}
						}
					}, 100 );
				}
			})
			.on( 'mousedown', 'a.et-pb-modal-save.button', function()
			{

				var title    = $( '#titlewrap' ).children( '#title' ).val(),
					settings = $(this).parent().siblings( 'div.et_pb_module_settings' );

				if ( ( -1 !== title.indexOf( 'DFBM-' ) ) && ( -1 !== settings.data( 'module_type' ).indexOf( 'et_pb_dfbm_blog' ) ) )
				{

					var query,
						catID = function( $sel )
						{

							var arr = [];

							$sel.find( 'input[type="checkbox"]' ).each( function()
							{

								if ( $(this).prop('checked') )
									arr.push( $(this).val() );

							});

							return arr;

						},
						opt  = function( $sel )
						{

							return $sel.filter( function()
							{

								if ( $(this).prop( 'selected' ) )
									return true;

							}).val();
						};

					query =
					{

						posts_number   : settings.find( '#et_pb_posts_number' ).val(),
						offset_number  : settings.find( '#et_pb_offset_number' ).val(),
						posts_featured : settings.find( '#et_pb_posts_featured' ).val(),

					};

					if ( 'DFBM-Shop' == title )
					{

						query.custom_posttypes = 'product';

						query.include_product_categories = catID( settings.find( '#et_pb_include_product_categories' ) ).toString();
						query.exclude_product_categories = catID( settings.find( '#et_pb_exclude_product_categories' ) ).toString();

						query.include_product_tags = catID( settings.find( '#et_pb_include_product_tags' ) ).toString();
						query.exclude_product_tags = catID( settings.find( '#et_pb_exclude_product_tags' ) ).toString();

					}

					else
					{

						query.show_order_options    = opt( settings.find( '#et_pb_show_order_options' ).children( 'option' ) );
						query.order_options_order   = opt( settings.find( '#et_pb_order_options_order' ).children( 'option' ) );
						query.order_options_orderby = opt( settings.find( '#et_pb_order_options_orderby' ).children( 'option' ) );

					}

					$.ajax(
					{

						type     : 'post',
						dataType : 'json',
						url      : et_pb_options.ajaxurl,
						data:
						{

							action  : 'dfbm_set_archive_query',
							nonce   : dfbmPHP.nonce,
							postID  : dfbmPHP.id,
							query   : query,

						},
						success: function( $data )
						{

							// ...

						},

						error: function( r )
						{

							alert( dfbmPHP.noSave );

				        }
					});

				}

			});
	});
}(jQuery));
