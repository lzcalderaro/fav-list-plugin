<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
/*
* Plugin name: LZ Favorite Post
* Description: Favoritar Posts.
* Version: 1.0
* Author: Luiz Calderaro
*/

require dirname(__FILE__).'/class/functions.php';
require dirname(__FILE__).'/widget/wg-fav.php';

add_filter( 'the_content', array('\FavListEngine\FavEngine', 'addFavButton'));

add_action('wp_ajax_list_fav', array('\FavListEngine\FavEngine', 'managerFavoriteList'));
add_action('wp_ajax_nopriv_list_fav', array('\FavListEngine\FavEngine', 'managerFavoriteList'));

add_action('wp_ajax_get_fav_list', array('\FavListEngine\FavEngine', 'generateFavoriteList'));
add_action('wp_ajax_nopriv_get_fav_list', array('\FavListEngine\FavEngine', 'generateFavoriteList'));

add_action('wp_ajax_get_state_button', array('\FavListEngine\FavEngine', 'setButtonState'));
add_action('wp_ajax_nopriv_get_state_button', array('\FavListEngine\FavEngine', 'setButtonState'));

add_action( 'widgets_init', 'fav_sidebar' );

add_shortcode('log-favorites', array('\FavListEngine\FavEngine', 'generateShortcode'));


if(!is_admin()) wp_enqueue_script( 'action-log-favorites', plugin_dir_url( __FILE__ ) . '/js/calls.js', array( 'jquery' ), '0.1' );