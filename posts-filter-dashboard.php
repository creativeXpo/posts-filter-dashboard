<?php
/**
 * Plugin Name: posts-filter-dashboard
 * Description: Demonstrates how to apply filters via query parameters in the admin area.
 * Version: 1.0
 * Author: Golam Kibria
 */

// Exit if accessed directly.

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Posts_Filter_Dashboard {

    /**
     * Constructor: Hook into admin menu.
     */
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
    }

    /**
     * Add custom admin menu page.
     */

    public function add_admin_menu() {
        add_menu_page(
            'Posts Filter Dashboard',
            'Posts Filter Dashboard',
            'manage_options',
            'posts-filter-dashboard',
            [ $this, 'render_admin_page' ],
            'dashicons-filter',
            20
        );
    }

    /**
     * Render the main admin page.
     */

    public function render_admin_page() {
        ?>
        <div class="wrap">
            <h1>Posts Filter Dashboard</h1>

            <form method="get">
                <input type="hidden" name="page" value="posts-filter-dashboard" />

                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="">All</option>
                    <option value="publish" <?php selected( $_GET['status'] ?? '', 'publish' ); ?>>Published</option>
                    <option value="draft" <?php selected( $_GET['status'] ?? '', 'draft' ); ?>>Draft</option>
                    <option value="pending" <?php selected( $_GET['status'] ?? '', 'pending' ); ?>>Pending</option>
                </select>

                <label for="author">Author ID:</label>
                <input 
                    type="number" 
                    name="author" 
                    id="author" 
                    value="<?php echo esc_attr( $_GET['author'] ?? '' ); ?>" 
                />

                <button class="button button-primary" type="submit">Filter</button>
            </form>

            <hr>

            <?php $this->display_posts_table(); ?>
        </div>
        <?php
    }

    /**
     * Build and execute the query, then display the results.
     */

    private function display_posts_table() {
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

        if ( $query->have_posts() ) {
            echo '<table class="widefat fixed striped">';
            echo '<thead><tr><th>Title</th><th>Status</th><th>Author</th></tr></thead><tbody>';

            while ( $query->have_posts() ) {
                $query->the_post();

                echo '<tr>';
                echo '<td><a href="' . esc_url( get_edit_post_link() ) . '">' . esc_html( get_the_title() ) . '</a></td>';
                echo '<td>' . esc_html( get_post_status() ) . '</td>';
                echo '<td>' . esc_html( get_the_author() ) . '</td>';
                echo '</tr>';
            }

            echo '</tbody></table>';
        } else {
            echo '<p>No posts found.</p>';
        }

        wp_reset_postdata();
    }
    
}

// Initialize the plugin.
new Posts_Filter_Dashboard();
