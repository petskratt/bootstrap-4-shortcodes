<?php

namespace MWD\BS4Shortcodes;

/**
 * Bootstrap 4 Shortcodes class
 */
class Shortcodes {

	/**
	 * Initialize shortcodes and conditionally include opt-in Bootstrap scripts
	 */

	function __construct() {
		//Initialize shortcodes
		$this->add_shortcodes();
		add_filter('the_content', array( $this, 'bs_fix_shortcodes') );

		//Conditionally include tooltip functionality (see function for conditionals)
		//add_action( 'the_post', array( $this, 'bootstrap_shortcodes_tooltip_script' ), 9999 );
		//Conditionally include popupver functionality (see function for conditionals)
		//add_action( 'the_post', array( $this, 'bootstrap_shortcodes_popover_script' ), 9999 );
	}



	/**
	 * Remove extra paragraphs and line breaks around shortcodes
	 * @param  string $content the content
	 * @return string          the content again
	 */
	function bs_fix_shortcodes($content){
			$array = array (
					'<p>[' => '[',
					']</p>' => ']',
					']<br />' => ']',
					']<br>' => ']'
			);
			$content = strtr($content, $array);
			return $content;
	}


	/**
	 * Create shortcodes from array of names using WordPress add_shortcode()
	 */
	function add_shortcodes() {
		$shortcodes = array(
			'container',
			'container-fluid',
			'row',
			'column',

			'media-list',
			'media',
			'media-object',
			'media-heading',

			'hidden',

			'alert',

			'breadcrumb',
			'active',
			'disabled',

			'button',
			'button-group',
			'button-toolbar',

			'card',
			'card-block',
			'card-title',
			'card-subtitle',
			'card-img',
			'card-img-overlay',
			'card-header',
			'card-footer',

			'carousel',

			'jumbotron',

			'list-group',

			'nav',
			'pagination'


		);
		foreach ( $shortcodes as $shortcode ) {
			$function = 'bs_' . str_replace( '-', '_', $shortcode );
			add_shortcode( $shortcode, array( $this, $function ) );
		}
	}



	/**
	 * Container shortcode
	 * @param  [type] $atts    shortcode attributes
	 * @param  string $content shortcode contents
	 * @return string
	 */
	function bs_container( $atts, $content = null ) {
		$atts = shortcode_atts( array(
				"class" => false,
				"data"   => false,
		), $atts );

		$class	= array();
		$class[]	= 'container';

		$return = Utilities::bs_output(
			sprintf(
				'<div class="%s"%s>%s</div>',
				Utilities::class_output(__FUNCTION__, $class, $atts['class']),
				Utilities::parse_data_attributes( $atts['data'] ),
				do_shortcode( $content )
			)
		);

		return $return;
	}



	/**
	 * Container-Fluid shortcode
	 * @param  [type] $atts    shortcode attributes
	 * @param  string $content shortcode contents
	 * @return string
	 */
	function bs_container_fluid( $atts, $content = null ) {
		$atts = shortcode_atts( array(
				"class" => false,
				"data"   => false,
		), $atts );

		$class	= array();
		$class[]	= ( $atts['fluid']   == 'true' )  ? 'container-fluid' : 'container';

		$return = Utilities::bs_output(
			sprintf(
				'<div class="%s"%s>%s</div>',
				Utilities::class_output(__FUNCTION__, $class, $atts['class']),
				Utilities::parse_data_attributes( $atts['data'] ),
				do_shortcode( $content )
			)
		);

		return $return;
	}



	/**
	 * Row shortcode
	 * @param  [type] $atts    shortcode attributes
	 * @param  string $content shortcode contents
	 * @return string
	 */
	function bs_row( $atts, $content = null ) {
		$atts = shortcode_atts( array(
				"class" => false,
				"data"   => false
		), $atts );

		$class	= array();
		$class[]	= 'row';

		$return = Utilities::bs_output(
			sprintf(
				'<div class="%s"%s>%s</div>',
				Utilities::class_output(__FUNCTION__, $class, $atts['class']),
				Utilities::parse_data_attributes( $atts['data'] ),
				do_shortcode( $content )
			)
		);

		return $return;
	}


