(function($,w){
	$(function(){
	"use strict";

		var dfbmBlogthread = function( $opt )
		{

			this.init( $opt );

		};

		$.extend( dfbmBlogthread.prototype,
		{

			init : function( $opt )
			{

				this.vars();

				this.events();

				this.load();

			}, // end init

			vars : function()
			{

				this.state  = {};

				this.noURL  = false;

				this.posts  = false;

				this.headH  = this.header();

				this.width  = $( w ).width();

				this.navBar = $( '#dfbm-cat-nav' );

				this.active = $( '#dfbm-active-cat' );

				this.parent = $( '#dfbm-container' );

				this.feat   = this.parent.children( 'div.et_pb_featured_posts' );

				this.blog   = this.parent.children( 'div.filterable-blogposts' );

				this.grid   = this.parent.hasClass( 'grid' ) ? true : false;

				this.full   = this.parent.hasClass( 'full' ) ? true : false;

				this.cCol   = parseInt( dfbmPhp.cMax );

				this.cWid   = parseInt( dfbmPhp.cWidth );

				this.cDist  = parseInt( dfbmPhp.cDist );

				this.mWid   = this.cWid / this.cCol;

				this.lBase  = dfbmPhp.lBase;

				this.lStart = this.lBase;

				this.lCurr  = this.lBase;

				this.lAjax  = this.lBase;

				this.nonce  = dfbmPhp.nonce;

				this.url 	= dfbmPhp.url;

				this.body   = $( 'body' );

				this.shop   = this.body.hasClass( 'woocommerce' ) ? true : false;

				this.search = this.body.hasClass( 'search' ) ? true : false;

				this.author = this.body.hasClass( 'author' ) ? true : false;

				this.lb     = 'on' == dfbmPhp.ltBox ? true : false;

			}, // end vars

			load : function()
			{

				var img,
					$this = this,
					obj   = this.getHistoryObj();

				this.removeSession( 'dfbmLoaded' );

				if ( obj && null != obj.state.addMore && ! ( this.getSession( 'dfbmRedirect' ) && obj.curr != obj.base ) )
					this.setSession( 'dfbmAddMore', true );

				if ( this.getSession( 'dfbmRedirect' ) && ! this.getSession( 'dfbmAddMore' ) )
					this.blog.children( 'article' ).addClass( 'redirect' );

				if ( ! obj )
					this.posts = this.normalizePosts( this.blog.children( 'article' ) );

				img = this.imagesToLoad( this.posts ? this.posts : obj.state.content.posts );

				this.load.callback = function()
				{

					if ( $this.width > 767 )
					{

						if ( $this.feat )
							$this.featured();

						if ( $this.full )
							$this.fullwidth();

					}

					if ( $this.grid )
						$this.videoWidth();

					else $this.blog.trigger( 'blogs-loaded' );

					$this.catNavSubmenu();

					$this.catNavAddParent();

					$this.catNavPadding();

				}

				this.interval( img, this.load.callback );

			}, // end load

			masonry : function()
			{

				this.blog.mosaicflow(
				{

					columnClass  : 'article-col',
					itemSelector : 'article',
					minItemWidth : this.cWid / this.cCol,
					itemHeightCalculation: 'auto',
					minColumns   : 1,

				});
			}, // end masonry

			featured : function()
			{

				var $this = this,
					img   = this.feat.find( 'img' );

				this.featured.callback = function()
				{

					switch ( $this.feat.data( 'count' ) )
					{

					    case 2:

					    	var h,
					    		art = $this.feat.find( 'article' ),
					    		hgt = ( h = ( ( art.eq(0).height() + art.eq(1).height() ) / 2 ) < 350 ) ? 350 : h;

					        if ( art.hasClass( 'format-gallery' ) )
					        	art.find( 'div.et_pb_slide' ).css( 'height', hgt );

					        break;

					    case 3:

							var el,
								right = $this.feat.find( 'div.right' ),
								h     = right.height(),
								left  = right.siblings( 'div' ).children( 'article' );

							$this.getElements( left ).css({ 'height': h + 1, 'maxHeight': h + 1 });

							break;

					} // end switch
				} // end callback

				this.interval( img, this.featured.callback );

			}, // end featured

			fullwidth : function()
			{

				var innFull = this.blog.children( 'article' ),
					width   = innFull.width(),
					$this   = this;

				innFull.each( function()
				{

					var childs = $(this).children().children();

					if ( childs.length < 2 )
						childs.css( 'width', '100%' );

					else
					{

						var cont    = $(this).find( 'div.et_pb_content_container' ),
							min     = $this.width > 767 ? 400 : 350,
							cHeight = cont.css( 'minHeight', min ).outerHeight();

						if ( $(this).hasClass( 'format-gallery' ) )
							$this.initGallery( $(this).find( 'div.et_pb_slider' ) );

						if ( $this.width > 767 )
						{

							$(this).children().css( 'maxHeight', cHeight );

							$this.getElements(
								$(this) ).css(
								{

									'height'   : cHeight,
									'width'    : width * 0.6,
									'maxWidth' : width * 0.6,

								}
							);

						}

						else
						{

							$(this).children().removeAttr( 'style' );

							$this.getElements( $(this) ).removeAttr( 'style' );

						}
					}
				});
			}, // end fullwidth

			videoWidth : function( $resize )
			{

				if ( this.getSession( 'dfbmLoaded' ) )
					return;

				this.setSession( 'dfbmLoaded', true );

				var c,
					$this   = this,
					$resize = $resize || false,
					width, column, video;

				if ( ! $resize )
				{

					width   = this.blog.outerWidth(),
					column  = ( c = Math.floor( width / this.mWid ) ) > this.cCol ? this.cCol : ( this.width > 767 && c < 2 ? 2 : c ),
					video   = ( width / column ) - this.cDist;

				}

				else
				{

					video = this.blog.children( 'div.article-col' ).first().width();

				}

				if ( ! this.blog.children( 'div' ).hasClass( 'no-posts' ) )
				{

					this.blog.children( 'article.format-video' ).each( function()
					{

						var el,
							css  = { 'width' : video, height : video / ( 16 / 9 ) },
							cont = $(this).find( 'div.et_main_video_container' ),
							item = cont.children( 'div.wp-video' );

						if ( item.length > 0 )
						{

							item.css( css );

							item.find( 'video.wp-video-shortcode' ).css( css );

						}

						else cont.find( 'iframe' ).css( css );

					}).promise().done( function()
					{

						return $this.masonry();

					});
				}

				else this.blog.trigger( 'blogs-loaded' );

			}, // end videoWidth

			header : function()
			{

				var h,
					header = ! isNaN( h = parseInt( dfbmPhp.header ) )
							 ? h
							 : ( ! $( 'body' ).hasClass( 'et_vertical_nav' )
							     && $( '#main-header' ).length > 0
							     && this.width > 980
							     ? $( '#main-header' ).outerHeight()
							     : 0 );

				if ( h && this.width < 981 )
					header = parseInt( dfbmPhp.mobile );

				return header;

			}, // end header

			catNavSubmenu : function()
			{

				var width = ( $( w ).width() / 2 ),
					list  = this.navBar.find( 'ul.dfbm-sub-menu.first' );

				list.each( function()
				{

					if ( width < $(this).parent().offset().left )
					{

						if ( $(this).hasClass( 'left') )
							$(this).addClass( 'right' ).removeClass( 'left' );

					}

					else
					{

						if ( $(this).hasClass( 'right') )
							$(this).addClass( 'left' ).removeClass( 'right' );

					}

				});

			}, // end catNavSubmenu

			catNavAddParent : function()
			{

				var list = this.navBar.find( 'ul.dfbm-sub-menu.first' );

				list.parent().addClass( 'parent' );

			}, // end catNavAddParent

			catNavPadding : function()
			{

				if ( this.width < 768 && this.navBar.parent().hasClass( 'text' ) )
				{

					this.navBar.find( 'ul.dfbm-sub-menu.first' )
						.css( 'paddingTop', this.navBar.height() - 20 );

				}

			}, // end 1

			minHeight : function()
			{

				var header = this.width > 980 ? this.headH : 0;

				return $( w ).outerHeight()
				       - header
				       - this.navBar.parent().outerHeight()
				       - $( '#dfbm_blog_pagination' ).outerHeight()
				       - $('#main-footer').outerHeight()
				       + 15;

			}, // end minHeight

			getElements : function( $art )
			{

				if ( $art.hasClass( 'format-gallery' ) )
					return $art.find( 'div.et_pb_slider, div.et_pb_slides' );

				if ( $art.hasClass( 'format-video' ) )
					return $art.find( 'div.et_pb_video_overlay, div.et_main_video_container, div.wp-video, .wp-video-shortcode, div.fluid-width-video-wrapper, iframe' );

				if ( $art.hasClass( 'format-quote' ) )
					return $art.find( 'div.et_quote_content' );

				if ( $art.hasClass( 'format-audio' ) )
					return $art.find( 'div.et_audio_content' );

				if ( $art.hasClass( 'format-link' ) )
					return $art.find( 'div.et_link_content' );

				return $art.find( 'img' );

			}, // end getElements

			imagesToLoad : function( $arr )
			{

				var $i = 0, images = [], img;

				$( $arr ).each( function()
				{

					if ( $(this).hasClass( 'format-standard' ) || $(this).hasClass( 'type-product' ) )
						img = $(this).find( 'img' );

					if ( $(this).hasClass( 'format-video' ) )
					{
						var ovlay = $(this)
										.find( 'div.et_main_video_container' )
										.children( 'div.et_pb_video_overlay' ),
							url   = ovlay.css('background-image');

						if ( url )
						{

 							url = url.trim().replace( /(url\(|\)|'|")/gi, '' );

							img = $('<img />', { src: url, } );

 						}

 						else
 							img = $(this).find( 'img' );
					}

					if ( img && img.length > 0 )
					{

						images[$i] = img[0];

						$i++;

					}
				});

				return images;

			}, // end imagesToLoad

			interval : function( $img, callback )
			{

				var $this = this,
					int   = setInterval( function()
			    	{

					    if ( $img.length < 1 || $this.imagesLoaded( $img ) )
					    {

					    	clearInterval( int );

					    	callback();

					    }
			    	}, 100 );

			}, // end interval

			imagesLoaded : function( $img )
			{

				var $i = 0,
					$l = $img.length;

				for ( $i; $i < $l; $i++ )
				{

					if ( ! $img[$i].complete )
						return false;

				}

				return true;

			}, // end imagesLoaded

			initMediaType : function()
			{

				var $this = this,
					find  = 'article.ajax-video, article.ajax-gallery, article.ajax-audio',
					items = this.grid
							? $this.blog.children( 'div' ).children( find )
							: $this.blog.children( find );

				items.each( function()
				{

					if ( $(this).hasClass( 'ajax-video' ) )
						$this.initVideo( $(this).removeClass( 'ajax-video' ) );

					if ( $(this).hasClass( 'ajax-audio' ) )
						$this.initAudio( $(this).removeClass( 'ajax-audio' ) );

					if ( $(this).hasClass( 'ajax-gallery' ) )
						$this.initGallery( $(this).removeClass( 'ajax-gallery' ) );

				});


			}, // end initMediaType

			initGallery : function( $el )
			{

				w.et_pb_slider_init( $el.find( 'div.et_pb_slider' ) );

			}, // end initGallery

			initVideo : function( $el )
			{

				$el.find( 'video' ).mediaelementplayer();

			}, // end initVideo

			initAudio : function( $el )
			{

				$el.find( 'audio' ).mediaelementplayer();

			}, // end initAudio

			normalizePosts : function( $arr )
			{

				var arr = [];

				if ( $arr.length > 0 )
					$arr.each( function()
					{

						arr.push( $(this).prop( 'outerHTML' ) );

					});

				return arr;

			}, // end normalizePosts

			changeContent : function()
			{

				var img,
					$this = this;

				img = this.imagesToLoad( this.state.content.posts );

				this.changeContent.callback = function()
				{

					var callback, posts, min;

					if ( $this.grid )
					{

						min = $this.state.content.posts.length > 0 ? $this.minHeight() : 0;

						$this.blog.css( 'minHeight', min ).mosaicflow( 'empty' );


						for ( var key in $this.state.content.posts )
						{

							if ( isNaN( parseInt( key ) ) )
								continue;

							$this.blog.mosaicflow( 'add', $( $this.state.content.posts[key] ) );

						}

						callback = $this.videoWidth;

					}

					if ( $this.full )
					{

						posts = $( $this.state.content.posts.join( '' ) );

						$this.blog.css( 'minHeight', $this.minHeight() ).html( posts );

						callback = $this.fullwidth;

					}

					$this.removeMore( 0 );

					$this.adjustChange.call( $this, callback );

				}

				this.interval( img, this.changeContent.callback );

			}, // end changeContent

			addGrid : function()
			{

				// without animation
				var img,
					$i = 0,
					$this = this,
					maxWd = this.blog.children( 'div.article-col' ).first().width();

				if ( null != this.state.addMore )
				{

					if ( null == this.getSession( 'dfbmAddMore' ) )
						this.blog.css( 'minHeight', this.minHeight() )
							.removeClass( 'completed' ).mosaicflow( 'empty' )
								.parent().removeClass( 'completed' );

					this.state.added = true;

				}

				img = this.imagesToLoad( this.state.content.posts );

				this.addGrid.callback = function()
				{

					for ( var key in $this.state.content.posts )
					{

						var item = $( $this.state.content.posts[key] );

						if ( item.hasClass( 'format-video' ) )
						{

							var cont   = item.find( 'video.wp-video-shortcode, iframe' ),
								width  = cont.prop( 'width' ),
								height = cont.prop( 'height' ),
								ratio  = width / height;

							cont.css({ width : maxWd, height : maxWd / ratio });

						}

						$this.blog.mosaicflow( 'add', $( item ) );

						$i++;

					}

					$this.adjustAdded();

				}

				this.interval( img, this.addGrid.callback );

				//with a slightly animation
				// var maxWd   = this.blog.children( 'div.article-col' ).first().width(),
				// 	length  = Object.keys( $data.content.posts ).length,
				// 	iterate = function()
				// 	{

				// 		if ( $i < length || ! length )
				// 		{

				// 			var time = ! $i ? 0 : 200;

				// 			setTimeout( function()
				// 			{

				// 				if ( length )
				// 				{

				// 					var item = $( $data.content.posts[$i] );

				// 					if ( ! $i ) item.addClass( 'marker' );

				// 					if ( item.hasClass( 'format-video' ) )
				// 					{

				// 						var cont   = item.find( 'video.wp-video-shortcode, iframe' ),
				// 							width  = cont.prop( 'width' ),
				// 							height = cont.prop( 'height' ),
				// 							ratio  = width / height;

				// 						cont.css({ width : maxWd, height : maxWd / ratio });

				// 					}

				// 					$this.blog.mosaicflow( 'add', item );

				// 				}

				// 				if ( ! $i || ! length ) $this.marker( $data.query );

				// 				$i++;

				// 				if ( length ) iterate();

				// 			}, time );
				// 		}
				// 	};

				// if ( ! $i ) iterate();

			}, // end addGrid

			addFull : function()
			{

				var img,
					$this = this;

				if ( null != this.state.addMore )
				{

					if ( null == this.getSession( 'dfbmAddMore' ) )
						this.blog.css( 'minHeight', this.minHeight() )
							.removeClass( 'completed' ).empty()
								.parent().removeClass( 'completed' );

					this.state.added = true;

				}

				img = this.imagesToLoad( this.state.content.posts );

				this.addFull.callback = function()
				{

					var posts = $( $this.state.content.posts.join( '' ) )

					$this.blog.append( posts );

					$this.fullwidth();

					$this.adjustAdded();

				}

				this.interval( img, this.addFull.callback );


			}, // end addFull

			initAddLayout : function()
			{

				if ( this.grid )
					this.addGrid();

				else this.addFull();

			}, // end initAddLayout

			adjustChange : function( $callback )
			{

				var $this = this,
					push  = true;

				$callback.call( $this, false );

				this.sharedAdjustment();

				this.pagination();

				if ( this.getSession( 'dfbmRedirect' ) )
					push = false;

				this.changeUrl( this.lCurr, push );

			}, // end adjustChange

			adjustAdded : function()
			{

				this.sharedAdjustment();

				this.marker();

			}, // end adjustAdded

			sharedAdjustment : function()
			{

				this.initMediaType();

				this.query();

				if ( this.lb )
					this.unbind();

				if ( this.shop )
					this.adjustWoo();

				this.removeSession( 'dfbmLoaded' );

			}, // end sharedAdjustment

			adjustWoo : function()
			{

				var bcm = $( 'nav.woocommerce-breadcrumb' ),
					res = $( 'p.woocommerce-result-count' );

				if ( null != this.state.content.breadcrumb && bcm.length > 0 )
					bcm.replaceWith( this.state.content.breadcrumb );

				if ( null != this.state.content.results && res.length > 0 )
					res.replaceWith( this.state.content.results );

			},

			pagination : function()
			{

				var pagination = $( '#dfbm_blog_pagination' );

				if ( pagination.length > 0 )
					pagination.replaceWith( this.state.content.pagination );

				else this.parent.append( this.state.content.pagination );

			}, // end pagination

			removeMore : function( $time )
			{

				$( '#add-more-button' ).parent()
					.slideUp( $time, function()
					{

						$(this).remove()

					});

			}, // end removeMore

			query : function()
			{

				this.blog.data( 'config', this.state.query );

			}, // end query

			ajax : function( $option, $attr )
			{

				var $this  = this,
					$attr  = $attr || {},
					config = this.blog.data( 'config' ),
					atts   = this.blog.data( 'atts' ),
					data   = $.extend(
					{},
					$attr,
					{

						nonce  : this.nonce,
						action : 'dfbm_get_posts',
						option : $option,
						base   : $this.lAjax,
						query  : config,
						atts   : atts,

					}
				);

				$.ajax(
				{

					type     : 'post',
					dataType : 'json',
					url      : this.url,
					data 	 : data,

					success: function( $data )
					{

						$this.state = $data;

						$this.addContentCheck();

					},

					error: function( $data )
					{

						console.log( $data );

						location.reload();

			        }
				});
			}, // end ajax

			addContentCheck : function()
			{

				switch ( this.state.case )
				{

				    case 'category' :

				    case 'paged'    :

				    	this.changeContent();

				        break;

				    case 'more' :

						this.setMarker();

						this.initAddLayout();

				        break;
				}
			}, // end addContentCheck

			animate : function( $sel, $case, $data, $ajax )
			{

				var h, t,
					$this  = this,
					winTop = $( w ).scrollTop(),
					elTop  = $sel.offset().top - $this.headH - this.cDist - ( 'marker' == $case ? 0 : 1 ),
					time   = ( 'marker' == $case && null != this.state.addMore && this.state.added )
							   ? 0 : ( t = Math.abs( winTop - elTop ) * 0.2 ) < 500 ? 500 : ( t > 2500 ? 2500 : t );

				$( 'html, body' ).animate(
				{

					scrollTop: elTop

				}, time, 'swing' ).promise().then( function()
				{

					if ( $data )
					{

						if ( $case && $ajax )
						{

							$this.setScrollPos( $( w ).scrollTop() );

							return $this.ajax( $case, $data );

						}

						if ( 'marker' == $case || null != $this.state.addMore )
						{

							return $this.routeMarker( $sel );

						}

						$this.addContentCheck( $data );

					}

					else w.location.reload()

			    });
			}, // end animate

			animateTarget : function( $case, $data, $ajax )
			{

				if ( 'category' == $case && this.active )
					this.changeActive( $data );

				var sel = this.navBar.length > 0 ? this.navBar : this.blog;

				this.animate( sel, $case, $data, $ajax );

			}, // end animateTarget

			changeActive : function( $data )
			{

				this.active.fadeOut( 300, function()
				{

					$(this).text( $data.name ).fadeIn( 300 );

				});

				this.navBar
					.find( 'a[data-cat-id="' + $data.target + '"]').addClass( 'active' )
						.parent().siblings().find( 'a' ).removeClass( 'active' );

			}, // end changeActive

			routeMarker : function( $sel )
			{

				if ( null != this.state.addMore )
				{

					if ( ! this.state.added )
					{

						return this.initAddLayout();

					}

					this.removeSession( 'dfbmAddMore' );

					if ( ! this.state.content.pagination )
						this.removeMore( 0 );

					else
					{

						if ( this.state.content.pagination && $( '#add-more-section' ).length < 1 )
							this.parent.append( $( this.state.content.pagination ) );

					}

					this.showContent();

					this.state = {};

				}

				if ( $sel )
					$sel.removeClass( 'marker' );

			}, // end routeMarker

			marker : function()
			{

				var $this  = this,
					button = true,
					marker = this.blog.find( 'article.marker' );

				if ( marker.length < 1 && null != this.state.scroll )
				{

					this.blog.trigger( 'adjust-scroll-top' );

					this.routeMarker();

				}

				if ( null != this.state.query && this.state.query.paged === this.state.query.maximum_pages )
				{

					button = false;

					this.removeMore( 300 );

				}

				if ( marker.length > 0 )
				{

					this.animate( marker, 'marker', true, false );

				}

				$( '#add-more-button' ).removeClass( 'active' );

				this.changeState( button );

			}, // end marker

			setMarker : function( $arr, $key )
			{

				var key = $key || 0,
					arr = $arr || false,
					rep = function( $item )
					{

						return $item.replace( 'et_pb_post', 'et_pb_post marker' );

					};

				if ( ! arr )
					return this.state.content.posts[key] = rep( this.state.content.posts[key] );

				return arr[$key] = rep( arr[$key] );

			}, // setMarker

			deleteMarker : function( $obj )
			{

				var i = $obj.state.addMore.index,
					l = $obj.state.addMore.posts.length;

				$obj.state.addMore.posts[l-i] = $obj.state.addMore.posts[l-i].replace( 'et_pb_post marker', 'et_pb_post' );

				return $obj;

			}, // end deleteMarker

			setScrollPos : function( $pos, $link )
			{

				var link = $link || false,
					obj  = this.getHistoryObj();

				if ( null != obj.state.addMore && null != obj.state.addMore.index )
				{

					if ( obj.state.addMore.index > 0 )
						obj = this.deleteMarker( obj );

					obj.state.addMore.index = 0;

				}

				obj.state.scroll = $pos ? $pos : 0;

				this.changeState( false, obj, false, $link );

			}, // end setScrollPos

			initialState : function()
			{

				var p, pag = ( p = $( '#dfbm_blog_pagination' ) ).length > 0 ? p : $( '#add-more-section' );

				if ( this.active )
					this.state.case   = 'category';

				else this.state.case  = 'paged';

				if ( this.navBar )
				{

					var item = this.navBar.find( '.cat-selector.active');

					this.state.name   = item.data( 'cat-name' );

					this.state.target = item.data( 'cat-id' );

				}

				this.state.query = this.blog.data( 'config' );

				this.state.content = {};

				this.state.content.posts = this.posts;

				if ( pag.length > 0 )
					this.state.content.pagination = pag.prop( 'outerHTML' );

				if ( this.shop )
				{

					var bcm = $( 'nav.woocommerce-breadcrumb' ),
						res = $( 'p.woocommerce-result-count' );

					if ( bcm.length > 0 )
						this.state.content.breadcrumb = bcm.prop( 'outerHTML' );

					if ( res.length > 0 )
						this.state.content.results = res.prop( 'outerHTML' );

				}

			}, // end initialState

			changeUrl : function( $link, $push )
			{

				if ( this.noURL )
				{

					var obj = this.getHistoryObj();

					this.noURL = false;

					if ( obj && null != obj.curr && obj.curr != w.location.href )
						return this.changeState( false, obj, false );

					return;

				}

				if ( this.getSession( 'dfbmRedirect' ) )
				{

					this.blog.trigger( 'adjust-scroll-top' );

					this.showContent();

					return this.changeState( false, false, true );

				}

				var obj  = {},
					link = $link || false,
					push = $push || false;

				if ( ! $link && ! $push )
				{

					this.initialState();

				}

				obj.base   = this.lStart;

				obj.curr   = link ? link : w.location.href;

				obj.state  = ! $.isEmptyObject( this.state ) > 0 ? this.state : false;

				this.state = {};

				if ( this.shop )
					obj.shop = true;

				if ( this.search )
					obj.search = this.getLinkParameter( location.href );

				if ( push )
					return w.history.pushState( JSON.stringify( obj ), '', link );

				this.changeState( false, obj );

			}, // end changeUrl

			changeState : function( $but, $obj, $redirect, $assign )
			{

				if ( this.noURL )
					return this.noURL = false;

				var link,
					but  = $but || false,
					obj  = $obj || false;

				$redirect = $redirect || this.getSession( 'dfbmRedirect' ) ? true : false;

				if ( ! $redirect && ! obj && this.state )
					obj = this.buildAddMoreState( but );

				this.state = {};

				if ( obj || $redirect )
				{

					obj = obj ? obj : this.getHistoryObj();

					if ( obj && null != obj.curr )
						link = obj.curr;

					if ( this.getSession( 'dfbmRedirect' ) )
					{

						this.removeSession( 'dfbmRedirect' );

						$redirect = false;

					}

					w.history.replaceState( JSON.stringify( obj ), '', link ? link : location.href );

					if ( $redirect )
					{

						this.checkState();

					}

					if ( $assign )
					{

						w.location.assign( $assign );

					}
				}
			}, // end changeState

			checkState : function( $noMerge )
			{

				var obj = this.getHistoryObj();

				if ( obj )
				{

					if ( null == obj.shop && ( obj.base != this.lStart || false === obj.state ) || null != obj.shop && false === obj.state )
					{

						return null != this.lStart ? this.animateTarget( false, false, false ) : false;

					}

					this.state = obj.state;

					if ( null != this.state.addMore )
					{

						if ( $noMerge && ! this.getSession( 'dfbmRedirect' ) )
							this.state.content.posts = this.state.addMore.posts;

						else this.mergeStatePosts();

					}

					this.historyStep();

				}

				else
				{

					this.removeSession( 'dfbmAddMore' );

					w.location.reload();

				}

			}, // end checkState

			historyStep : function()
			{

				if ( ! this.getSession( 'dfbmRedirect' ) )
					this.noURL = true;

				if ( null != this.state.addMore )
					this.state.added = false;

				if ( this.getSession( 'dfbmAddMore' ) )
					return this.initAddLayout();

				this.animateTarget( this.state.case, this.state, false );

			}, // end historyStep

			getHistoryObj : function()
			{

				var h;

				return ! $.isEmptyObject( ( h = w.history.state ) ) ? JSON.parse( h ) : false;

			}, // end getHistoryObj

			buildAddMoreState : function( $but )
			{

				var $this = this,
					obj   = this.getHistoryObj();

				if ( null != obj.state.addMore && null != obj.state.addMore.index && obj.state.addMore.index > 0 )
				{

					obj = this.deleteMarker( obj );

				}

				else
				{

					if ( null == obj.state.addMore )
					{

						obj.state.addMore = {};

						obj.state.addMore.posts = [];

					}
				}

				if ( null != obj.state.scroll )
					delete obj.state.scroll;

				if ( ! $but )
					obj.state.content.pagination = '';

				obj.state.query = this.state.query;

				obj.state.addMore.index = this.state.content.posts.length;

				obj.state.addMore.posts = $.merge( obj.state.addMore.posts, $this.state.content.posts );

				return obj;

			},  // end buildAddMoreState

			mergeStatePosts : function()
			{

				this.state.content.posts = $.merge( this.state.content.posts, this.state.addMore.posts );

			}, // end mergeStatePosts

			getLinkParameter : function( $link )
			{

				return ( -1 !== $link.indexOf( '?' ) ) ? $link.split( '/' ).filter( function( i ){ return ( -1 !== i.indexOf( '?' ) ) } )[0] : '';

			}, // end getLinkParameter

			setSession : function( $key, $value )
			{

				w.sessionStorage.setItem( $key, $value );

			},

			getSession : function( $key )
			{

				return w.sessionStorage.getItem( $key );

			},

			removeSession : function( $key )
			{

				w.sessionStorage.removeItem( $key );

			},

			unbind : function()
			{

				$( '.et_pb_post .et_pb_video_overlay' ).off();

			}, // end unbind

			showContent : function()
			{

				$( 'html.redirected' ).removeClass( 'redirected' );

				this.blog.addClass( 'completed' ).parent().addClass( 'completed' );

			}, // end showContent

			events : function()
			{

				var $this = this;

				this.blog
					.one( 'adjust-scroll-top', function()
					{

						var obj = $this.getHistoryObj();

						if ( obj && null != obj.state && null != obj.state.scroll )
						{

							$( w ).scrollTop( obj.state.scroll );

							$( 'html.redirected' ).removeClass( 'redirected' );

						}

					})
					.one( 'mosaicflow-filled blogs-loaded', function( e )
					{

						if ( ! $this.getSession( 'dfbmAddMore' ) && ! sessionStorage.getItem( 'dfbmRedirect' ) )
						{

							if ( 'blogs-loaded' == e.type )
								$this.showContent();

							if ( $this.lb )
								$this.unbind();

							$this.removeSession( 'dfbmLoaded' );

							if ( ! $this.getHistoryObj() )
								$this.changeUrl( false, false );

						}

						else
						{

							if ( $this.grid && $this.getSession( 'dfbmAddMore' ) )
								$this.blog.find( 'article' ).css(
								{

									position   : 'static',
									visibility : 'visible',
									display    : 'block',

								});

							$this.checkState( true );

						}

					});

				this.parent
					.on( 'mouseenter', '.content-overlay article.hover', function()
					{

						$(this).find( 'div.header-before' ).slideDown( 300 );

					})
					.on( 'mouseleave', 'div.content-overlay article.hover', function()
					{

						$(this).find( 'div.header-before' ).finish().slideUp( 300 );

					})
					.on( 'click', 'div.et_pb_content_container.click', function()
					{

						$(this).addClass( 'clicked hover' ).removeClass( 'click' )
							.find( 'div.header-before' ).slideDown( 300 );

					})
					.on( 'click', 'div.et_pb_content_container.clicked', function()
					{

						$(this).addClass( 'click' ).removeClass( 'clicked hover' )
							.find( 'div.header-before' ).finish().slideUp( 300 );

					})
					.on( 'click', '.entry-title a, a.et_pb_button.read-more, a.no-lb', function( e )
					{

						e.stopPropagation();

						e.preventDefault();

						$this.setScrollPos( $( w ).scrollTop(), $(this).prop( 'href' ) );

					})
					.on( 'click', 'div.clicked a.add_to_cart_button', function( e )
					{

						e.preventDefault();

						$(this).trigger( 'click' );

					})
					.on( 'click', 'div.clicked a.wc-forward', function( e )
					{

						e.stopPropagation();

					})
					.on( 'click', 'a.cat-selector', function( e )
					{

						if ( ( $this.search && ! $this.shop ) || $this.author )
							return;

						e.preventDefault();

						if ( $this.width < 768 && $(this).parent().hasClass( 'parent' ) && ! $(this).parent().hasClass( 'opened' ) )
							return $(this).parent().addClass( 'opened' );

						var el,
							not,
							param,
							category = {};

						param = $this.getLinkParameter( location.href );

						if ( -1 !== param.indexOf( '&s=' ) )
						{

							param = param.split( '&' ).filter( function( i )
							{

								return ( -1 === i.indexOf( 's=' ) );

							}).join( '&' );

						}

						$this.lCurr = $this.lBase = $(this).prop( 'href' ) + param;

						$this.lAjax = $this.lBase.split( '?' )[0] + param;

						category.target = $(this).data( 'cat-id' );

						category.name   = $(this).data( 'cat-name' );

						if ( ( not = $this.blog.data( 'cat-not-id' ) ) )
							category.targetNot = not;

						$this.navBar.children( 'li.parent' ).removeClass( 'opened' );

						$this.animateTarget( 'category', category, true );

					})
					.on( 'click', 'a.page-numbers', function( e )
					{

						e.preventDefault();

						var targ,
							param,
							page    = {},
							link    = $(this).prop( 'href' );

						$this.lCurr = link;

						param = $this.getLinkParameter( link );

						if ( param )
							link = link.replace( param, '' );

						$this.lAjax = $this.lBase + param;

						targ = ( link.split( '/' )
								   .filter( function( i ){ return i !== '' } ) )
									   .slice( -1 );

						page.target = isNaN( ( targ = parseInt( targ ) ) ) ? 1 : targ;

						$this.animateTarget( 'paged', page, true );

					})
					.on( 'click', '#add-more-button', function( e )
					{

						if ( $(this).hasClass( 'active' ) )
							return;

						e.preventDefault();

						$(this).addClass( 'active' );

						$this.ajax( 'more' );

					})
					.on( 'click', 'a.et_pb_video_play, div.et_pb_video_overlay', function( e )
					{

						e.preventDefault();

						e.stopImmediatePropagation();

						var play = $(this).hasClass( 'et_pb_video_overlay' )
								   ? $(this) : $(this).closest( 'div.et_pb_video_overlay' );

						w.et_pb_play_overlayed_video( play );


					}); // end this.parent

				this.navBar.on( 'mouseenter', 'li.parent', function()
				{

					if ( $this.width < 768 )
					{

						if ( $(this).hasClass( 'opened' ) )
						{

							$(this).removeClass( 'opened' )
								.children( 'ul.first' ).fadeOut( 400 );

						}

						else
						{

							$(this).addClass( 'opened' )
								.children( 'ul.first' ).fadeIn( 400 );

						}
					}
				});

				$( document )
					.on( 'click', 'a.dfbm-lb-link, a.dfbm-lb-read-more', function( e )
					{

						e.preventDefault();

						var pos = $this.getSession( 'dfbmScrollPos' );

						$this.removeSession( 'dfbmScrollPos' );

						$this.setScrollPos( pos, $(this).prop( 'href' ) );

					});

				$( w )
					.on( 'resize', function()
					{

						$this.catNavSubmenu();

						$this.width = $( w ).width();

						$this.catNavPadding();

						$this.headH = $this.header();

						if ( $this.width > 767 )
							$this.featured();

						if ( $this.grid )
							$this.videoWidth( true );

						else $this.fullwidth();

					})
					.on( 'popstate', function()
					{

						if ( $this.getSession( 'dfbmRedirect' ) || $this.getSession( 'dfbmAddMore' ) )
						{

							var noRedirect = setInterval( function()
					    	{

							    if ( ! $this.getSession( 'dfbmRedirect' ) && ! $this.getSession( 'dfbmAddMore' ) )
							    {

							    	clearInterval( noRedirect );

							    	$this.checkState();

							    }
					    	}, 100 );
						}

						else $this.checkState();

					});

			}, // end events
		}); // end dfbmBlogthread

		new dfbmBlogthread({});

	});
}(jQuery,window));
