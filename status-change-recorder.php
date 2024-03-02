<?php
/**
 * Plugin Name: Status Change Recorder
 * Description: A custom plugin to record information about when an post or event's status changes.
 * Version: 1.0.0
 * Author: Vic (from ChatGPT 4)
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

function save_new_status( $new_status, $old_status, $post ) {
    /* We act when of of the post types we care about transitions to a new status */
    if ( ($post->post_type == 'tribe_events' ||
          $post->post_type == 'tribe_organizer' ||
          $post->post_type == 'tribe_venue' ||
          $post->post_type == 'post')
      && $old_status !== $new_status) {

        $current_user = wp_get_current_user();
        $current_timestamp = current_time( 'mysql' ); // Get the current timestamp in MySQL format

        if (false) {
            /* Method using separate meta keys for user and timestamp */
            add_post_meta( $post->ID, '_new_status_user', $current_user->ID );
            add_post_meta( $post->ID, '_new_status_when', $current_timestamp );
            add_post_meta( $post->ID, '_new_status_status', $new_status );
        }

        if (true) {
            /* Method using a single meta key for user and timestamp */
            $data = join("|", array($current_timestamp, $current_user->ID, $new_status));
            add_post_meta( $post->ID, '_new_status_data', $data );
        }
    }
}
add_action( 'transition_post_status', 'save_new_status', 10, 3 );