	/**
	 * Column shortcode
	 * @param  [type] $atts    shortcode attributes
	 * @param  string $content shortcode contents
	 * @return string
	 */
	function bs_column( $atts, $content = null ) {
		$atts = shortcode_atts( array(
				"xs"	=> false,
				"sm"	=> false,
				"md"	=> false,
				"lg"	=> false,
				"xl"	=> false,

				"offset-xs"	=> false,
				"offset-sm"	=> false,
				"offset-md"	=> false,
				"offset-lg"	=> false,
				"offset-xl"	=> false,

				"pull-xs"	=> false,
				"pull-sm"	=> false,
				"pull-md"	=> false,
				"pull-lg"	=> false,
				"pull-xl"	=> false,

				"push-xs"	=> false,
				"push-sm"	=> false,
				"push-md"	=> false,
				"push-lg"	=> false,
				"push-xl"	=> false,

				"class"	=> false,
				"data"	=> false
		), $atts );

		$class	= array();

		$class[]	= ( $atts['xs'] )		? 'col-xs' . (($atts['xs'] == "flex") ? null : '-' . $atts['xs']) : null;
		$class[]	= ( $atts['sm'] )		? 'col-sm' . (($atts['sm'] == "flex") ? null : '-' . $atts['sm']) : null;
		$class[]	= ( $atts['md'] )		? 'col-md' . (($atts['md'] == "flex") ? null : '-' . $atts['md']) : null;
		$class[]	= ( $atts['lg'] )		? 'col-lg' . (($atts['lg'] == "flex") ? null : '-' . $atts['lg']) : null;
		$class[]	= ( $atts['xl'] )		? 'col-xl' . (($atts['xl'] == "flex") ? null : '-' . $atts['xl']) : null;

		$class[]	= ( $atts['offset-xs'] || $atts['offset-xs'] === "0" )		? 'col-xs-offset-' . $atts['offset-xs'] : null;
		$class[]	= ( $atts['offset-sm'] || $atts['offset-sm'] === "0" )		? 'col-sm-offset-' . $atts['offset-sm'] : null;
		$class[]	= ( $atts['offset-md'] || $atts['offset-md'] === "0" )		? 'col-md-offset-' . $atts['offset-md'] : null;
		$class[]	= ( $atts['offset-lg'] || $atts['offset-lg'] === "0" )		? 'col-lg-offset-' . $atts['offset-lg'] : null;
		$class[]	= ( $atts['offset-xl'] || $atts['offset-xl'] === "0" )		? 'col-xl-offset-' . $atts['offset-xl'] : null;

		$class[]	= ( $atts['pull-xs']   || $atts['pull-xs'] === "0" )		? 'col-xs-pull-' . $atts['pull-xs'] : null;
		$class[]	= ( $atts['pull-sm']   || $atts['pull-sm'] === "0" )		? 'col-sm-pull-' . $atts['pull-sm'] : null;
		$class[]	= ( $atts['pull-md']   || $atts['pull-md'] === "0" )		? 'col-md-pull-' . $atts['pull-md'] : null;
		$class[]	= ( $atts['pull-lg']   || $atts['pull-lg'] === "0" )		? 'col-lg-pull-' . $atts['pull-lg'] : null;
		$class[]	= ( $atts['pull-xl']   || $atts['pull-xl'] === "0" )		? 'col-xl-pull-' . $atts['pull-xl'] : null;

		$class[]	= ( $atts['push-xs']   || $atts['push-xs'] === "0" )		? 'col-xs-push-' . $atts['push-xs'] : null;
		$class[]	= ( $atts['push-sm']   || $atts['push-sm'] === "0" )		? 'col-sm-push-' . $atts['push-sm'] : null;
		$class[]	= ( $atts['push-md']   || $atts['push-md'] === "0" )		? 'col-md-push-' . $atts['push-md'] : null;
		$class[]	= ( $atts['push-lg']   || $atts['push-lg'] === "0" )		? 'col-lg-push-' . $atts['push-lg'] : null;
		$class[]	= ( $atts['push-xl']   || $atts['push-xl'] === "0" )		? 'col-xl-push-' . $atts['push-xl'] : null;


		$return = Utilities::bs_output(
			sprintf(
				'<div class="%s"%s>%s</div>',
				Utilities::class_output(__FUNCTION__, $class, $atts['class']),
				Utilities::parse_data_attributes( $atts['data'] ),
				do_shortcode( $content )
			)
		);

		return $return;
	}



	/**
	 * Media List (media object wrapper) shortcode
	 * @param  [type] $atts    shortcode attributes
	 * @param  string $content shortcode contents
	 * @return string
	 */
	function bs_media_list( $atts, $content = null ) {
		$atts = shortcode_atts( array(
				"class" => false,
				"data"   => false
		), $atts );

		$class	= array();
		$class[]  = 'media-list';

		$GLOBALS['media_list'] = true;

		Utilities::bs_output(
			sprintf(
				'<ul class="%s"%s>%s</div>',
				Utilities::class_output(__FUNCTION__, $class, $atts['class']),
				Utilities::parse_data_attributes( $atts['data'] ),
				do_shortcode( $content )
			)
		);

		unset($GLOBALS['media_list']);
		return $return;
	}



