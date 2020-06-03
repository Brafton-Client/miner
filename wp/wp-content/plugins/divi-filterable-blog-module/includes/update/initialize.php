<?php
/**
 * Divi - Filterable Blog Module - Update Initialize
 *
 * @since	1.0.0
 */
if ( ! class_exists( 'dfbmUpdateInitialize' ) )
{

	class dfbmUpdateInitialize
	{

		/**
		 * Define properties
		 *
		 * @since	1.0.10
		 */
		private $args;

		private $licenseKey;

		/**
		 * Constructor
		 *
		 * @since	1.0.0
		 */
		public function __construct()
		{

			/**
			 * Initialize
			 *
			 * @since 1.0.10
			 */
			if ( is_admin() )
				$this->initialize();

		} // end constructor

		/**
		 * Initialize
		 *
		 * @since 1.0.10
		 */
		public function initialize()
		{

			$this->args = DFBM()->updater();

			$this->licenseKey = ( new dfbmModelGet )->option( DFBM()->prefix() . '_license_key' );

			if ( $this->licenseKey ) :

				$this->args->args['license'] = $this->licenseKey;

				add_action( 'wp_ajax_' . DFBM()->prefix() . '_deactivate', [ $this, 'deactivateLicense' ] );

			else :

				add_action( 'wp_ajax_' . DFBM()->prefix() . '_activate', [ $this, 'activateLicense' ] );

			endif;

			add_action( 'admin_init', [ $this, 'updater' ], 0 );

			add_action( 'current_screen', function( $screen )
			{

				if ( 'plugins' == $screen->base ) :

					$slug = DFBM()->prefix() . '-plugins';

					if ( ! $this->licenseKey )
						add_action( 'after_plugin_row', [ $this, 'licenseField' ] );


					else
						add_filter( 'plugin_action_links_' . plugin_basename( DFBM()->file() ), [ $this, 'removeLink' ] );

					( new dfbmControllerEnqueue )->enqueueScript( $slug, [ 'jquery' ] );

					wp_localize_script( $slug, DFBM()->prefix() . 'PHP', $this->localize() );

				endif;

			}); // end add_action
		} // end initialize

		/**
		 * Data for Localization
		 *
		 * @since 1.0.10
		 */
		public function localize()
		{

			return
			[

				'prefix' => DFBM()->prefix(),
				'error'  => $this->getMessage()->error,
				'url'    => admin_url( 'admin-ajax.php' ),
				'key'    => $this->licenseKey ? $this->licenseKey : '',
				'nonce'  => wp_create_nonce( DFBM()->prefix() . "-nonce-value" ) ,
				'valid'  => esc_html__( "Insert a valid key.", DFBM()->domain() ),

			];

		} // end localize

		/**
		 * Instantiate the updater class
		 *
		 * @since 1.0.10
		 */
		public function updater()
		{

			if ( ! class_exists( 'EDD_SL_Plugin_Updater' ) )
				include( dirname( __FILE__ ) . '/EDD_SL_Plugin_Updater.php' );

			new EDD_SL_Plugin_Updater( $this->args->url, $this->args->file, $this->args->args );

		} // end updater

		/**
		 * Add the license field
		 *
		 * @since 1.0.10
		 */
		public function licenseField( $plugin )
		{

			if ( false !== strpos( $plugin, DFBM()->domain() ) ) :

				$prefix = DFBM()->prefix();
				$text01 = esc_html__( 'Enter Your License Key for future updates', DFBM()->domain() );
				$text02 = esc_html__( 'Submit', DFBM()->domain() );
				$text03 = esc_html__( 'You can get it ', DFBM()->domain() );
				$text04 = esc_html__( 'here.', DFBM()->domain() );

				echo <<<FORM
					</tr><tr class="plugin-update-tr">
						<td colspan="3" class="plugin-update" style="border-left: 4px solid #00a0d2">
							<div class="update-message" style="margin-top:5px;margin-bottom:5px;">
								<form action="" method="POST">
									<input type="hidden" name="{$prefix}_license" value="license_key">
									<div class="about-text" style="display:inline-block">
										<div>
											<input id="{$prefix}-license-field" type="text" class="regular-text" id="license_key" value="" name="license_key" placeholder="{$text01}" style="min-height:30px;">
										</div>
									</div>
									<div style="display:inline-block">
										<button id="{$prefix}-license-submit" class="button button-primary" type="submit" value="Submit" name="_submit" style="margin-top:-6px;border-radius:0">{$text02}</button>
									</div>
								</form>
								<div style="display:inline-block;margin-left:5px">
									<span style="margin-right:5px">-</span><span>{$text03}</span><a href="https://elegantmarketplace.com/checkout/purchase-history/" target="_blank">{$text04}</a>
								</div>
							</div>
						</td>
FORM;

			endif;

		} // end licenseField

		/**
		 * Link to remove the license
		 *
		 * @since 1.0.10
		 */
		public function removeLink( $items )
		{

			$items[] = '<a id="' . DFBM()->prefix() . '-remove-license' . '" href="#">' . esc_html__( 'Remove License', DFBM()->domain() ) . '</a>';

			return $items;

		} // end removeLink

		/**
		 * Verify request
		 *
		 * @since 1.0.10
		 */
		private function verifyRequest( $opt )
		{

			$r = $_REQUEST;

			$nonce = isset( $r['nonce'] ) ? esc_attr( $r['nonce'] ) : false;

			if ( $nonce && wp_verify_nonce( $nonce, DFBM()->prefix() . '-nonce-value' ) ) :

				if ( isset( $r[$opt], $r['license'] ) && 'true' == $r[$opt] )
					return true;

			endif;

			wp_send_json( (object) [ 'failed' => $this->getMessage()->error ] );

			wp_die();

		} // end verifyRequest

		/**
		 * Get error message
		 *
		 * @since 1.0.10
		 */
		protected function getMessage()
		{

			$message = 'The license has been successfully ';

			return (object)
			[

				'error'   => esc_html__( 'That fails. Please reload the page and try it again.', DFBM()->domain() ),
				'success' => esc_html__( $message . 'activated.', DFBM()->domain() ),
				'delete'  => esc_html__( $message . 'deactivated.', DFBM()->domain() ),

			];
		} // end getMessage

		/**
		 * Activate the license
		 *
		 * @since 1.0.10
		 */
		function activateLicense()
		{

			if ( $this->verifyRequest( DFBM()->prefix() . '_activate' ) ) :

				$licenseKey = trim( esc_attr( $_REQUEST['license'] ) );

				$response   = $this->apiRemoteRequest( 'activate_license', $licenseKey );

				if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) :

					if ( is_wp_error( $response ) )
						$message = $response->get_error_message();

					else
						$message = esc_html__( 'An error occurred, please try again.', DFBM()->domain() );

				else :

					$license = json_decode( wp_remote_retrieve_body( $response ) );

					if ( false === $license->success ) :

						switch( $license->error ) :

							case 'expired' :

								$message = sprintf(
									esc_html__( 'Your license key expired on %s.', DFBM()->domain() ),
									date_i18n( get_option( 'date_format' ), strtotime( $license->expires, current_time( 'timestamp' ) ) )
								);

								break;

							case 'revoked' :

								$message = esc_html__( 'Your license key has been disabled.', DFBM()->domain() );

								break;

							case 'missing' :

								$message = esc_html__( 'Invalid license.', DFBM()->domain() );

								break;

							case 'invalid' :
							case 'site_inactive' :

								$message = esc_html__( 'Your license is not active for this URL.', DFBM()->domain() );

								break;

							case 'item_name_mismatch' :

								$message = sprintf(
									esc_html__( 'This appears to be an invalid license key for %s.', DFBM()->domain() ),
									DFBM()->title()
								);

								break;

							case 'no_activations_left':

								$message = esc_html__( 'Your license key has reached its activation limit.', DFBM()->domain() );

								break;

							default :

								$message = esc_html__( 'An error occurred, please try again.', DFBM()->domain() );

								break;

						endswitch;
					endif;
				endif;

				if ( isset( $message ) ) :

					wp_send_json( (object) [ 'failed' => $message ] );

					wp_die();

				endif;

				( new dfbmModelSet )->option( DFBM()->prefix() . '_license_status', $license->license );
				( new dfbmModelSet )->option( DFBM()->prefix() . '_license_key', $licenseKey );

				$this->clearCaches();

			endif;

			wp_send_json( (object) [ 'success' => $this->getMessage()->success ] );

			wp_die();

		} // end activateLicense

		/**
		 * Deactivate the license
		 *
		 * @since 1.0.10
		 */
		public function deactivateLicense()
		{

			if ( $this->verifyRequest( DFBM()->prefix() . '_deactivate' ) ) :

				$response = $this->apiRemoteRequest( 'deactivate_license', $this->licenseKey );

				if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) :

					if ( is_wp_error( $response ) )
						$message = $response->get_error_message();

					else
						$message = __( 'An error occurred, please try again.' );

					if ( isset( $message ) ) :

						wp_send_json( (object) [ 'failed' => $message ] );

						wp_die();

					endif;
				endif;

				$licenseData = json_decode( wp_remote_retrieve_body( $response ) );

				if( $licenseData->license == 'deactivated' ) :

					( new dfbmModelDelete )->option( DFBM()->prefix() . '_license_status' );
					( new dfbmModelDelete )->option( DFBM()->prefix() . '_license_key' );

					$this->clearCaches();

				endif;
			endif;

			wp_send_json( (object) [ 'delete' => $this->getMessage()->delete ] );

			wp_die();

		} // end deactivateLicense

		/**
		 * Clear EDD and plugin caches
		 *
		 * @since 1.0.10
		 */
		public function clearCaches()
		{

			$slug = basename( $this->args->file, '.php' );
			$beta = empty( $this->args->args['beta'] ) ? false : true;
			$key  = md5( serialize( $slug . $this->args->args['license'] . $beta ) );
			$key2 = md5( serialize( $slug . $beta ) );

			( new dfbmModelDelete )->option( '_site_transient_update_plugins' );
			( new dfbmModelDelete )->option( 'edd_api_request_' . $key2 );
			( new dfbmModelDelete )->option( 'edd_api_request_' . $key );
			( new dfbmModelDelete )->option( $key2 );
			( new dfbmModelDelete )->option( $key );

		} // end clearCaches

		/**
		 * Api remote request
		 *
		 * @since 1.0.10
		 */
		public function apiRemoteRequest( $request, $license )
		{

			$args =
			[

				'url'        => home_url(),
				'license'    => $license,
				'edd_action' => $request,
				'item_name'  => urlencode( DFBM()->title() ),

			];

			return wp_remote_post( DFBM()->host(), array( 'timeout' => 15, 'sslverify' => false, 'body' => $args ) );

		} // end apiRemoteRequest
	} // end class
} // end if
