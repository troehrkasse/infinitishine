<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	class Widget_Areas{
		protected static $instance;
		
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}
			return self::$instance;
		}
		
		public function __construct(){
			add_action('widgets_init', array(&$this,'hook_widgets_init') );
		}
		
		
		/**
		*
		*/
		public function hook_widgets_init(){

			if (function_exists('register_sidebar')) {
				/*register_sidebar(array(
					'name'=> 'Home Content',
					'id' => 'home_content',
					'before_widget' => '<div id="%1$s" class="bsusa-widget bsusa-widget-home %2$s">',
					'after_widget' => '</div>',
					'before_title' => '<h2 class="widget-title title">',
					'after_title' => '</h2>'
				));
				
				register_sidebar(array(
					'name'=> 'Home Sidebar',
					'id' => 'home_sidebar',
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget' => '</div>',
					'before_title' => '<h3 widget-title title>',
					'after_title' => '</h3>',
				));*/
				register_sidebar(array(
					'name'=> 'Footer',
					'id' => 'infinitishine_footer_fluid_columns',
					'before_widget' => '<div id="%1$s" class="col-sm-6 col-sl-4"><div class="footer-widget %2$s">',
					'after_widget' => '</div></div>',
					'before_title' => '<h3>',
					'after_title' => '</h3>',
				));
				
				register_sidebar( array(
					'name'				=> 'Shop',
					'id'				=> 'infinitishine_shop',
					'description'   	=> 'The sidebar that shows up on the Shop page',
					'class'				=> 'teo_blog_widget',
					'before_widget'		=> '<div id="%1$s" class="widget  teo-blog-widget %2$s">',
					'after_widget'		=> '</div>',
					'before_title'		=> '<div class="widget-title"><h2>',
					'after_title'		=> '</h2></div>',
				) );
				
				register_sidebar( array(
					'name'				=> 'Blog',
					'id'				=> 'infinitishine_blog',
					'description'   	=> 'The sidebar that shows up on blog pages',
					'class'				=> 'teo_blog_widget',
					'before_widget'		=> '<div id="%1$s" class="widget  teo-blog-widget %2$s">',
					'after_widget'		=> '</div>',
					'before_title'		=> '<div class="widget-title"><h2>',
					'after_title'		=> '</h2></div>',
				) );
				/*register_sidebar(array(
					'name'=> 'Home Four',
					'id' => 'home_four',
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget' => '</div>',
					'before_title' => '<h3>',
					'after_title' => '</h3>',
				));
				
				register_sidebar(array(
					'name'=> 'Home Five',
					'id' => 'home_five',
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget' => '</div>',
					'before_title' => '<h3>',
					'after_title' => '</h3>',
				));*/
			}	
		}
	}Widget_Areas::get_instance(); ?>