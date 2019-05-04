<?php
/*
$commenter = wp_get_current_commenter();

$args = array(
    'title_reply'=>$new_comment_title ? $new_comment_title : 'Be the first to leave a review', 
    'label_submit'=>'Post Review',
    'fields' => apply_filters( 'comment_form_default_fields', array(
        'rating' => 
        '<label for="rating">'. __( 'Rating', 'vigoshop' ) . '</label>'.
        '<input type="hidden" name="rating" id="rating">',

        'author' =>
        '<p class="comment-form-author">' .
        '<label for="author">' . __( 'Name', 'vigoshop' ) . '<span class="required">*</span>'.'</label> ' .
        '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
        '" size="30"' . ' /></p>',

        'email' =>
        '<p class="comment-form-email"><label for="email">' . __( 'Email', 'vigoshop' ) . '<span class="required">*</span>'.'</label> ' .
        '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
        '" size="30"' . ' /></p>',

        'url' =>
        '<p class="comment-form-url"><label for="url">' .
        __( 'Website', 'vigoshop' ) . '</label>' .
        '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
        '" size="30" /></p>'
    )),
  'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>'
);

global $post;
if (get_comments_number($post) >= 1){
    $args['title_reply'] = $comment_reply_title ? $comment_reply_title : "Leave a Review";
}

function get_extra_fields():Array{
    $commenter = wp_get_current_commenter();
    
    $fields = [
        'author' =>
        '<p class="comment-form-author">' .
        '<label for="author">' . __( 'Name', 'vigoshop' ) . '<span class="required">*</span>'.'</label> ' .
        '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
        '" size="30"' . ' /></p>',
        
        'email' =>
        '<p class="comment-form-email"><label for="email">' . __( 'Email', 'vigoshop' ) . '<span class="required">*</span>'.'</label> ' .
        '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
        '" size="30"' . ' /></p>',
    ];
    
    if(get_post_type() == 'product'){
        $fields['rating'] = 
        '<label for="rating">'. __( 'Rating', 'vigoshop' ) . '</label>'.
        '<input type="hidden" name="rating" id="rating">';
    }
    
    return $fields;
}

function add_comment_fields($fields) {
    $fields = array_merge($fields, get_extra_fields());

    return $fields;
}

function add_comment_fields_logged_in() {
    if (!is_user_logged_in())
        return;

    $fields = get_extra_fields();

    foreach ( $fields as $name => $field ) {
        echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
    }
}

add_filter('comment_form_logged_in_after', 'add_comment_fields_logged_in');


*/




add_action('comment_form_logged_in_after', function(){
   if (!is_user_logged_in())
        return;

    $fields['rating'] = 
        '<label for="rating">'. __( 'Rating', 'vigoshop' ) . '</label>'.
        '<input type="hidden" name="rating" id="rating">';

    foreach ( $fields as $name => $field ) {
        echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
    }
});


$commenter = wp_get_current_commenter();
$req = get_option( 'require_name_email' );
$aria_req = ( $req ? " aria-required='true'" : '' );
$required_text = '';

$fields =  [
  'author' =>
    '<p class="comment-form-author"><label for="author">' . __( 'Name', 'cat' ) . '</label> ' .
    ( $req ? '<span class="required">*</span>' : '' ) .
    '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
    '" size="30"' . $aria_req . ' /></p>',

  'email' =>
    '<p class="comment-form-email"><label for="email">' . __( 'Email (Your email address will not be published.)', 'cat' ) . '</label> ' .
    ( $req ? '<span class="required">*</span>' : '' ) .
    '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
    '" size="30"' . $aria_req . ' /></p>'
];

if(get_post_type() == 'product'){
    $fields['rating'] = 
    '<label for="rating">'. __( 'Rating', 'vigoshop' ) . '</label>'.
    '<input type="hidden" name="rating" id="rating">';
}


$new_comment_title = isset($new_comment_title) ? $new_comment_title : 'Be the first to leave a review';
$comment_reply_title = isset($comment_reply_title) ? $comment_reply_title : 'Leave a Review';
$args = array(
  'id_form'             => 'commentform',
  'class_form'          => 'comment-form',
  'id_submit'           => 'submit',
  'class_submit'        => 'ml-0 submit btn btn-primary',
  'name_submit'         => 'submit',
  'title_reply'         => __( wp_count_comments(get_the_ID())->approved > 0 ? $comment_reply_title: $new_comment_title),
  'title_reply_to'      => __( 'Leave a Reply to %s' ),
  'cancel_reply_link'   => __( 'Cancel Reply' ),
  'label_submit'        => __( 'Post Comment' ),
  'format'              => 'xhtml',

  'comment_field' =>  '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) .
    '</label><textarea id="awesomeCommentsMDE" name="comment" cols="45" rows="8" aria-required="true">' .
    '</textarea></p>',

  'must_log_in' => '<p class="must-log-in">' .
    sprintf(
      __( 'You must be <a href="%s">logged in</a> to post a comment.' ),
      wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
    ) . '</p>',

  'comment_notes_before' => '<p class="comment-notes">' .
    __( '' ) . ( $req ? $required_text : '' ) .
    '</p>',

  'comment_notes_after' => '<p class="form-allowed-tags"></p>',

  'fields' => apply_filters( 'comment_form_default_fields', $fields ),
);


$context['comment_form'] = TimberHelper::ob_function(function() use ($args){comment_form($args);});