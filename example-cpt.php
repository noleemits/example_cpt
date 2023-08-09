<?php

/**
 * Plugin Name: Example CPT
 * Plugin URI: https://www.wordpress.com/example-cpt
 * Version: 1.0
 * Requires at least: 5.6
 * Author: Lee Hernandez
 * Author URI: https://www.leehernandez.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/license/gpl-2.0.html
 */


 if( ! defined('ABSPATH')){
    exit;
 }

 if(! class_exists('Example_CPT')){
    class Example_CPT{
    function __construct()
       {
        $this->define_constants();
        require_once(EXAPMLE_CPT_PATH . 'post-types/class.example-cpt-cpt.php');
        $Example_Cpt_Post_Type = new  Example_Cpt_Post_Type();

       }
               //define constants
               public function define_constants(){
                  define('EXAPMLE_CPT_PATH', plugin_dir_path(__FILE__));
                  define('EXAPMLE_CPT_URL', plugin_dir_url(__FILE__));
                  define('EXAPMLE_VERSION', '1.0.0');
               }
               //activation hooks
               public static function activate(){
                     update_option('rewrite_rules', '');
               }
               public static function deactivate(){
                    flush_rewrite_rules();
               }
               public static function uninstall(){

               }
    }
 }

 if(class_exists('Example_CPT')){
    register_activation_hook(__FILE__, array('Example_CPT', 'activate'));
    register_deactivation_hook(__FILE__, array('Example_CPT', 'deactivate'));
    register_uninstall_hook(__FILE__, array('Example_CPT', 'uninstall'));
    $example_cpt =  new Example_CPT();
 }
