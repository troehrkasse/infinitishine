<?php
if (!defined('ABSPATH')) exit;

$context = Timber::get_context();
$context['page'] = Timber::get_post();
$context['show_sidebar'] = false;
$context['container'] = false;

$context['recent_posts'] = Timber::get_posts([
    'post_type' => 'post',
    'posts_per_page' => 4
]);

$context['slides'] = Timber::get_posts([
    'posts_type'    =>  'slide',
    'orderby'       => 'rand',
    'tax_query'     =>  [
        [
            'taxonomy' => 'placement',
            'field'    => 'slug',
            'terms'    => 'home',

        ]
    ]
], 'Awesome_Slide');



$context['featured'] = [
    'rings' => [
        'term' => new \Timber\Term(57),
        'posts' => Timber::get_posts([
            'posts_per_page' => 8,
            'post_type' => 'product',
            'post_status' => 'publish',
            'meta_key' => 'total_sales',
            'orderby' => 'meta_value_num',
            'no_found_rows' => true,
            'tax_query' => [
                [
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => 'rings',
                ],
            ]
        ], 'Awesome_Product'),
    ],
    'earrings' => [
        'term' => new \Timber\Term(53),
        'posts' => Timber::get_posts([
            'posts_per_page' => 6,
            'post_type' => 'product',
            'post_status' => 'publish',
            'meta_key' => 'total_sales',
            'orderby' => 'meta_value_num',
            'no_found_rows' => true,
            'tax_query' => [
                [
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => 'earrings',
                ],
            ]
        ], 'Awesome_Product'),
    ],
    'pendants' => [
        'term' => new \Timber\Term(56),
        'posts' => Timber::get_posts([
            'posts_per_page' => 6,
            'post_type' => 'product',
            'post_status' => 'publish',
            'no_found_rows' => true,
            'meta_key' => 'total_sales',
            'orderby' => 'meta_value_num',
            'tax_query' => [
                [
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => 'pendants',
                ],
            ]
        ], 'Awesome_Product')
    ]
];
//!Kint::dump($context['featured']); die();

$context['faqs'] = Timber::get_posts([
    'post_type' => 'faq',
    'posts_per_page' => '8',
    'orderby' => 'rand'
], 'Awesome_Faq');


Timber::render('pages/home.twig', $context);
//Timber::render('pages/home.twig', $context);