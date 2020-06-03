<?php
/**
 * Do not allow direct access
 *
 * @since	1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Don\'t try to load this file directly!' );

/**
 * Divi - Filterable Blog Module - Trait Constants
 *
 * @since	1.0.0
 */
if ( ! trait_exists( 'dfbmTraitConstants' ) )
{

	trait dfbmTraitConstants
	{

		/**
		 * Define properties
		 *
		 * @since	1.0.0
		 */
		private $file;

		private $name;

		private $host;

		private $light;

		private $theme;

		private $views;

		private $title;

		private $folder;

		private $assets;

		private $assUrl;

		private $domain;

		private $relAts;

		private $prefix;

		private $suffix;

		private $divFunc;

		private $divElem;

		private $version;

		private $updater;

		private $includes;

		/**
		 * Set properties
		 *
		 * @since	1.0.0
		 */
		protected function initConstants()
		{

			$this->suffix   = '.min';

			$this->file     = dfbmPluginInitialize::FILE;

			$this->domain   = dfbmPluginInitialize::DOMAIN;

			$this->prefix   = dfbmPluginInitialize::PREFIX;

			$this->version  = dfbmPluginInitialize::VERSION;

			$this->loadConfiguration();

			$this->folder   = plugin_dir_path( $this->file );

			$this->assets   = $this->folder . 'assets/';

			$this->includes = $this->folder . 'includes/';

			$this->views    = $this->includes . 'view/';

			$this->title   = 'Divi Filterable Blog Module';

			$this->host     = 'https://elegantmarketplace.com';

			$this->updater  = (object)
			[

				'url'  => $this->host,
				'file' => $this->file,
				'args' =>
				[
					'license' 	=> '',
					'beta'		=> false,
					'item_id'	=> 356708,
					'item_name' => $this->title,
					'version' 	=> $this->version,
					'author' 	=> 'Bruno Bouyajdad',
				]
			];

			$this->name     = esc_html__( $this->title, $this->domain );

			$this->assUrl   = plugin_dir_url( $this->file ) . 'assets/';

			$this->relAts   = basename( dirname( $this->file ) ) . '/assets/';

			$this->light    = esc_html__( $this->title . ' Light', $this->domain );

			$this->divFunc  = get_template_directory() . '/includes/builder/functions.php';

			$this->divElem  = get_template_directory() . '/includes/builder/class-et-builder-element.php';

			$this->theme   = 'Divi' == wp_get_theme()->template || 'Extra' == wp_get_theme()->template ? true : false;

		} // end initConstants

		/**
		 * Get properties
		 *
		 * @since	1.0.0
		 */
		public function file()     { return $this->file; } // end file

		public function name()     { return $this->name; } // end name

		public function host()     { return $this->host; } // end host

		public function views()    { return $this->views; } // end views

		public function theme()    { return $this->theme; } // end theme

		public function title()    { return $this->title; } // end title

		public function light()    { return $this->light; } // end light

		public function domain()   { return $this->domain; } // end domain

		public function prefix()   { return $this->prefix; } // end prefix

		public function suffix()   { return $this->suffix; } // end suffix

		public function folder()   { return $this->folder; } // end folder

		public function assets()   { return $this->assets; } // end assets

		public function relAts()   { return $this->relAts; } // end relAts

		public function assUrl()   { return $this->assUrl; } // end assUrl

		public function version()  { return $this->version; } // end version

		public function divFunc()  { return $this->divFunc; } // end divFunc

		public function updater()  { return $this->updater; } // end updater

		public function divElem()  { return $this->divElem; } // end divElem

		public function includes() { return $this->includes; } // end includes

		public function dfbmIsCached() { return file_exists( trailingslashit( WP_CONTENT_DIR ) . 'advanced-cache.php' ); } // dfbmIsCached

		/**
		 * Load Configuration File
		 *
		 * @since	1.0.0
		 */
		private function loadConfiguration()
		{

			$file = get_stylesheet_directory() . '/includes/' . $this->prefix . '-config.php';

			if ( is_file( $file ) )
				require_once( $file );

		} // end loadConfiguration
	} // end trait
} // end if
