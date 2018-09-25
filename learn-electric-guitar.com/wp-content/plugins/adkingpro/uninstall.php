<?php

global $wpdb;
include "includes/admin_area.php";
if ( ! current_user_can( 'activate_plugins' ) ) {
    return;
}
check_admin_referer( 'bulk-plugins' );

if (get_option('akp_clear_on_delete') == 1) {

    new AKP_Admin("unregister_options");
    new AKP_Admin("delete_options");
    
    // Unregister AKP capabilities to all users
    $role = get_role( 'subscriber' );
    $role->remove_cap( 'akp_edit_one' ); 

    $role = get_role( 'contributor' );
    $role->remove_cap( 'akp_edit_one' ); 
    $role->remove_cap( 'akp_edit_two' );

    $role = get_role( 'author' );
    $role->remove_cap( 'akp_edit_one' ); 
    $role->remove_cap( 'akp_edit_two' );
    $role->remove_cap( 'akp_edit_three' );

    $role = get_role( 'editor' );
    $role->remove_cap( 'akp_edit_one' ); 
    $role->remove_cap( 'akp_edit_two' );
    $role->remove_cap( 'akp_edit_three' );
    $role->remove_cap( 'akp_edit_four' );

    $role = get_role( 'administrator' );
    $role->remove_cap( 'akp_edit_one' ); 
    $role->remove_cap( 'akp_edit_two' );
    $role->remove_cap( 'akp_edit_three' );
    $role->remove_cap( 'akp_edit_four' );
    $role->remove_cap( 'akp_edit_five' );
    
    $table_name = $wpdb->prefix . "term_taxonomy";
    $sql = "SELECT * FROM $table_name WHERE taxonomy = 'advert_types'";
    $taxonomy_terms = $wpdb->get_results($sql);
    if (!empty($taxonomy_terms)) {
        foreach ($taxonomy_terms as $term) {
            $table_name = $wpdb->prefix . "terms";
            $sql = "DELETE FROM $table_name WHERE term_id = '{$term->term_id}'";
            $wpdb->query($sql);
        }
    }

    $table_name = $wpdb->prefix . "term_taxonomy";
    $sql = "DELETE FROM $table_name WHERE taxonomy = 'advert_types'";
    $wpdb->query($sql);

    $table_name = $wpdb->prefix . "posts";
    $sql = "DELETE FROM $table_name WHERE post_type = 'adverts_posts'";
    $wpdb->query($sql);
}