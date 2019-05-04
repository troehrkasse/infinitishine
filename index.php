<?php
    if ( ! defined( 'ABSPATH' ) )  exit; //exit if access directly
    
    $context = Timber::get_context();
    
    if( is_front_page() ){
        include('front-page.php');
        
        return;
    }
    
    if(is_home()){
        //$context['show_sidebar'] = false;
        $context['posts'] = Timber::get_posts();
        $context['pagination'] = Timber::get_pagination();
        
        Timber::render('pages/index.twig', $context);
    }
    
?>