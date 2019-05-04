<?php
if ( ! defined( 'ABSPATH' ) )  exit; //exit if access directly

$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

$context = Timber::get_context();
$context['searched'] = urldecode( get_search_query() );
$context['show_sidebar'] = false;

$args = array(
    'paged'             =>  $paged,
    'posts_per_page'    =>  30,
    's'                 =>  get_search_query(),
    'post_type'         => array('product')
);
$context['posts'] = Timber::get_posts($args,'Awesome_Product');
query_posts($args);
$context['pagination'] = Timber::get_pagination();

Timber::render('search.twig', $context);