	/**
	 * Media (media object wrapper) shortcode
	 * @param  [type] $atts    shortcode attributes
	 * @param  string $content shortcode contents
	 * @return string
	 */
	function bs_media( $atts, $content = null ) {
		$atts = shortcode_atts( array(
				"class" => false,
				"data"   => false
		), $atts );

		$class	= array();
		$class[]  = 'media';

		$return = Utilities::bs_output(
			sprintf(
				'<%1$s class="%2$s"%3$s>%4$s</%1$s>',
				(isset($GLOBALS['media_list'])) ? 'li' : 'div',
				Utilities::class_output(__FUNCTION__, $class, $atts['class']),
				Utilities::parse_data_attributes( $atts['data'] ),
				do_shortcode( $content )
			)
		);

		return $return;
	}


	/**
	 * Media Object shortcode
	 * @param  [type] $atts    shortcode attributes
	 * @param  string $content shortcode contents
	 * @return string
	 */
	function bs_media_object( $atts, $content = null ) {
		$atts = shortcode_atts( array(
				"media"	=> "left",
				"alignment"	=> false,
				"class"	=> false,
				"data"	=> false
		), $atts );

		$search_tags	= array('figure', 'div', 'img', 'i', 'span');

		$wrap_before = (Utilities::testdom($content, $search_tags)) ? null : '<figure>';
		$wrap_after = (Utilities::testdom($content, $search_tags)) ? null : '</figure>';

		$class	= array();
		$class[]	= ($atts['media']) ? 'media-' . $atts['media'] : null;
		$class[]	= ($atts['alignment']) ? 'media-' . $atts['alignment'] : null;

		$object_class	= array();
		$object_class[]	= "media-object";

		$content = do_shortcode( $wrap_before . $content . $wrap_after );

		$return = Utilities::bs_output(
			sprintf(
				'<div class="%s"%s>%s</div>',
				Utilities::class_output(__FUNCTION__, $class, $atts['class']),
				Utilities::parse_data_attributes( $atts['data'] ),
				$content
			)
		);

		$return = Utilities::addclass( $search_tags, $return, $object_class );

		return $return;
	}



	/**
	 * Media Body shortcode
	 * @param  [type] $atts    shortcode attributes
	 * @param  string $content shortcode contents
	 * @return string
	 */
	function bs_media_body( $atts, $content = null ) {
		$atts = shortcode_atts( array(
				"class" => false,
				"data"   => false
		), $atts );

		$class	= array();
		$class[]  = 'media-body';

		$return = Utilities::bs_output(
			sprintf(
				'<div class="%s"%s>%s</div>',
				Utilities::class_output(__FUNCTION__, $class, $atts['class']),
				Utilities::parse_data_attributes( $atts['data'] ),
				do_shortcode( $content )
			)
		);

		return $return;
	}



	/**
	 * Media heading shortcode
	 * @param  [type] $atts    shortcode attributes
	 * @param  string $content shortcode contents
	 * @return string
	 */
	function bs_media_heading( $atts, $content = null ) {
		$atts = shortcode_atts( array(
				"class" => false,
				"data"   => false
		), $atts );

		$search_tags = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6');

		$wrap_before = (Utilities::testdom($content, $search_tags)) ? null : '<h4>';
		$wrap_after = (Utilities::testdom($content, $search_tags)) ? null : '</h4>';

		$class	= array();
		$class[]  = 'media-heading';

		$content = do_shortcode( $wrap_before . $content . $wrap_after );

		$return = Utilities::bs_output(
			sprintf(
				'%s',
				$content
			)
		);

		$return = Utilities::addclass( $search_tags, $return, $class );
		$return = Utilities::adddata( $search_tags, $return, $atts['data'] );


		return $return;
	}


	/**
	 * Hidden shortcode
	 * @param  [type] $atts    shortcode attributes
	 * @param  string $content shortcode contents
	 * @return string
	 */
	function bs_hidden( $atts, $content = null ) {
		$atts = shortcode_atts( array(
				"up" => false,
				"down"  => false,
				"class"  => false,
				"data"    => false
		), $atts );

		$class	= array();
		$class[]	= ( $atts['up'] )		? 'hidden-' . $atts['up'] . '-up': null;
		$class[]	= ( $atts['down'] )		? 'hidden-' . $atts['down'] . '-down': null;

		$content = do_shortcode( $content );

		$return = Utilities::bs_output(
			sprintf(
				'%s',
				$content
			)
		);

		$return = Utilities::addclass( null, $return, $class );
		$return = Utilities::adddata( null, $return, $atts['data'] );

		return $return;
	}



