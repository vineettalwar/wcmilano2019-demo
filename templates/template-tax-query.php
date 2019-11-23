<?php
/**
 * Template Name: Page::Tax
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */


$arg = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 10,
    'orderby' => 'rand',
    'order' => 'DESC',
    'ep_integrate' => true,
    /*
     'tax_query' => array(
         'relation' => 'AND',
         array(
             'taxonomy' => 'category',
             'field' => 'slug',
             'terms' => array('hot'),
             'operator' => 'IN'
         ),
         array(
             'taxonomy' => 'tag',
             'field' => 'slug',
             'terms' => array('shipping-free'),
             'operator' => 'IN'
         ),
     ) */
);

$query = new WP_Query($arg);
$queried_posts = wp_list_pluck($query->posts, 'ID');
//print_r($queried_posts);
get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

            <?php

            if (!empty($queried_posts)) {
                foreach ($queried_posts as $single) {
                    $post = get_post($single);
                    ?>
                    <article
                            id="post-<?php echo esc_attr($post->ID); ?>" <?php post_class('twentyseventeen-panel '); ?> >

                        <?php
                        if (has_post_thumbnail($post->ID)) {
                            $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'twentyseventeen-featured-image');

                            // Calculate aspect ratio: h / w * 100%.
                            $ratio = $thumbnail[2] / $thumbnail[1] * 100;
                            ?>

                            <div class="panel-image"
                                 style="background-image: url(<?php echo esc_url($thumbnail[0]); ?>);">
                                <div class="panel-image-prop"
                                     style="padding-top: <?php echo esc_attr($ratio); ?>%"></div>
                            </div><!-- .panel-image -->

                        <?php } ?>

                        <div class="panel-content">
                            <div class="wrap">
                                <header class="entry-header">
                                    <h2 class="entry-title">
                                        <?php echo esc_html($post->post_title); ?>
                                    </h2>
                                    <?php
                                    ?>
                                    <h4 class="taxonomies category">
                                        <?php echo get_the_term_list($post->ID, 'category', 'Categories: ', ', '); ?>
                                    </h4>

                                    <?php
                                    if (has_term('', 'tag')) {
                                        ?>
                                        <h4 class="taxonomies tag">
                                            <?php echo get_the_term_list($post->ID, 'tag', 'Tags: ', ', '); ?>
                                        </h4>
                                        <?php
                                    } ?>
                                </header><!-- .entry-header -->

                                <div class="entry-content">
                                    <?php
                                    echo wp_trim_words( $post->post_content, 250, '...' );
                                    ?>
                                </div><!-- .entry-content -->

                            </div><!-- .wrap -->
                        </div><!-- .panel-content -->

                    </article><!-- #post-<?php esc_attr($post->ID); ?>-->

                    <?php
                }
            } else {
                get_template_part('template-parts/post/content', 'none');
            }
            ?>

            <?php
            // Get each of our panels and show the post data.
            if (0 !== twentyseventeen_panel_count() || is_customize_preview()) : // If we have pages to show.

                /**
                 * Filter number of front page sections in Twenty Seventeen.
                 *
                 * @param int $num_sections Number of front page sections.
                 * @since Twenty Seventeen 1.0
                 *
                 */
                $num_sections = apply_filters('twentyseventeen_front_page_sections', 4);
                global $twentyseventeencounter;

                // Create a setting and control for each of the sections available in the theme.
                for ($i = 1; $i < (1 + $num_sections); $i++) {
                    $twentyseventeencounter = $i;
                    twentyseventeen_front_page_section(null, $i);
                }

            endif; // The if ( 0 !== twentyseventeen_panel_count() ) ends here.
            ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
