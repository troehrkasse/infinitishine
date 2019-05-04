<?php

if ( ! defined( 'ABSPATH' ) )  exit; //exit if access directly

$context = Timber::get_context();
$context['sidebar']  = Timber::get_sidebar('sidebar.php');

$new_comment_title = 'Be the first to leave a comment';
$comment_reply_title = 'Leave a comment';
include('commentform.php');

Timber::render('single.twig', $context);