	/**
	 * Alert shortcode
	 * @param  [type] $atts    shortcode attributes
	 * @param  string $content shortcode contents
	 * @return string
	 */
	function bs_alert( $atts, $content = null ) {
		$atts = shortcode_atts( array(
				"type"	=> "success",
				"dismissible"	=> false,
				"class" => false,
				"data"	=> false
		), $atts );

		$class	= array();
		$class[]  = 'alert';
		$class[]  = 'alert-' . $atts['type'];
		$class[]	= 'alert-dismissible fade in';

		$link_class	= array();
		$link_class[]	= 'alert-link';

		$heading_class	= array();
		$heading_class[]	= 'alert-heading';

		$search_as = array('a');
		$search_headings = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6');

		$content = do_shortcode( trim($content) );
		$content = ($atts['dismissible']) ? '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $content : $content;

		$return = Utilities::bs_output(
			sprintf(
				'<div class="%s"%s role="alert">%s</div>',
				Utilities::class_output(__FUNCTION__, $class, $atts['class']),
				Utilities::parse_data_attributes( $atts['data'] ),
				$content
			)
		);

		$return = Utilities::addclass( $search_as, $return, $link_class );
		$return = Utilities::addclass( $search_headings, $return, $heading_class );

		return $return;
	}



	/**
	 * Breadcrumb shortcode
	 * @param  [type] $atts    shortcode attributes
	 * @param  string $content shortcode contents
	 * @return string
	 */
	function bs_breadcrumb( $atts, $content = null ) {
		$atts = shortcode_atts( array(
				"class"	=> false,
				"data"	=> false
		), $atts );

		$class	= array();
		$class[]	= 'breadcrumb';

		$a_class	= array();
		$a_class[]	= "breadcrumb-item";

		$search_tags	= array('a');

		$return = Utilities::bs_output(
			sprintf(
				'<nav class="%s"%s>%s</nav>',
				Utilities::class_output(__FUNCTION__, $class, $atts['class']),
				Utilities::parse_data_attributes( $atts['data'] ),
				Utilities::addclass( $search_tags, do_shortcode( $content ), $a_class )
			)
		);

		return $return;
	}


	/**
	 * Active shortcode
	 * @param  [type] $atts    shortcode attributes
	 * @param  string $content shortcode contents
	 * @return string
	 */
	function bs_active( $atts, $content = null ) {
		$atts = shortcode_atts( array(
				"class"	=> false,
				"data"	=> false
		), $atts );

		$class	= array();
		$class[]	= 'active';

		$search_tags	= array('a');

		$content = do_shortcode( $content );

		$return = Utilities::bs_output(
			sprintf(
				'%s',
				$content
			)
		);

		$return = Utilities::addclass( $search_tags, $return, $class );
		$return = Utilities::adddata( $search_tags, $return, $atts['data'] );

		return $return;
	}



	/**
	 * Disabled shortcode
	 * @param  [type] $atts    shortcode attributes
	 * @param  string $content shortcode contents
	 * @return string
	 */
	function bs_disabled( $atts, $content = null ) {
		$atts = shortcode_atts( array(
				"class"	=> false,
				"data"	=> false
		), $atts );

		$class	= array();
		$class[]	= 'disabled';

		$search_tags	= array('a');

		$content = do_shortcode( $content );

		$return = Utilities::bs_output(
			sprintf(
				'%s',
				$content
			)
		);

		$return = Utilities::addclass( $search_tags, $return, $class );
		$return = Utilities::adddata( $search_tags, $return, $atts['data'] );

		return $return;
	}



	/**
	 * Button shortcode
	 * @param  [type] $atts    shortcode attributes
	 * @param  string $content shortcode contents
	 * @return string
	 */
	function bs_button( $save_atts, $content = null ) {
		$atts = shortcode_atts( array(
			"type"			=> 'primary',
			"size"			=> false,
			"class"			=> false,
			"title"			=> false,
			"data"			=> false
		), $save_atts );

		$class	= array();
		$class[]	= 'btn';
		$class[]  = 'btn-' . $atts['type'];
		$class[]  = ($atts['size']) ? 'btn-' . $atts['size'] : null;
		$class[]	= (Utilities::is_flag('block', $save_atts)) ? 'btn-block' : null;
		$class[]	= (Utilities::is_flag('active', $save_atts)) ? 'active' : null;
		$class[]	= (Utilities::is_flag('disabled', $save_atts)) ? 'disabled' : null;

		$search_tags	= array('a', 'button', 'input');

		$content = do_shortcode( $content );
		$return = Utilities::bs_output(
			sprintf(
				'%s',
				$content
			)
		);

		$return = Utilities::addclass( $search_tags, $return, $class );
		$return = Utilities::adddata( $search_tags, $return, $atts['data'] );
		if (Utilities::is_flag('disabled', $atts)) {
			$return = Utilities::addaria( $search_tags, $return, 'disabled', 'true' );
		}

		return $return;
	}



