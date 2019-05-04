<?php
/**
* Template Name: Taxonomy Landing Page
*
* @package WordPress
* @since 1.0
*/

if ( ! defined( 'ABSPATH' ) )  exit; //exit if access directly
$context = Timber::get_context();
$context['show_sidebar'] = false;
$context['post'] = \Timber::get_post();
$sort_alphabetically_prop = infinitishine::get_meta_prefix() . 'sort_alphabetically';
$taxonomy_terms_prop = infinitishine::get_meta_prefix() . 'taxonomy_terms';

if(is_array($context['post']->{$taxonomy_terms_prop})){
    $context['terms'] = array_map(function($term_id){
            $term =  new \Timber\Term($term_id);
            $term->thumbnail = new \Timber\Image($term->meta('thumbnail_id'));

            return $term;
        },$context['post']->{$taxonomy_terms_prop});

    if($context['post']->{$sort_alphabetically_prop} == 'on'):
        /**
         * Sort terms alphabetically by name
         */
        usort($context['terms'], function($a, $b){
            return strcmp($a->name, $b->name);
        });
    endif;
}

Timber::render('template-taxonomy-landing-page.twig', $context);