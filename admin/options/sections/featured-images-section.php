<?php
// Random Featured Image from the list
$post_counts = wp_count_posts( 'post' )->publish;
if (get_option('wdss_auto_featured_image', '0') && $post_counts > 1)
{


    function wdss_random_featured_image()
    {

        global $post;
        $polylang_default_lang = null;
        $polylang_current_lang = null;

        if (function_exists('pll_the_languages'))
        {
            $polylang_default_lang = pll_default_language();
            $polylang_current_lang = $polylang_default_lang === pll_current_language();
        }

        if (isset($post->ID))
        {
            // If post has no thumbnail
            if (!has_post_thumbnail($post->ID))
            {
                $media = get_attached_media('image', $post->ID);
                if(!$media || (function_exists('pll_the_languages') && $polylang_current_lang)) {
                    if (function_exists('rand_image_from_list')) {
                        rand_image_from_list($post->ID);
                    }
                }
            }
            // Polylang case
            elseif (function_exists('pll_the_languages') && !$polylang_current_lang)
            {
                $origin_post_id = pll_get_post($post->ID, $polylang_default_lang);

                if ($origin_post_id)
                {
                    $thumbnail_id = get_post_thumbnail_id($origin_post_id);
                    set_post_thumbnail($post->ID, $thumbnail_id);
                }
            }
        }
    }
    add_action('the_post', 'wdss_random_featured_image');

    add_action('publish_post', 'wdss_random_featured_image');
    add_action('save_post', 'wdss_random_featured_image');
    add_action('draft_to_publish', 'wdss_random_featured_image');
    add_action('new_to_publish', 'wdss_random_featured_image');
    add_action('pending_to_publish', 'wdss_random_featured_image');
    add_action('future_to_publish', 'wdss_random_featured_image');
}

if (get_option('wdss_featured_images_add_column', '0'))
{

    function wdss_add_images_size()
    {
        add_image_size('featured-column', 50, 50, true);
    }
    add_action('wp_loaded', 'wdss_add_images_size');

    add_action('wp_loaded', 'wdss_featured_image_column');
    function wdss_featured_image_column()
    {

        // Creates a new column
        add_filter('manage_post_posts_columns', 'add_image_column', 4);
        function add_image_column($columns)
        {
            $out = array();

            foreach ($columns as $col => $name)
            {
                $out['featured'] = 'Featured';
                $out[$col] = $name;
            }

            return $out;
        }

        // Fill in our column with data -  wp-admin/includes/class-wp-posts-list-table.php
        add_filter('manage_post_posts_custom_column', 'fill_images_column', 5, 2);
        function fill_images_column($colname, $post_id)
        {
            if ($colname === 'featured')
            {
                the_post_thumbnail('featured-column');
            }
        }

        // CSS Column width styling
        add_action('admin_head', 'add_images_column_css');
        function add_images_column_css()
        {
            if (get_current_screen()->base == 'edit') echo '<style type="text/css">
            .column-featured{width:3.5%;}
            @media screen and (max-width: 1600px) {
              .column-featured{width:4.5%;}
            }
            </style>';
        }
    }
}