	/**
	 * Button Group shortcode
	 * @param  [type] $atts    shortcode attributes
	 * @param  string $content shortcode contents
	 * @return string
	 */
	function bs_button_group( $save_atts, $content = null ) {
		$atts = shortcode_atts( array(
				"size"	=> false,
				"class"	=> false,
				"data"	=> false
		), $save_atts );

		$class	= array();
		$class[]	= 'btn-group';
		$class[]  = ($atts['size']) ? 'btn-group-' . $atts['size'] : null;
		$class[]	= (Utilities::is_flag('vertical', $save_atts)) ? 'btn-group-vertical' : null;

		$return = Utilities::bs_output(
			sprintf(
				'<div class="%s" role="group" %s>%s</div>',
				Utilities::class_output(__FUNCTION__, $class, $atts['class']),
				Utilities::parse_data_attributes( $atts['data'] ),
				do_shortcode( $content )
			)
		);

		return $return;
	}


	/**
	 * Button Toolbar shortcode
	 * @param  [type] $atts    shortcode attributes
	 * @param  string $content shortcode contents
	 * @return string
	 */
	function bs_button_toolbar( $atts, $content = null ) {
		$atts = shortcode_atts( array(
				"class"	=> false,
				"data"	=> false
		), $atts );

		$class	= array();
		$class[]	= 'btn-toolbar';

		$return = Utilities::bs_output(
			sprintf(
				'<div class="%s" role="toolbar" %s>%s</div>',
				Utilities::class_output(__FUNCTION__, $class, $atts['class']),
				Utilities::parse_data_attributes( $atts['data'] ),
				do_shortcode( $content )
			)
		);

		return $return;
	}



	/**
	 * Card shortcode
	 * @param  [type] $atts    shortcode attributes
	 * @param  string $content shortcode contents
	 * @return string
	 */
	function bs_card( $save_atts, $content = null ) {
		$atts = shortcode_atts( array(
				"type"	=> false,
				"class"	=> false,
				"data"	=> false
		), $save_atts );

		$class	= array();
		$class[]	= 'card';
		$class[]  = ($atts['type']) ? 'card-' . $atts['type'] : null;
		$class[]	= (Utilities::is_flag('inverse', $save_atts)) ? 'card-inverse' : null;

		$return = Utilities::bs_output(
			sprintf(
				'<div class="%s" %s>%s</div>',
				Utilities::class_output(__FUNCTION__, $class, $atts['class']),
				Utilities::parse_data_attributes( $atts['data'] ),
				$content = do_shortcode( $content )
			)
		);

		return $return;
	}


	/**
	 * Card Block shortcode
	 * @param  [type] $atts    shortcode attributes
	 * @param  string $content shortcode contents
	 * @return string
	 */
	function bs_card_block( $save_atts, $content = null ) {
		$atts = shortcode_atts( array(
				"class"	=> false,
				"data"	=> false
		), $save_atts );

		$class	= array();
		$class[]	= 'card-block';

		$p_class = array();
		$p_class[] = 'card-text';
		$p_tags	= array('p');

		$blockquote_class = array();
		$blockquote_class[] = 'card-blockquote';
		$blockquote_tags	= array('blockquote');

		$content = do_shortcode( $content );

		$return = Utilities::bs_output(
			sprintf(
				'<div class="%s" %s>%s</div>',
				Utilities::class_output(__FUNCTION__, $class, $atts['class']),
				Utilities::parse_data_attributes( $atts['data'] ),
				do_shortcode( $content )
			)
		);

		$return = Utilities::addclass( $p_tags, $return, $p_class );
		$return = Utilities::addclass( $blockquote_tags, $return, $blockquote_class );

		return $return;
	}



