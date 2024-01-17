<?php
/*
Plugin Name: CPT API
Plugin URI: https://github.com/hopelight24/WP-CPT-API
Description: Object Oriented Programming base  wordpress custom cpt and api plugin  built for  Travelopia
Author: Sazzad mahmud
Version: 1.0.0
Author URI: https://hopelight24.github.io
*/
if (!defined('WPINC')) {
    die;
}

define('TM_CPT_PLUGIN_DIR', trailingslashit(dirname(__FILE__)));

require plugin_dir_path(__FILE__) . 'includes/class-character-cpt.php';
require plugin_dir_path(__FILE__) . 'includes/class-post-type-register.php';
require plugin_dir_path(__FILE__) . 'includes/class-cpt-metaboxes.php';
require plugin_dir_path(__FILE__) . 'includes/class-cpt-api.php';

$cpt_register = new CharacterRegister;
$cpt_register->init();



$post_type = new Character($cpt_register);
register_activation_hook(__FILE__, array($post_type, 'activate'));


$metaboxes = new CharacterMetaboxes;
$metaboxes->init();

$metaboxes = new CharacterAPI;
$metaboxes->init();



