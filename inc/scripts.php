<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Load Scripts
 *
 * Enqueues the required scripts.
 *
 * @since 1.0
 * @return void
 */


function dmly_load_admin_scripts() {
  wp_enqueue_style( 'dmly_admin', plugins_url( 'deemly/assets/css/admin.css' ) );
  //wp_enqueue_script( 'dmly_admin', plugins_url('deemly/assets/js/admin.js' ) );
}
add_action('admin_enqueue_scripts', 'dmly_load_admin_scripts');


function dmly_load_frontend_scripts() {

  wp_enqueue_style( 'dmly', plugins_url( 'deemly/assets/css/dmly-widget.css' ) );
  //wp_enqueue_script( 'frontend', plugins_url( 'really-simple-responsive-image-slider/js/frontend.js' ), array('jquery') );
}
add_action('wp_enqueue_scripts', 'dmly_load_frontend_scripts');