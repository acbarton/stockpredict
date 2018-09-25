<?php

/*
    Plugin Name: Ad King Pro
    Plugin URI: http://kingpro.me/plugins/ad-king-pro/
    Description: Ad King Pro allows you to manage, display and track all of your custom advertising on your wordpress site.
    Version: 2.0.1
    Author: Ash Durham
    Author URI: http://durham.net.au/
    License: GPL2
    Text Domain: akptext

    Copyright 2016  Ash Durham  (email : plugins@kingpro.me)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if( !class_exists( 'AdKingPro' ) ) {
    class AdKingPro {

        function __construct() {
            register_activation_hook(__FILE__,array(&$this, 'install'));
            register_deactivation_hook(__FILE__,array(&$this, 'deactivate'));
            
            add_action('plugins_loaded', array(&$this, 'languages_init'));
            
            add_filter('plugin_action_links',array(&$this, 'settings_link'),10,2);
        }

        function install() {
            if ( ! current_user_can( 'activate_plugins' ) )
                return;

            global $wpdb;
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

            $table_terms = $wpdb->prefix . "terms";
            $table_tax = $wpdb->prefix . "term_taxonomy";
            
            $exists = $wpdb->get_results( "SELECT * FROM $table_tax WHERE taxonomy = 'advert_types'", OBJECT );
            
            if (empty($exists)) {
                $sql = "INSERT INTO $table_terms 
                 (`name`, `slug`, `term_group`)
                 VALUES ('Sidebar', 'sidebar', '0')";
                dbDelta($sql);

                $term_id = $wpdb->insert_id;
                $sql = "INSERT INTO $table_tax 
                 (`term_id`, `taxonomy`, `description`, `parent`, `count`)
                 VALUES ('".$term_id."', 'advert_types', '', '0', '0')";
                dbDelta($sql);
            }

            // Register AKP capabilities to all users
            $role = get_role( 'subscriber' );
            $role->add_cap( 'akp_edit_one' ); 

            $role = get_role( 'contributor' );
            $role->add_cap( 'akp_edit_one' ); 
            $role->add_cap( 'akp_edit_two' );

            $role = get_role( 'author' );
            $role->add_cap( 'akp_edit_one' ); 
            $role->add_cap( 'akp_edit_two' );
            $role->add_cap( 'akp_edit_three' );

            $role = get_role( 'editor' );
            $role->add_cap( 'akp_edit_one' ); 
            $role->add_cap( 'akp_edit_two' );
            $role->add_cap( 'akp_edit_three' );
            $role->add_cap( 'akp_edit_four' );

            $role = get_role( 'administrator' );
            $role->add_cap( 'akp_edit_one' ); 
            $role->add_cap( 'akp_edit_two' );
            $role->add_cap( 'akp_edit_three' );
            $role->add_cap( 'akp_edit_four' );
            $role->add_cap( 'akp_edit_five' );
            
            $user = new WP_User();
            $user->get_role_caps();
        }
        
        function deactivate() {
            if ( ! current_user_can( 'activate_plugins' ) )
                return;
            $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
            check_admin_referer( "deactivate-plugin_{$plugin}" );
        }
        
        function languages_init() {
            load_plugin_textdomain('akptext', false, basename( dirname( __FILE__ ) ) . '/languages' );
        }
        
        function settings_link($action_links,$plugin_file){
            if($plugin_file==plugin_basename(__FILE__)){
                    $akp_settings_link = '<a href="admin.php?page=' . dirname(plugin_basename(__FILE__)) . '">' . __("Settings", 'akptext') . '</a>';
                    array_unshift($action_links,$akp_settings_link);
            }
            return $action_links;
        }
    }
}

new AdKingPro();
require_once plugin_dir_path(__FILE__).'includes/widget.php';
require_once plugin_dir_path(__FILE__).'includes/admin_area.php';
require_once plugin_dir_path(__FILE__).'includes/output.php';
require_once plugin_dir_path(__FILE__).'js/adkingpro-js.php';