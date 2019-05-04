<?php
if ( ! defined( 'ABSPATH' ) )  exit; //exit if access directly
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
$args = array();

$queried_object = get_queried_object();
$options = infinitishine::get_options();


$options['sort_by_metas'] = [
    '_regular_price'    =>  'Price'
];

$context['options'] = $options;

$posts_per_page = 12;

$args = [
    'post_type'         => 'product',
    'posts_per_page'    =>  $posts_per_page,
    'paged'             =>  $paged,
];
//!Kint::dump($_GET);
if(is_object($queried_object)){
    $context['term'] = new \Timber\Term($queried_object->term_id);
    $args['tax_query']  =  [
        'relation'  =>  'AND',
        [
			'taxonomy' => $context['term']->taxonomy,
			'field'    => 'term_id',
			'terms'    => [$context['term']->term_id],
		],
    ];

    /**
     * Metal types filter
     */

    $context['metal_types'] = array_filter(Timber::get_terms('pa_metal', ['parent'=>0]), function($t) use($context){
       $args = [
            'post_type'          =>  'product',
            'posts_per_page'    =>  1,
            'tax_query'   =>  [
                'relation'  =>  'AND',
                [
                    'taxonomy' => $context['term']->taxonomy,
                    'field'    => 'id',
                    'terms'    => $context['term']->ID,
                ],
                [
                    'taxonomy' => $t->taxonomy,
                    'field'    => 'id',
                    'terms'    => $t->ID,
                ],
            ]
        ];

        $maybe_posts_in_term = new WP_Query($args);

        if(is_a($maybe_posts_in_term, 'WP_Error'))
            return false;

        if(intval($maybe_posts_in_term->found_posts) < 1)
            return false;

       return true;
    });

    /**
     * Size filter
     */
    $context['sizes'] = array_filter(Timber::get_terms('pa_size', ['parent'=>0]), function($t) use($context){
        $args = [
            'post_type'          =>  'product',
            'posts_per_page'    =>  1,
            'tax_query'   =>  [
                'relation'  =>  'AND',
                [
                    'taxonomy' => $context['term']->taxonomy,
                    'field'    => 'id',
                    'terms'    => $context['term']->ID,
                ],
                [
                    'taxonomy' => $t->taxonomy,
                    'field'    => 'id',
                    'terms'    => $t->ID,
                ],
            ],
        ];

        $maybe_posts_in_term = new WP_Query($args);

        if(is_a($maybe_posts_in_term, 'WP_Error'))
            return false;

        if(intval($maybe_posts_in_term->found_posts) < 1)
            return false;

        return true;
    });

    /**
     * setting type search
     */
    $context['setting_types'] = array_filter(Timber::get_terms('pa_setting', ['parent'=>0]), function($t) use($context){
        $args = [
            'post_type'          =>  'product',
            'posts_per_page'    =>  1,
            'tax_query'   =>  [
                'relation'  =>  'AND',
                [
                    'taxonomy' => $context['term']->taxonomy,
                    'field'    => 'id',
                    'terms'    => $context['term']->ID,
                ],
                [
                    'taxonomy' => $t->taxonomy,
                    'field'    => 'id',
                    'terms'    => $t->ID,
                ],
            ]
        ];

        $maybe_posts_in_term = new WP_Query($args);

        if(is_a($maybe_posts_in_term, 'WP_Error'))
            return false;

        if(intval($maybe_posts_in_term->found_posts) < 1)
            return false;

        return true;
    });

    /**
     *  Gem detail search
     */
    $context['gemstone_details'] = array_filter(Timber::get_terms('pa_gemstone-detail', ['parent'=>0]), function($t) use($context){
        $args = [
            'post_type'          =>  'product',
            'posts_per_page'    =>  1,
            'tax_query'   =>  [
                'relation'  =>  'AND',
                [
                    'taxonomy' => $context['term']->taxonomy,
                    'field'    => 'id',
                    'terms'    => $context['term']->ID,
                ],
                [
                    'taxonomy' => $t->taxonomy,
                    'field'    => 'id',
                    'terms'    => $t->ID,
                ],
            ]
        ];

        $maybe_posts_in_term = new WP_Query($args);

        if(is_a($maybe_posts_in_term, 'WP_Error'))
            return false;

        if(intval($maybe_posts_in_term->found_posts) < 1)
            return false;

        return true;
    });
}

if(isset($context['_GET']['filter_size'])){
    $args['tax_query'][] = [
        'taxonomy' => 'pa_size',
		'field'    => 'slug',
		'terms'    => $context['_GET']['filter_size'],
    ];
}
if(isset($context['_GET']['filter_metal'])){
    $args['tax_query'][] = [
        'taxonomy' => 'pa_metal',
        'field'    => 'slug',
        'terms'    => $context['_GET']['filter_metal'],
    ];
}

if(isset($context['_GET']['filter_setting'])){
    $args['tax_query'][] = [
        'taxonomy' => 'pa_setting',
        'field'    => 'slug',
        'terms'    => $context['_GET']['filter_setting'],
    ];
}

if(isset($context['_GET']['filter_gemstone'])){
    $args['tax_query'][] = [
        'taxonomy' => 'pa_gemstone-detail',
        'field'    => 'slug',
        'terms'    => $context['_GET']['filter_gemstone'],
    ];
}

if(isset($context['_GET']['min_price']) && isset($context['_GET']['max_price'])){
    $args['meta_query'] = array(
        'relation'  =>  'AND',
        array(
            'key' => '_price',
            'value' => array(intval($context['_GET']['min_price']), intval($context['_GET']['max_price'])),
            'compare' => 'BETWEEN',
            'type' => 'NUMERIC'
        )

    );
}






if(isset($context['_GET']['order']) && !empty($context['_GET']['order'])){
    $args['order']  = $context['_GET']['order'];
}

if(isset($context['_GET']['sort']) && !empty($context['_GET']['sort'])){
    $args['meta_key']  = $context['_GET']['sort'];
    $args['orderby']    = 'meta_value_num';
}



$context['products'] = Timber::get_posts($args,'Awesome_Product');


//query_posts($args);


//!Kint::dump($args, $context['products']); die();
$context['pagination'] = Timber::get_pagination();

//!Kint::dump($context['_GET']['min_price'], $context['_GET']['max_price']); die();


Timber::render('archive-product.twig', $context);