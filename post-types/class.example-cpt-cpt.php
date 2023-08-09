<?php

if (!class_exists('Example_CPT_Post_Type')) {
    class Example_CPT_Post_Type {
        public function __construct() {
            add_action('init', array($this, 'create_post_type'));
            add_action('add_meta_boxes', array($this, 'add_custom_meta_box'));
            add_action('save_post', array($this, 'save_custom_meta'));
            add_action('rest_api_init', array($this, 'add_custom_meta_to_api'));
        }

        public function create_post_type() {
            $labels = array(
                'name'                  => _x('Example CPTs', 'Post Type General Name', 'text_domain'),
                'singular_name'         => _x('Example CPT', 'Post Type Singular Name', 'text_domain'),
                'menu_name'             => __('Example Post Types', 'text_domain'),
                'name_admin_bar'        => __( 'Post Type', 'text_domain' ),
                    'archives'              => __( 'Item Archives', 'text_domain' ),
                    'attributes'            => __( 'Item Attributes', 'text_domain' ),
                    'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
                    'all_items'             => __( 'All Items', 'text_domain' ),
                    'add_new_item'          => __( 'Add New Item', 'text_domain' ),
                    'add_new'               => __( 'Add New', 'text_domain' ),
                    'new_item'              => __( 'New Item', 'text_domain' ),
                    'edit_item'             => __( 'Edit Item', 'text_domain' ),
                    'update_item'           => __( 'Update Item', 'text_domain' ),
                    'view_item'             => __( 'View Item', 'text_domain' ),
                    'view_items'            => __( 'View Items', 'text_domain' ),
                    'search_items'          => __( 'Search Item', 'text_domain' ),
                    'not_found'             => __( 'Not found', 'text_domain' ),
                    'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
                    'featured_image'        => __( 'Featured Image', 'text_domain' ),
                    'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
                    'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
                    'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
                    'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
                    'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
                    'items_list'            => __( 'Items list', 'text_domain' ),
                    'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
                    'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
            );

            $args = array(
                'label'                 => __('example_cpt', 'text_domain'),
                'description'           => __('This is an example custom post type', 'text_domain'),
                'labels'                => $labels,
                'supports'              => array('title', 'editor'),
                'taxonomies'            => array('category', 'post_tag'),
                'hierarchical'          => true,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_position'         => 5,
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => true,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'query_var'             => 'example_cpt', // Change 'post_type' to 'example_cpt'
                'capability_type'       => 'post',
                'show_in_rest'          => true,
            );

            register_post_type('example_cpt', $args);
        }

        public function add_custom_meta_box() {
            add_meta_box('example_meta_box', 'Example Meta Box', array($this, 'render_meta_box'), 'example_cpt', 'normal', 'high');
        }

        public function render_meta_box($post) {
            $meta_value = get_post_meta($post->ID, 'example_meta', true);
            echo '<label for="example_meta">Example Meta:</label>';
            echo '<input type="text" id="example_meta" name="example_meta" value="' . esc_attr($meta_value) . '">';
        }

        public function save_custom_meta($post_id) {
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
            if (!current_user_can('edit_post', $post_id)) return;

            if (isset($_POST['example_meta'])) {
                update_post_meta($post_id, 'example_meta', sanitize_text_field($_POST['example_meta']));
            }
        }

        public function add_custom_meta_to_api() {
            register_rest_field('example_cpt', 'example_meta', array(
                'get_callback' => array($this, 'get_custom_meta_field'),
                'schema' => null,
            ));
        }

        public function get_custom_meta_field($object) {
            $meta_value = get_post_meta($object['id'], 'example_meta', true);
            return $meta_value;
        }
    }
}

new Example_CPT_Post_Type(); // Instantiate the class
