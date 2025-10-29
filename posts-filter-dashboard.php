<?php
/**
 * Plugin Name: Posts Filter Example
 * Description: Demonstrates how to apply filters via query parameters in the admin area.
 * Version: 1.0
 * Author: ChatGPT
 */

// Exit if accessed directly.

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Add admin menu page

add_action( 'admin_menu', function() {
    add_menu_page(
        'Posts Filter Example',
        'Posts Filter Example',
        'manage_options',
        'posts-filter-example',
        'pfe_render_admin_page',
        'dashicons-filter',
        20
    );
});

function pfe_render_admin_page() {
    ?>
    <div class="wrap">
        <h1>Posts Filter Example</h1>

        <form method="get">
            <input type="hidden" name="page" value="posts-filter-example" />

            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="">All</option>
                <option value="publish" <?php selected($_GET['status'] ?? '', 'publish'); ?>>Published</option>
                <option value="draft" <?php selected($_GET['status'] ?? '', 'draft'); ?>>Draft</option>
                <option value="pending" <?php selected($_GET['status'] ?? '', 'pending'); ?>>Pending</option>
            </select>

            <label for="author">Author ID:</label>
            <input type="number" name="author" id="author" value="<?php echo esc_attr($_GET['author'] ?? ''); ?>" />

            <button class="button button-primary" type="submit">Filter</button>
        </form>

        <hr>

        <?php

        // Build query arguments based on query parameters

        $args = [
            'post_type'      => 'post',
            'posts_per_page' => 10,
        ];

        if ( ! empty( $_GET['status'] ) ) {
            $args['post_status'] = sanitize_text_field( $_GET['status'] );
        }

        if ( ! empty( $_GET['author'] ) ) {
            $args['author'] = intval( $_GET['author'] );
        }

        $query = new WP_Query( $args );

        if ( $query->have_posts() ) :
            echo '<table class="widefat fixed striped">';
            echo '<thead><tr><th>Title</th><th>Status</th><th>Author</th></tr></thead><tbody>';
            while ( $query->have_posts() ) : $query->the_post();
                echo '<tr>';
                echo '<td><a href="' . get_edit_post_link() . '">' . get_the_title() . '</a></td>';
                echo '<td>' . get_post_status() . '</td>';
                echo '<td>' . get_the_author() . '</td>';
                echo '</tr>';
            endwhile;
            echo '</tbody></table>';
        else :
            echo '<p>No posts found.</p>';
        endif;

        wp_reset_postdata();
        ?>
    </div>

    <?php
}
