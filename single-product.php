<?php

if ( ! defined( 'ABSPATH' ) )  exit; //exit if access directly

//Because this file for called via a main woocommerce controller, 
//initial context and other woocommerce specific payloads have already been set

global $post, $product;




$context['container'] = false;
$context['show_sidebar'] = false;
$context['product'] = new Awesome_Product($post->ID);
//!Kint::dump($context['product']->content); die();

$context['popular_products'] = Timber::get_posts(
    [
        'post_type'             => 'product',
        'post_status'           => 'publish',
        'ignore_sticky_posts'   => 1,
        'posts_per_page'        => '9',
        'columns'               => '4',
        'fields'                => 'ids',
        'meta_key'              => 'total_sales',
        'orderby'               => 'meta_value_num',
        'meta_query'            => WC()->query->get_meta_query()
    ], 'Awesome_Product');

include('commentform.php');

$product = wc_get_product($post->ID);

$specs_to_get = array(
    'Diamond Weight',
    'Gem Weight',
    'Gemstone Detail',
    'Gross Weight',
    'Metal',
    'Metal Weight',
    'Setting'
);

$specifications = [];

foreach($specs_to_get as $spec){
    $val = get_the_terms($post, 'pa_' . strtolower(str_replace(' ', '-', $spec)));
    if($val){
        $specifications[$spec] = [
            'name'      =>  $spec,
            'content'   =>  $val[0]->name
        ];
    }
}

//!Kint::dump($specifications); die();

$context['specifications'] = $specifications;





$sizes = wc_get_product_terms($post->ID, 'pa_size');
if(sizeof($sizes) == 0){
    $context['sizes'] = $sizes;
}

Timber::render('single-product.twig', $context);