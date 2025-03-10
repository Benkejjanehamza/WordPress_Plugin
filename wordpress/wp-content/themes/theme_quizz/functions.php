<?php
// Charger le fichier CSS
function theme_quizz_enqueue_styles() {
    wp_enqueue_style('theme_quizz-style', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'theme_quizz_enqueue_styles');

require_once get_template_directory() . '/form-handler.php';
function create_response_series_post_type() {
    register_post_type('response_series',
        array(
            'labels' => array(
                'name' => __('Response Series'),
                'singular_name' => __('Response Series')
            ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => array('slug' => 'response_series'),
            'query_var' => true,
            'supports' => array(
                'title',
                'editor',
                'custom-fields'
            )
        )
    );
}
add_action('init', 'create_response_series_post_type');