	/**
	 * Card title shortcode
	 * @param  [type] $atts    shortcode attributes
	 * @param  string $content shortcode contents
	 * @return string
	 */
	function bs_card_title( $atts, $content = null ) {
		$atts = shortcode_atts( array(
				"class" => false,
				"data"   => false
		), $atts );

		$search_tags = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6');

		$wrap_before = (Utilities::testdom($content, $search_tags)) ? null : '<h4>';
		$wrap_after = (Utilities::testdom($content, $search_tags)) ? null : '</h4>';

		$class	= array();
		$class[]  = 'card-title';

		$content = do_shortcode( $wrap_before . $content . $wrap_after );

		$return = Utilities::bs_output(
			sprintf(
				'%s',
				$content
			)
		);

		$return = Utilities::addclass( $search_tags, $return, $class );
		$return = Utilities::adddata( $search_tags, $return, $atts['data'] );

		return $return;
	}



	/**
	 * Card subtitle shortcode
	 * @param  [type] $atts    shortcode attributes
	 * @param  string $content shortcode contents
	 * @return string
	 */
	function bs_card_subtitle( $atts, $content = null ) {
		$atts = shortcode_atts( array(
				"class" => false,
				"data"   => false
		), $atts );

		$search_tags = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6');

		$wrap_before = (Utilities::testdom($content, $search_tags)) ? null : '<h6>';
		$wrap_after = (Utilities::testdom($content, $search_tags)) ? null : '</h6>';

		$class	= array();
		$class[]  = 'card-subtitle';

		$content = do_shortcode( $wrap_before . $content . $wrap_after );

		$return = Utilities::bs_output(
			sprintf(
				'%s',
				$content
			)
		);

		$return = Utilities::addclass( $search_tags, $return, $class );
		$return = Utilities::adddata( $search_tags, $return, $atts['data'] );

		return $return;
	}



		/**
		 * Card image shortcode
		 * @param  [type] $atts    shortcode attributes
		 * @param  string $content shortcode contents
		 * @return string
		 */
		function bs_card_img( $save_atts, $content = null ) {
			$atts = shortcode_atts( array(
					"class" => false,
					"data"   => false
			), $save_atts );

			$class	= array();
			$class[]  = 'card-img';
			$class[0]	= (Utilities::is_flag('top', $save_atts)) ? 'card-img-top' : null;
			$class[0]	= (Utilities::is_flag('bottom', $save_atts)) ? 'card-img-bottom' : null;

			$search_tags = array('img');

			$content = do_shortcode( $content );
			$content = strip_tags($content, '<img><a>');

			$return = Utilities::bs_output(
				sprintf(
					'%s',
					$content
				)
			);

			$return = Utilities::addclass( $search_tags, $return, $class );
			$return = Utilities::adddata( $search_tags, $return, $atts['data'] );

			return $return;
		}



		/**
		 * Card Image Overlay shortcode
		 * @param  [type] $atts    shortcode attributes
		 * @param  string $content shortcode contents
		 * @return string
		 */
		function bs_card_img_overlay( $atts, $content = null ) {
			$atts = shortcode_atts( array(
					"class"	=> false,
					"data"	=> false
			), $atts );

			$class	= array();
			$class[]	= 'card-img-overlay';

			$return = Utilities::bs_output(
				sprintf(
					'<div class="%s" %s>%s</div>',
					Utilities::class_output(__FUNCTION__, $class, $atts['class']),
					Utilities::parse_data_attributes( $atts['data'] ),
					$content = do_shortcode( $content )
				)
			);

			return $return;
		}


		/**
		 * Card header shortcode
		 * @param  [type] $atts    shortcode attributes
		 * @param  string $content shortcode contents
		 * @return string
		 */
		function bs_card_header( $atts, $content = null ) {
			$atts = shortcode_atts( array(
					"class" => false,
					"data"   => false
			), $atts );

			$search_tags = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6');

			$wrap_before = (Utilities::testdom($content, $search_tags)) ? null : '<div>';
			$wrap_after = (Utilities::testdom($content, $search_tags)) ? null : '</div>';

			$class	= array();
			$class[]  = 'card-header';

			$content = do_shortcode( $wrap_before . $content . $wrap_after );

			$return = Utilities::bs_output(
				sprintf(
					'%s',
					$content
				)
			);

			$return = Utilities::addclass( $search_tags, $return, $class );
			$return = Utilities::adddata( $search_tags, $return, $atts['data'] );

			return $return;
		}


