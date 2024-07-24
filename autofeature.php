<?php
/*
Plugin Name: Auto Featured Image
Description: Automatically sets the first image attached to a post as the featured image.
Author: Pixelvise
Author URI: https://pixelvise.com
Version: 1.0
*/

function prefix_auto_featured_image() {
    global $post;
    if (!has_post_thumbnail($post->ID)) {
        $attached_image = get_children( array(
            'post_parent' => $post->ID,
            'post_type'   => 'attachment',
            'post_mime_type' => 'image',
            'numberposts' => 1,
        ) );

        if ($attached_image) {
            foreach ($attached_image as $attachment_id => $attachment) {
                set_post_thumbnail($post->ID, $attachment_id);
                break; // Only set the first image
            }
        }
    }
}

add_action('the_post', 'prefix_auto_featured_image');
add_action('save_post', 'prefix_auto_featured_image');
add_action('draft_to_publish', 'prefix_auto_featured_image');
add_action('new_to_publish', 'prefix_auto_featured_image');
add_action('pending_to_publish', 'prefix_auto_featured_image');
add_action('future_to_publish', 'prefix_auto_featured_image');
?>
