<?php
/**
 * Do not allow direct access
 *
 * @since	1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) die( 'Don\'t try to load this file directly!' );

/**
 * Divi - Filterable Blog Module - Controller Walker
 *
 * @since	1.0.0
 */
if ( ! class_exists( 'dfbmControllerWalker' ) )
{

	class dfbmControllerWalker extends Walker
	{

		/**
		 * Define properties
		 *
		 * @since	1.0.0
		 */
		private $nav;

		private $sep;

		private $admin;

		/**
		 * Constructor
		 *
		 * @since	1.0.0
		 */
		public function __construct( $nav = false, $sep = false, $admin = false )
		{

			/**
			 * Set properties
			 *
			 * @since 1.0.0
			 */
			$this->nav   = $nav;

			$this->sep   = $sep;

			$this->admin = $admin;

		} // end constructor

	    public $db_fields = array( 'parent' => 'parent', 'id' => 'term_id' );

		public $tree_type = 'category';

	    public function start_lvl( &$output, $depth = 0, $args = [] )
	    {

	    	if ( $this->nav ) :

		    	$direction = 0 === $depth ? ' left first' : '';

		        if ( $this->nav )
		        	$output .= "\n<ul class=\"dfbm-sub-menu" . $direction . " clearfix\" data-submenu-depth=\"" . $depth . "\">\n";

			endif;
	    } // end start_lvl

	    public function end_lvl( &$output, $depth = 0, $args = [] )
	    {

	        if ( $this->nav ) $output .= "</ul>\n";

	    } // end end_lvl

	    public function start_el( &$output, $object, $depth = 0, $args = [], $current_object_id = 0 )
	    {

	        if ( $this->nav ) :

	        	$output .=
	        		( $this->sep && 0 === $depth ? $this->sep : '' ) .
	        		'<li class="et_pb_blog_filter link">
	        			<a href="' . get_term_link( (int) $object->term_id, $object->taxonomy ) . '" class="cat-selector" data-cat-name="' . esc_attr( $object->name ) . '" data-cat-id="' . esc_attr( $object->term_id ) . '">' . esc_attr( $object->name ) . '</a>';

	        endif;

	        if ( $this->admin ) :

				$output .= sprintf(
					'%3$s<label class="dfbm-categories"%4$s><input id="&&route&&-%1$s" type="checkbox" name="et_pb_&&route&&_categories" value="%1$s">%2$s</label><br/>',
					esc_attr( $object->term_id ),
					esc_html( $object->name ),
					"\n\t\t\t\t\t",
					$depth > 0 ? ' style="margin-left:' . $depth * 30 . 'px;"' : ''
				);

	        endif;
	    } // end start_el

	    public function end_el( &$output, $object, $depth = 0, $args = [] )
	    {

	        if ( $this->nav )
	        	$output .= "</li>\n";

	        if ( $this->admin )
	        	$output .= '';

	    } // end end_el
	} // end class
} // end if