		/**
		 * Card header shortcode
		 * @param  [type] $atts    shortcode attributes
		 * @param  string $content shortcode contents
		 * @return string
		 */
		function bs_card_footer( $atts, $content = null ) {
			$atts = shortcode_atts( array(
					"class" => false,
					"data"   => false
			), $atts );

			$search_tags = array('div');

			$wrap_before = (Utilities::testdom($content, $search_tags)) ? null : '<div>';
			$wrap_after = (Utilities::testdom($content, $search_tags)) ? null : '</div>';

			$class	= array();
			$class[]  = 'card-footer';

			$content = do_shortcode( $wrap_before . $content . $wrap_after );

			$return = Utilities::bs_output(
				sprintf(
					'%s',
					$content
				)
			);

			$return = Utilities::addclass( $search_tags, $return, $class );
			$return = Utilities::adddata( $search_tags, $return, $atts['data'] );

			return $return;
		}



		/**
		 * Carousel shortcode
		 * @param  [type] $atts    shortcode attributes
		 * @param  string $content shortcode contents
		 * @return string
		 */
		function bs_carousel( $atts, $content = null ) {
			$atts = shortcode_atts( array(
				"interval" => false,
				"pause" => false,
				"wrap" => true,
				"class" => false,
				"data"   => false
			), $atts );

			if( isset($GLOBALS['carousel_count']) )
				$GLOBALS['carousel_count']++;
			else
				$GLOBALS['carousel_count'] = 0;

			$atts_map = Utilities::attribute_map( $content );
			$indicators = array();
			// Extract the slide titles for use in the carousel widget.

			$class	= array();
			$class[]  = 'carousel';
			$class[]  = 'slide';

			$item_class	= array();
			$item_class[]  = 'carousel-item';

			$active_class	= array();
			$active_class[]  = 'active';

			$caption_class = array();
			$caption_class[] = 'carousel-caption';

			// Strip unwanted tags that WordPress likes inserting
			$content = strip_tags($content, '<img><figure><figcaption><a>');

			$item_tags = array('figure', 'img');
			$fallback_tag = 'div';

			$caption_tags = array('figcaption');

			$content = do_shortcode( $content );

			// Remove wrapped image alignment and caption classes
			$content = preg_replace('/alignnone/', '', $content);
			$content = preg_replace('/alignright/', '', $content);
			$content = preg_replace('/alignleft/', '', $content);
			$content = preg_replace('/aligncenter/', '', $content);
			$content = preg_replace('/wp-caption/', '', $content);

			$id = 'bs4-carousel-'. $GLOBALS['carousel_count'];


			$return = Utilities::bs_output(
				sprintf(
							'<div class="%s" id="%s" data-ride="carousel"%s%s%s%s>%s<div class="%s" role="listbox">%s</div>%s%s</div>',
							Utilities::class_output(__FUNCTION__, $class, $atts['class']),
							esc_attr( $id ),
							( $atts['interval'] )   ? sprintf( ' data-interval="%d"', $atts['interval'] ) : '',
							( $atts['pause'] )      ? sprintf( ' data-pause="%s"', esc_attr( $atts['pause'] ) ) : '',
							( $atts['wrap'] == 'true' ) ? sprintf( ' data-wrap="%s"', esc_attr( $atts['wrap'] ) ) : '',
							Utilities::parse_data_attributes( $atts['data'] ),
							( $indicators ) ? '<ol class="carousel-indicators">' . implode( $indicators ) . '</ol>' : '',
							'carousel-inner',
							$content,
							'<a class="left carousel-control"  href="' . esc_url( '#' . $id ) . '" role="button" data-slide="prev"><span class="icon-prev" aria-hidden="true"></span><span class="sr-only">Previous</span></a>',
							'<a class="right carousel-control" href="' . esc_url( '#' . $id ) . '" role="button" data-slide="next"><span class="icon-next" aria-hidden="true"></span><span class="sr-only">Next</span></a>'
						)
			);

			$return = Utilities::addclass( $item_tags, $return, $item_class );
			$return = Utilities::addclass( $item_tags, $return, $active_class, null, '1' );
			$return = Utilities::addclass( $caption_tags, $return, $caption_class);

			return $return;
		}



		/**
		 * Jumbotron shortcode
		 * @param  [type] $atts    shortcode attributes
		 * @param  string $content shortcode contents
		 * @return string
		 */
		function bs_jumbotron( $atts, $content = null ) {
			$atts = shortcode_atts( array(
					"class" => false,
					"data"   => false,
			), $atts );

			$class	= array();
			$class[]	= (Utilities::is_flag('fluid', $save_atts)) ? 'fluid' : null;

			$return = Utilities::bs_output(
				sprintf(
					'<div class="%s"%s>%s</div>',
					Utilities::class_output(__FUNCTION__, $class, $atts['class']),
					Utilities::parse_data_attributes( $atts['data'] ),
					do_shortcode( $content )
				)
			);

			return $return;
		}


