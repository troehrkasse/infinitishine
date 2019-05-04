<?php 

if ( ! defined( 'ABSPATH' ) ) exit;

 //Add Modudule's cusotm db settings
 add_filter('awesome_framework_customizer_settings', function($settings){
    //Products Listing
    $settings[] = [
	    'id'        =>  'infinitishine_setting[products_cat]',
        'type'      =>  'theme_mod',
    ];
    $settings[] = [
	    'id'        =>  'infinitishine_setting[load_primary_cat]',
        'type'      =>  'theme_mod',
        'default'   =>  false
    ];
    $settings[] = [
	    'id'        =>  'infinitishine_setting[load_primary_cat_excludes]',
        'type'      =>  'theme_mod',
    ];
    $settings[] = [
	    'id'        =>  'infinitishine_setting[load_primary_cats]',
        'type'      =>  'theme_mod',
    ];
    $settings[] = [
	    'id'        =>  'infinitishine_setting[products_cats]',
        'type'      =>  'theme_mod',
    ];
    $settings[] = [
	    'id'        =>  'infinitishine_setting[products_posts_per_page]',
        'type'      =>  'theme_mod',
        'default'   =>  16
    ];
    $settings[] = [
	    'id'        =>  'infinitishine_setting[product_lazy_thumb]',
        'type'      =>  'theme_mod'
    ];
    $settings[] = [
	    'id'        =>  'infinitishine_setting[accessories_cat]',
        'type'      =>  'theme_mod',
    ];
    $settings[] = [
	    'id'        =>  'infinitishine_setting[accessories_posts_per_page]',
        'type'      =>  'theme_mod',
        'default'   =>  18
    ];
    $settings[] = [
	    'id'        =>  'infinitishine_setting[sort_by_metas]',
        'type'      =>  'theme_mod',
        'default'   =>  '_price'
    ];

     //Header
     $settings[] = [
         'id' => 'infinitishine_setting[header][show_page_slider_or_featured]',
         'type' => 'theme_mod'
     ];
    
 	//Footer
 	$settings[] = [
	    'id'        =>  'infinitishine_setting[footer][background]',
        'default'   => __( infinitishine_ASSETS_URI.'images/cork-background.png', 'infinitishine' ),
        'type'      =>  'theme_mod',
    ];
    
    //Home Page
     $settings[] = [
	    'id'        =>  'infinitishine_setting[pages][home][banner][1][title]',
        'type'      =>  'theme_mod',
        'default'   =>  'INTERACTIVE CATALOG!'
    ];
    $settings[] = [
	    'id'        =>  'infinitishine_setting[pages][home][banner][1][text]',
        'type'      =>  'theme_mod',
        'default'   =>  ''
    ];
    $settings[] = [
	    'id'        =>  'infinitishine_setting[pages][home][banner][2][title]',
        'type'      =>  'theme_mod',
        'default'   =>  ''
    ];
    $settings[] = [
	    'id'        =>  'infinitishine_setting[pages][home][banner][2][text]',
        'type'      =>  'theme_mod',
        'default'   =>  ''
    ];
    $settings[] = [
	    'id'        =>  'infinitishine_setting[pages][home][banner][2][watermark_top]',
        'type'      =>  'theme_mod',
        'default'   =>  ''
    ];
    $settings[] = [
	    'id'        =>  'infinitishine_setting[pages][home][banner][2][watermark_bottom]',
        'type'      =>  'theme_mod',
        'default'   =>  ''
    ];
    $settings[] = [
	    'id'        =>  'infinitishine_setting[pages][home][banner][2][link]',
        'type'      =>  'theme_mod',
        'default'   =>  ''
    ];

    // Product Labels
     $settings[] = [
         'id'        =>  'infinitishine_setting[labels][product_search]',
         'type'      =>  'theme_mod',
         'default'   =>  'Search Products and Accessories'
     ];

 	return $settings;
 }, 60);
 
 //Hook in Module's custom controls
 add_filter('awesome_framework_customizer_controls', function($controls){
    //Products
    $controls[] = [
        'id'            =>  'infinitishine_setting[products_cat]',
        'type'          =>  'select',
        'section'       =>  'infinitishine_mods_products',
        'label'         =>  __( 'Products Primary Category' ),
        'description'   =>  __( 'Select the main parent categories primary product'),
        'choices'       =>  bn_array_flatten( array_map(function($t){return [$t->term_id => $t->name];}, Timber::get_terms('product_cat', ['parent'=>0])) )
    ];
    $controls[] = [
        'id'            =>  'infinitishine_setting[load_primary_cat]',
        'type'          =>  'checkbox',
        'section'       =>  'infinitishine_mods_products',
        'label'         =>  __( 'Load Primary Category First' ),
        'description'   =>  __( 'On relevat archive pages, load products from primary category first. User will have the option to filter to show other products or just products from other categories.'),
    ];
    $controls[] = [
        'id'            =>  'infinitishine_setting[load_primary_cat_excludes]',
        'type'          =>  'textarea',
        'section'       =>  'infinitishine_mods_products',
        'label'         =>  __( 'Exclude from Load Primary Category First' ),
        'description'   =>  __( 'enter a comma delimited list of terms you would like excluded from the Load Primary First filter rule.'),
    ];
    $controls[] = [
        'id'            =>  'infinitishine_setting[load_primary_cats]',
        'type'          =>  'select',
        'section'       =>  'infinitishine_mods_products',
        'label'         =>  __( 'Only Load Primary Category First ' ),
        'description'   =>  __( 'Select the taxonomies you would like exclusively apply the Load Primary First filter rule to. All other taxonomies will be ignored'),
        'choices'       =>  bn_array_flatten( array_map(function($t){ return [$t->query_var => $t->labels->singular_name];}, get_taxonomies(['public'   => true, '_builtin' => false], 'objects')) )
    ];
    $controls[] = [
        'id'            =>  'infinitishine_setting[products_cats]',
        'type'          =>  'checkbox',
        'class'         =>  'BN_Customize_Control_Checkbox_Multiple',
        'section'       =>  'infinitishine_mods_products',
        'label'         =>  __( 'Other Top Level Product Categories' ),
        'description'   =>  __( 'Select all top level categories that are not for organizing accessories.'),
        'choices'       =>  bn_array_flatten( array_map(function($t){return [$t->term_id => $t->name];}, Timber::get_terms('product_cat', ['parent'=>0])) )
    ];
    $controls[] = [
        'id'            =>  'infinitishine_setting[products_posts_per_page]',
        'type'          =>  'number',
        'section'       =>  'infinitishine_mods_products',
        'label'         =>  __( 'Primary Product Posts Per Page' ),
        'description'   =>  __( ''),
    ];
    $controls[] = [
        'id'            =>  'infinitishine_setting[accessories_cat]',
        'type'          =>  'select',
        'section'       =>  'infinitishine_mods_products',
        'label'         =>  __( 'Accessories Category' ),
        'description'   =>  __( 'Select the main parent category all Accessories will be added to.'),
        'choices'       =>  bn_array_flatten( array_map(function($t){return [$t->term_id => $t->name];}, Timber::get_terms('product_cat', ['parent'=>0])) )
    ];
    $controls[] = [
        'id'            =>  'infinitishine_setting[accessories_posts_per_page]',
        'type'          =>  'number',
        'section'       =>  'infinitishine_mods_products',
        'label'         =>  __( 'Accessories Posts Per Page' ),
        'description'   =>  __( ''),
    ];
    $controls[] = [
        'id'            =>  'infinitishine_setting[sort_by_metas]',
        'type'          =>  'textarea',
        'section'       =>  'infinitishine_mods_products',
        'label'         =>  __( 'Sort by Meta Data' ),
        'description'   =>  __( 'Entere a comma deliminated (no spaces) list of meta values you would like products to be sorted on archive pages.')
    ];
    $controls[] = [
        'id'            =>  'infinitishine_setting[product_lazy_thumb]',
        'type'          =>  'image',
        'class'         =>  'WP_Customize_Image_Control',
        'section'       =>  'infinitishine_mods_products',
        'label'         =>  __( 'Product lazy load image' ),
        'description'   =>  __( 'Select and placeholder image to enable lazy loading of images.')
    ];

     //Header
     $controls[] = [
         'id' => 'infinitishine_setting[header][show_page_slider_or_featured]',
         'type' => 'checkbox',
         'section' => 'wcms_mods_header',
         'label' => __('Show Page Slider or Feature Image'),
         'description' => __('Check to show sliders on between top and product menu.'),
     ];
    
    //Footer
    $controls[] = [
        'id'            =>  'infinitishine_setting[footer][background]',
        'type'          =>  'image',
        'class'         =>  'WP_Customize_Image_Control',
        'section'       =>  'infinitishine_mods_footer',
        'label'         =>  __( 'Footer Background' ),
        'description'   =>  __( ''),
    ];
    
    //Home Page
    $controls[] = [
        'id'            =>  'infinitishine_setting[pages][home][banner][1][title]',
        'type'          =>  'text',
        'section'       =>  'infinitishine_mods_pages_home',
        'label'         =>  __( 'Banner 1: Title' ),
        'description'   =>  __( 'Main Banner Title'),
    ];
    $controls[] = [
        'id'            =>  'infinitishine_setting[pages][home][banner][1][text]',
        'type'          =>  'textarea',
        'section'       =>  'infinitishine_mods_pages_home',
        'label'         =>  __( 'Banner 1: Text' ),
        'description'   =>  __( 'Main Banner Text'),
    ];
    $controls[] = [
        'id'            =>  'infinitishine_setting[pages][home][banner][2][title]',
        'type'          =>  'text',
        'section'       =>  'infinitishine_mods_pages_home',
        'label'         =>  __( 'Banner 2: Title' ),
        'description'   =>  __( 'Main Banner Title'),
    ];
    $controls[] = [
        'id'            =>  'infinitishine_setting[pages][home][banner][2][text]',
        'type'          =>  'text',
        'section'       =>  'infinitishine_mods_pages_home',
        'label'         =>  __( 'Banner 2: Text' ),
        'description'   =>  __( 'Main Banner Text'),
    ];
    $controls[] = [
        'id'            =>  'infinitishine_setting[pages][home][banner][2][watermark_top]',
        'type'          =>  'text',
        'section'       =>  'infinitishine_mods_pages_home',
        'label'         =>  __( 'Banner 2:Top Watermark' ),
        'description'   =>  __( 'Main Banner background/watermark text'),
    ];
    $controls[] = [
        'id'            =>  'infinitishine_setting[pages][home][banner][2][watermark_bottom]',
        'type'          =>  'text',
        'section'       =>  'infinitishine_mods_pages_home',
        'label'         =>  __( 'Banner 2:Bottom Watermark' ),
        'description'   =>  __( 'Main Banner background/watermark text'),
    ];
    $controls[] = [
        'id'            =>  'infinitishine_setting[pages][home][banner][2][link]',
        'type'          =>  'text',
        'section'       =>  'infinitishine_mods_pages_home',
        'label'         =>  __( 'Banner 2: Link' ),
        'description'   =>  __( 'Link to go when when banner is clicked'),
    ];

     //Labels
     $controls[] = [
         'id'            =>  'infinitishine_setting[labels][product_search]',
         'type'          =>  'text',
         'section'       =>  'infinitishine_mods_labels',
         'label'         =>  __( 'Product Search Placeholder' ),
         'description'   =>  __( 'placeholder for product searchform'),
     ];
    
 	return $controls;
 }, 60);
 
 //Add Module's custom settings section
 add_filter('awesome_framework_customizer_sections', function($sections){
 	$my_sections = [
 	    [
            'id'            =>  'infinitishine_mods_pages_home',
            'title'         =>  'Pages:Home',
            'description'   =>  'Home Page customizations'
        ],
 	    [
            'id'            =>  'infinitishine_mods_products',
            'title'         =>  'Product Listing',
            'description'   =>  'Product Listing customizations'
        ],
        [
            'id'            =>  'infinitishine_mods_labels',
            'title'         =>  'Labels',
            'description'   =>  'Site Labels'
        ],
        [
            'id' => 'wcms_mods_header',
            'title' => 'Header',
            'description' => 'Site Header customizations'
        ],
        [
            'id'            =>  'infinitishine_mods_footer',
            'title'         =>  'Footer',
            'description'   =>  'Site footer customizations'
        ]
    ];
    
 	return array_merge($my_sections, $sections);
 }, 60);