<?php
    if ( ! defined( 'ABSPATH' ) )  exit;

    $context = Timber::get_context();
    $context['show_sidebar'] = false;
    //$context['container'] = false;
    
    Timber::render('pages/page.twig', $context);