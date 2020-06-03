(function($,w){
	$(function(){
	"use strict";

		var dfbmLightbox = function( $opt )
		{

			this.init( $opt );

		};

		$.extend( dfbmLightbox.prototype,
		{

			init : function( $opt )
			{

				this.vars( $opt );

				this.events();

				this.load();

			}, // end init

			vars : function( $opt )
			{

				this.opt = $.extend(
				{

					header   : '',
					content  : '',
					more     : '',
					close    : 'Close',
					addAfter : 'body',
					selector : '',
					width    : '80%',
					data     : {},

				}, $opt );

				this.top;

				this.lightbox = this.structure();

				this.imgData  = this.opt.data;

				this.addAfter = $( this.opt.addAfter );

				this.selector = this.opt.selector ? ', ' + this.opt.selector : '';

			}, // end vars

			structure : function()
			{

				return $(
				[

					'<div id="dfbm-lightbox">',
						'<div id="dfbm-lb-pop" class="dfbm-lb-pop dfbm-closed"></div>',
						'<div id="dfbm-lb-wrap" class="dfbm-lb-wrap">',
							'<div class="dfbm-lb-container">',
								'<div class="dfbm-lb-slider" style="width:' + this.opt.width + ';">',
									'<div id="dfbm-lb-holder" class="dfbm-lb-holder dfbm-closed">',
										'<div id="dfbm-lb-outer" class="dfbm-lb-outer">',
											'<div class="dfbm-lb-header-section">',
												( this.opt.header ? '<h3 class="dfbm-lb-header">' + this.opt.header + '</h3>' : '' ),
												'<a href="#" id="dfbm-lb-close" class="dfbm-lb-close">' + this.opt.close + '</a>',
											'</div>',
											this.slide( this.opt.content ),
										'</div>',
									'</div>',
								'</div>',
							'</div>',
						'</div>',
					'</div>'

				].join( '\n' ) );

			}, // end structure

			slide : function( $opt, $hidden )
			{

				var slide   = [],
					$hidden = $hidden || false,
					content = ( null != $opt.video ) ? $opt.video
							  : this.image( $opt )
								+ '<div class="dfbm-lb-switch prev" data-direction="prev"><span></span></div>'
								+ '<div class="dfbm-lb-switch next" data-direction="next"><span></span></div>';

				return slide =
				[

					'<div class="dfbm-lb-content-section' + ( $hidden ? ' hidden' : '' ) + '">',
						'<div class="dfbm-lb-content">',
							content,
						'</div>',
						'<div class="dfbm-lb-footer-section">',
							'<a class="dfbm-lb-link" href="' + $opt.href + '">',
								'<div class="dfbm-lb-title">' + $opt.title + '</div>',
							'</a>',
							'<a class="dfbm-lb-read-more" href="' + $opt.href + '">',
								'<div class="dfbm-lb-title">' + this.opt.more + '</div>',
							'</a>',
						'</div>',
					'</div>',

				].join( '\n' );

			}, // end slide

			image : function( $item )
			{

				return '<img src="' + $item.src + '" alt="' + $item.title + '">';

			}, // end image

			addSlide : function( $direction )
			{

				var $this = this,
					cont  = $( '#dfbm-lb-outer' );

				cont.css( 'minHeight', cont.outerHeight() ).children( 'div' ).addClass( 'hidden' );

				setTimeout(function()
				{

					cont.children( 'div.dfbm-lb-content-section' ).remove();

					cont.append( $this.slide( $this.imgData.images[$this.imgData.show], true ) );

					cont.find( 'img' ).load( function()
					{

						cont.css( 'minHeight', '100%' ).children( 'div' ).removeClass( 'hidden' );

					});

				}, 200 );

			}, // end addSlide

			load : function()
			{

				this.top = $( w ).scrollTop();

				w.sessionStorage.setItem( 'dfbmScrollPos', this.top );

				this.lightbox.insertAfter( this.addAfter.addClass( 'lightbox' ).css( 'top', - this.top ) );

				if ( null != this.opt.content.video ) this.videoRatio();

				this.animate( 'in' );

			}, // end load

			animate : function( $way )
			{

				var lbPop  = $( '#dfbm-lb-pop' ),
					lbHold = $( '#dfbm-lb-holder' );

				switch ( $way )
				{

					case 'in' :

						setTimeout( function(){ lbPop.addClass( 'dfbm-opened' ).removeClass( 'dfbm-closed' ); }, 0 );
						setTimeout( function(){ lbHold.addClass( 'dfbm-opened' ).removeClass( 'dfbm-closed' ); }, 300 );

						break;

					case 'out' :

						lbHold.addClass( 'dfbm-closed' ).removeClass( 'dfbm-opened' );
						setTimeout( function()
						{

							lbPop.addClass( 'dfbm-closed' ).removeClass( 'dfbm-opened' );

							w.sessionStorage.removeItem( 'dfbmScrollPos' );

						}, 300 );

						break;
				}
			}, // end animate

			videoRatio : function()
			{

				var video  = $( '#dfbm-lightbox' ).find( 'video.wp-video-shortcode, iframe' ),
					ratio  = video.outerWidth() / video.outerHeight(),
					width  = $( w ).width() * 0.9,
					height = $( w ).height() * 0.9,
					maxH   = height * ratio > width ? width / ratio : height,
					maxW   = maxH * ratio,
					attr   = { height: maxH, width: maxW },
					cont   = video.closest( 'div.wp-video' ).css( attr ),
					holder = cont.closest( 'div.dfbm-lb-slider' ).css( 'width', maxW );

				( null != w.wp.mediaelement && ! this.opt.content.elem )
				? video.css( attr ).mediaelementplayer()
				: video.css( attr );

			}, // end videoRatio

			position : function( $direction )
			{

				var way,
					num = this.imgData.show,
					len = Object.keys( this.imgData.images ).length;

				way = ( ~~( 'next' == $direction ) || -1 );

				num += way;

				this.imgData.show = ( num < 0 ) ? len - 1 : num % len;

				return way;

			}, // end position

			events : function()
			{

				var $this = this;

				$( document ).on( 'click', '#dfbm-lb-close', function( e )
				{

					e.preventDefault();

					$this.addAfter.removeClass( 'lightbox' ).scrollTop( $this.top );

					$( w ).scrollTop( $this.top );

					$this.animate( 'out' );

					setTimeout( function()
					{

						$( document ).off( 'click', 'div.dfbm-lb-switch' );
						$( '#dfbm-lightbox' ).detach();

					}, 600 );

					return false;

				});

				$( document ).on( 'click', 'div.dfbm-lb-switch', function( e )
				{

					var index = $this.position( $(this).data( 'direction' ) );

					$this.addSlide( index );

				});
			}, // end events
		}); // end dfbmLightbox

		var dfbmLbInit = function( $opt )
		{

			this.init( $opt );

		};

		$.extend( dfbmLbInit.prototype,
		{

			init : function( $opt )
			{

				this.vars();

				this.events();

			}, // end init

			vars : function()
			{

				this.url 	= dfbmPhp.url;

				this.nonce  = dfbmPhp.nonce;

				this.cdn    = dfbmPhpLB.cdn;

				this.parent = $( '#dfbm-container' );

				this.blog   = this.parent.children( 'div.filterable-blogposts' );

				this.grid   = this.parent.hasClass( 'grid' ) ? true : false;

			}, // end vars

			lightbox : function( $obj )
			{

				var item = ( null != $obj.video ) ? $obj : $obj.images[ $obj.show ],
					lBox = new dfbmLightbox(
					{

						selector : '',
						data     : $obj,
						content  : item,
						addAfter : 'body',
						header   : dfbmPhpLB.header,
						close    : dfbmPhpLB.close,
						width    : dfbmPhpLB.width + '%',
						more     : dfbmPhpLB.more,

					});
			}, // end lightbox

			getdirChildImg : function( $sel, $that )
			{

				var images = {}, obj = {};

				$sel.each( function( i )
				{

					var img, href, src, active;

					if ( ( img = $(this).children( 'img' ) ).length > 0 )
					{

						href   = $(this).prop( 'href' );
						active = $that == href ? true : false;

						images[i] =
						{

							src    : img.prop( 'src' ).replace( /[_-]\d+x\d+(?=\.[a-zA-Z]{3,4}$)/i, '' ),
							title  : $(this).data( 'title' ),
							href   : href,

						};

						if ( active )
							obj.show = i;

					}
				});

				obj.images = images;

				return obj;

			}, // end getdirChildImg

			getImages : function( $that )
			{

				var obj = {}, index = [], $i, divs, iterator, feat, full, length;

				feat = this.getdirChildImg( $( '#et_pb_featured_posts').find( 'a.entry-featured-image-url' ), $that );

				obj.images = feat.images;

				if ( null != feat.show )
					obj.show = feat.show;

				if ( ! this.grid )
				{

					full   = this.getdirChildImg( this.blog.find( 'a.entry-featured-image-url' ), $that );

					length = Object.keys( obj.images ).length;

					for ( $i = 0; $i < Object.keys( full.images ).length; $i++ )
					{

						obj.images[ length + $i ] = full.images[$i];

					}

					if ( null != full.show )
						obj.show = full.show + length;

				}

				else
				{

					divs = this.blog.children( 'div' );

					divs.each( function( i )
					{

						index[i] = $(this).find( 'article' ).length;

					});

					iterator = Math.max.apply( Math, index );

					for ( $i = 0; $i < iterator; $i++ )
					{

						for ( var $j = 0; $j < divs.length; $j++ )
						{

							var art = $( divs[$j] ).find( 'article' ).eq($i), item = {}, img;

							if ( ( img = art.find( 'img' ) ).length > 0 )
							{

								var link   = art.find( 'a.entry-featured-image-url' ),
									href   = link.prop( 'href' ),
									active = $that == href ? 1 : 0;

								length = Object.keys( obj.images ).length;

								item =
								{

									src    : img.prop( 'src' ).replace( /[_-]\d+x\d+(?=\.[a-zA-Z]{3,4}$)/i, '' ),
									title  : link.data( 'title' ),
									href   : href,

								};

								obj.images[length] = item;

								if ( active ) obj.show = length;

							}
						}
					}
				}

				this.lightbox( obj );

			}, // end getImages

			getGallery : function( $article )
			{

				var obj    = {}, url,
					slides = $article.find( 'div.et_pb_slide' ),
					header = $article.find( '.entry-title a' ),
					href   = header.prop( 'href' ),
					title  = header.text();

				obj.images = {};

				slides.each( function( i )
				{

					url = $(this).css('background-image').trim();
					url = url.replace(/(url\(|\)|'|")/gi, '');

					obj.images[i] =
					{

						src    : url,
						href   : href,
						title  : title,

					}

				});

				obj.show = 0;

				this.lightbox( obj );

			}, // end getGallery

			getVideo : function( $article )
			{

				var obj        = {},
					overlay    = $article.find( 'div.et_pb_video_overlay' ).addClass( 'lightbox' ),
					header     = $article.find( '.entry-title a' ),
					element    = $article.find( 'video.wp-video-shortcode a, iframe' );
					obj.title  = header.text();
					obj.href   = header.prop( 'href' );
					obj.elem   = ~~element.is( 'iframe' );
					obj.link   = obj.elem ? element.prop( 'src' ) : element.prop( 'href' );

					if ( obj.elem )
					{

						var prop  = element.prop( 'src' ) + "&autoplay=1";

						obj.video = element.clone( true )
										.removeAttr( 'width height style' )
											.prop( 'src', prop )
												.prop( 'outerHTML' );

						return this.lightbox( obj );

					}

					this.ajax( obj );

			}, // end getVideo

			ajax : function( $obj )
			{

				var $this = this,
					data  =
					{
						nonce   : this.nonce,
						action  : 'dfbm_get_video',
						vidLink : $obj.link,
						cdn     : this.cdn,
					};

				$.ajax(
				{

					type     : 'post',
					dataType : 'json',
					url      : this.url,
					data 	 : data,

					success: function( data )
					{

						$obj.video = data;

						$this.lightbox( $obj );

					},

					error: function( data )
					{

						location.reload();

			        }
				});
			}, // end ajax

			events : function()
			{

				var $this = this;

				this.parent
					.on( 'mousedown', 'a.entry-featured-image-url', function( e )
					{

						e.preventDefault();

						e.stopPropagation();

						$this.getImages( $(this).prop( 'href' ) );

					})
					.on( 'mousedown', 'div.et_pb_slider', function( e )
					{

						e.preventDefault();

						e.stopPropagation();

						$this.getGallery( $(this).closest( 'div.article-inner' ) );

					})
					.on( 'mousedown', 'div.et_main_video_container', function( e )
					{

						e.preventDefault();

						e.stopPropagation();

						$(this).find( '.et_pb_video_overlay' ).off();

						$this.getVideo( $(this).parent( 'div.article-inner' ) );

					});
			}, // end events
		}); // end dfbmLbInit

		new dfbmLbInit({});

	});
}(jQuery,window));
