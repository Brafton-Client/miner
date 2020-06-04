(function($){$(function(){

	class dfbmUpdater
	{

		setProperties()
		{

			this.red = '#fff0f0';
			this.green = '#f1fff0';
			this.localize = dfbmPHP;

		} // end setProperties

	    constructor()
	    {

	        this.setProperties();

	        this.bindEvents();

	    } // end constructor

		resp( color, message )
		{

			return this.field
						.css( 'background', color )
						.attr( 'value', '' )
						.attr( 'placeholder', message );

		}

		ajax( action, key, self, that = this )
		{

			let data =
			{

				nonce   : self.localize.nonce,
				action  : action,
				license : key,

			}

			data[action] = true;

			$.ajax(
			{

				data 	 : data,
				type     : 'post',
				dataType : 'json',
				url      : self.localize.url,

				success: function( data )
				{

					if ( self.localize.prefix + '_activate' == action )
					{

						if ( 'success' in data )
						{

							self.resp.apply( that, [ self.green, data.success ] );

							setTimeout( () =>
							{

								$(that).closest( 'div.update-message' ).slideUp( 800, function()
								{

									$(this).closest( 'tr' ).remove();

									location.reload();

								});
							}, 3000 );
						}

						else
							self.resp.apply( that, [ self.red, data.failed ] );

					}

					else
					{

						if ( 'delete' in data )
						{

							alert( data.delete );

							location.reload();

						}

						else
							alert( data.failed );

					}
				},

				error: function( data )
				{

					alert( self.localize.error );

					location.reload();

		        }
			});
		} // end ajax

	    bindEvents( self = this )
	    {

			$( '#' + self.localize.prefix + '-license-submit' ).on( 'click', function( e )
			{

				e.preventDefault();
				e.stopImmediatePropagation();

				this.field = $( '#' + self.localize.prefix + '-license-field' );
				this.val   = this.field.val();

				if ( this.val && 32 == this.val.length )
				{

					self.ajax.apply( this, [ self.localize.prefix + '_activate', this.val, self ] );

				}

				else
					self.resp.apply( this, [ self.red, self.localize.valid, self ] );

			});

			$( '#' + self.localize.prefix + '-remove-license' ).on( 'click', function( e )
			{

				e.preventDefault();

				self.ajax.apply( this, [ self.localize.prefix + '_deactivate', self.localize.key, self ] );

			});

	    } // end bindEvents
	} // end class dfbmUpdater

	new dfbmUpdater;

});}(jQuery));
