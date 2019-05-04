<?php
if ( ! defined( 'ABSPATH' ) )  exit; //exit if access directly

$context = Timber::get_context(); 
$context['sidebar']  = Timber::get_sidebar('sidebar-shop.php');

if(is_singular('product')){ 
    require('single-product.php');
}else{
    require('archive-product.php'); //Kint::dump($context); die();
}