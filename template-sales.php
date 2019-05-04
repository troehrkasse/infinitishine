<?php
/**
 * Template Name: Jewelry Sales
 *
 * @package WordPress
 * @subpackage Reflex
 * @since Reflex 1.0
 */


if (!defined('ABSPATH')) exit; //exit if access directly

$context = Timber::get_context();
$context['sidebar'] = Timber::get_sidebar('sidebar-shop.php');

$paged = get_query_var('paged', 1);

$args = [
    'post_type' => 'product',
    'paged' => $paged,
    'posts_per_page' => 30,
    //'orderby'     =>  'rand',
    'meta_query' => array(
        'relation' => 'OR',
        [ // Simple products type
            'key' => '_sale_price',
            'value' => 0,
            'compare' => '>',
            'type' => 'numeric'
        ],
        [ // Variable products type
            'key' => '_min_variation_sale_price',
            'value' => 0,
            'compare' => '>',
            'type' => 'numeric'
        ]
    ),
    'tax_query' => [],
];

$terms = get_the_terms(get_the_ID(), 'product_cat');
$options = infinitishine::get_options();

$context['product_types'] = array_filter($terms, function ($t) {
    $args = [
        'post_typ' => 'product',
        'posts_per_page' => 1,
        'meta_query' => array(
            'relation' => 'OR',
            [ // Simple products type
                'key' => '_sale_price',
                'value' => 0,
                'compare' => '>',
                'type' => 'numeric'
            ],
            [ // Variable products type
                'key' => '_min_variation_sale_price',
                'value' => 0,
                'compare' => '>',
                'type' => 'numeric'
            ]
        ),
        'tax_query' => [
            [
                'taxonomy' => $t->taxonomy,
                'field' => 'id',
                'terms' => $t->term_id,
            ],
        ]
    ];

    $maybe_posts_in_term = new WP_Query($args);

    if (is_a($maybe_posts_in_term, 'WP_Error'))
        return false;

    if (intval($maybe_posts_in_term->found_posts) < 1)
        return false;

    return true;
});
$context['product_types_append'] = 'on sale';

if (isset($context['_GET']['product-type'])) {
    $args['tax_query'][] = [
        'taxonomy' => 'product_cat',
        'field' => 'slug',
        'terms' => [$context['_GET']['product-type']],
    ];
    if (
        isset($options['accessories_cat']) &&
        $context['_GET']['product-type'] == $options['accessories_cat']->slug &&
        isset($options['accessories_posts_per_page'])
    ) {
        $posts_per_page = $options['accessories_posts_per_page'];
    }
} else {
    if (is_array($terms) && !empty($terms)) {
        $args['tax_query'] = array_map(function ($t) {
            return [
                'taxonomy' => $t->taxonomy,
                'field' => 'term_id',
                'terms' => [$t->term_id],
            ];
        }, $terms);

        $args['tax_query']['relation'] = 'OR';
    }
}

if (isset($context['_GET']['order']) && !empty($context['_GET']['order'])) {
    $args['order'] = $context['_GET']['order'];
}

if (isset($context['_GET']['sort']) && !empty($context['_GET']['sort'])) {
    $args['meta_key'] = $context['_GET']['sort'];
    $args['orderby'] = 'meta_value_num';
}

$context['products'] = Timber::get_posts($args, 'Awesome_Product');

query_posts($args);
$context['pagination'] = Timber::get_pagination();

$context['term'] = new class
{
    public function link($raw = true)
    {
        return get_the_permalink();
    }
};
Timber::render('archive-product.twig', $context);