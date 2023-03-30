<?php

if ( ! function_exists( 'le_pays_theme_support' ) ) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * @since My theme name 1.0
     *
     * @return void
     */
    function le_pays_theme_support() {

        // Add support for block styles.
        add_theme_support( 'wp-block-styles' );

        // Enqueue editor styles.
        add_editor_style( 'style.css' );

    }

endif;
add_action( 'after_setup_theme', 'le_pays_theme_support' );


/*-----------------------------------------------------------------
Enqueue Styles
-----------------------------------------------------------------*/

if ( ! function_exists( 'le_pays_styles' ) ) :

    function le_pays_styles() {

        // Register Bootstrap Style & Scripts
        wp_register_style('bootstrap-style', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css');
        wp_register_script('bootstrap-script', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js',
            array(), '0.1', true);

        // Enqueue our styles and scripts
        wp_enqueue_style('bootstrap-style');
        wp_enqueue_script('bootstrap-script');
        wp_enqueue_style('le_pays_style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));

    }

endif;

add_action( 'wp_enqueue_scripts', 'le_pays_styles' );