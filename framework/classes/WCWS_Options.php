<?php
/*
Plugin Name: Customize Options
Description: Adds more options to the customize page
Author: RADD Creative
Version: 1.0
Author URI: raddcreative.com
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( ! class_exists( 'infinitishine_Options' ) ) :

    class infinitishine_Options{

        const THEME_SLUG = "infinitishine";

        private $options;

        protected static $instance;

        /** Return instance of Class */
        public static function get_instance() {
            if ( ! isset( self::$instance ) ) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        /**
         * Constructor
         */
        public function __construct(){
            $options = array();

            $this->init();
        }

        /**
         * Add fields to builtin site identity section
         */
        private function site_identy($wp_customize){
            //Logo
            $wp_customize->add_setting(
                self::THEME_SLUG."_setting[logo]",
                array(
                    'capability' 		=> 'edit_theme_options'
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Image_Control(
                    $wp_customize,
                    'logo',
                    array(
                        'label'      => __( 'Site Logo', self::THEME_SLUG ),
                        'section'    => 'title_tagline',
                        'settings'   => self::THEME_SLUG."_setting[logo]",
                    )
                )
            );
            
             //Copyright text prefix
            $wp_customize->add_setting(
                self::THEME_SLUG."_setting[copyright_prefix]",
                array(
                    'capability' 		=> 'edit_theme_options',
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Control(
                    $wp_customize,
                    'copyright_prefix',
                    array(
                        'label'         =>  __( 'Copyright Text Prefix', self::THEME_SLUG ),
                        'section'       =>  'title_tagline',
                        'settings'      =>  self::THEME_SLUG."_setting[copyright_prefix]",
                        'type'    	    =>  'checkbox',
                        'description'   =>  'Prefix Copyright Text automagically with current year'   
                    )
                )
            );
            
            //Copyright text
            $wp_customize->add_setting(
                self::THEME_SLUG."_setting[copyright]",
                array(
                    'capability' 		=> 'edit_theme_options',
                )
            );
            $wp_customize->add_control(
                new WP_Customize_Control(
                    $wp_customize,
                    'copyright',
                    array(
                        'label'      => __( 'Copyright Text', self::THEME_SLUG ),
                        'section'    => 'title_tagline',
                        'settings'   => self::THEME_SLUG."_setting[copyright]",
                        'type'    	=> 'text'
                    )
                )
            );
        }

        /**
         * Boostrap Theme options
         */
        private function init(){
            
            /** Add mode dev/live */
            add_action( 'customize_register', function($wp_customize){
                $this->site_identy($wp_customize);
            } );
        }
    }
endif;
infinitishine_Options::get_instance();