		/**
		 * List Group shortcode
		 * @param  [type] $atts    shortcode attributes
		 * @param  string $content shortcode contents
		 * @return string
		 */
		function bs_list_group( $save_atts, $content = null ) {
			$atts = shortcode_atts( array(
				"class"			=> false,
				"data"			=> false
			), $save_atts );

			$search_tags	= array('ul', 'div');

			$wrap_before = (Utilities::testdom($content, $search_tags)) ? null : '<div>';
			$wrap_after = (Utilities::testdom($content, $search_tags)) ? null : '</div>';

			$class	= array();
			$class[]	= 'list-group';

			$li_class	= array();
			$li_class[]	= 'list-group-item';
			$li_search_tags	= array('li', 'a');

			$content = do_shortcode( $wrap_before . $content . $wrap_after );

			$return = Utilities::bs_output(
				sprintf(
					'%s',
					$content
				)
			);

			$return = Utilities::addclass( $search_tags, $return, $class );
			$return = Utilities::addclass( $li_search_tags, $return, $li_class );
			$return = Utilities::adddata( $search_tags, $return, $atts['data'] );

			return $return;
		}



		/**
		 * Nav shortcode
		 * @param  [type] $atts    shortcode attributes
		 * @param  string $content shortcode contents
		 * @return string
		 */
		function bs_nav( $save_atts, $content = null ) {
			$atts = shortcode_atts( array(
				"class"			=> false,
				"data"			=> false
			), $save_atts );

			$search_tags	= array('ul', 'nav');

			$wrap_before = (Utilities::testdom($content, $search_tags)) ? null : '<nav>';
			$wrap_after = (Utilities::testdom($content, $search_tags)) ? null : '</nav>';

			$class	= array();
			$class[]	= 'nav';
			$class[]	= (Utilities::is_flag('inline', $save_atts)) ? 'nav-inline' : null;
			$class[]	= (Utilities::is_flag('tabs', $save_atts)) ? 'nav-tabs' : null;
			$class[]	= (Utilities::is_flag('pills', $save_atts)) ? 'nav-pills' : null;
			$class[]	= (Utilities::is_flag('stacked', $save_atts)) ? 'nav-stacked' : null;

			$li_class	= array();
			$li_class[]	= 'nav-item';
			$li_search_tags	= array('li');

			$a_class	= array();
			$a_class[]	= 'nav-link';
			$a_search_tags	= array('a');

			$content = do_shortcode( $wrap_before . $content . $wrap_after );

			$return = Utilities::bs_output(
				sprintf(
					'%s',
					$content
				)
			);

			$return = Utilities::addclass( $search_tags, $return, $class );
			$return = Utilities::addclass( $li_search_tags, $return, $li_class );
			$return = Utilities::addclass( $a_search_tags, $return, $a_class );
			$return = Utilities::adddata( $search_tags, $return, $atts['data'] );

			return $return;
		}



		/**
		 * Nav shortcode
		 * @param  [type] $atts    shortcode attributes
		 * @param  string $content shortcode contents
		 * @return string
		 */
		function bs_pagination( $save_atts, $content = null ) {
			$atts = shortcode_atts( array(
				"size"			=> false,
				"class"			=> false,
				"data"			=> false
			), $save_atts );

			$search_tags	= array('nav');

			$wrap_before = (Utilities::testdom($content, $search_tags)) ? null : '<nav>';
			$wrap_after = (Utilities::testdom($content, $search_tags)) ? null : '</nav>';

			$class	= array();
			$class[]	= 'pagination';
			$class[]  = ($atts['size']) ? 'pagination-' . $atts['size'] : null;
			$ul_search_tags = array('ul');

			$li_class	= array();
			$li_class[]	= 'page-item';
			$li_search_tags	= array('li');

			$a_class	= array();
			$a_class[]	= 'page-link';
			$a_search_tags	= array('a');

			$content = do_shortcode( $wrap_before . $content . $wrap_after );

			$return = Utilities::bs_output(
				sprintf(
					'%s',
					$content
				)
			);

			$return = Utilities::addclass( $ul_search_tags, $return, $class );
			$return = Utilities::addclass( $li_search_tags, $return, $li_class );
			$return = Utilities::addclass( $a_search_tags, $return, $a_class );
			$return = Utilities::addparentclass( $a_search_tags, $return, array('active') );
			$return = Utilities::addparentclass( $a_search_tags, $return, array('disabled') );
			$return = Utilities::adddata( $search_tags, $return, $atts['data'] );

			return $return;
		}


} // End Boostrap4Shortcodes class