<?php

// Lazt DMCA Script
if (get_option('wdss_lazy_dmca', '0'))
{
    add_action('wp_enqueue_scripts', 'wdss_dmca_enqueue');
    function wdss_dmca_enqueue()
    {
        wp_enqueue_script('dmca-lazy', plugin_dir_url(__FILE__) . '../inc/dmca-lazy/index.js', array() , WD_SATELLITES_SNIPPETS_VERSION, true);
    }
}

// Async Google Tag Manager
if (get_option('wdss_gtm_id', '') !== '')
{
    add_action('wp_enqueue_scripts', 'wdss_gtm_enqueue');
    function wdss_gtm_enqueue()
    {
        wp_enqueue_script('gtm-lazy', plugin_dir_url(__FILE__) . '../inc/gtm-lazy/index.js', array() , WD_SATELLITES_SNIPPETS_VERSION, true);
        $wdss_localize_gtm_script = ['id' => get_option('wdss_gtm_id') , ];
        wp_localize_script('gtm-lazy', 'wdss_gtm', $wdss_localize_gtm_script);
    }
}

// Lazy Google Recaptcha
if (get_option('wdss_recaptcha_site_code', '') !== '')
{

    add_action('wp_enqueue_scripts', 'wdss_recaptcha_enqueue');
    function wdss_recaptcha_enqueue()
    {
        if (is_single())
        {
            wp_enqueue_script('recaptcha-lazy', plugin_dir_url(__FILE__) . '../inc/recaptcha-lazy/index.js', array() , WD_SATELLITES_SNIPPETS_VERSION, true);
        }
    }

    /* Add Google recaptcha to WordPress comment box */
    function add_google_recaptcha($submit_field)
    {
        $site_key = get_option('wdss_recaptcha_site_code', '');
        $submit_field['submit_field'] = "<div style='display:block; margin-bottom: 25px;' class='g-recaptcha' data-sitekey='$site_key'></div><br>" . $submit_field['submit_field'];
        return $submit_field;
    }
    if (!is_user_logged_in())
    {
        add_filter('comment_form_defaults', 'add_google_recaptcha');
    }

    /** Google recaptcha check, validate and catch the spammer */
    function is_valid_captcha($captcha)
    {
        $secret = get_option('wdss_recaptcha_secret_key', '');
        $captcha_postdata = http_build_query(array(
            'secret' => $secret,
            'response' => $captcha,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ));
        $captcha_opts = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $captcha_postdata
            )
        );
        $captcha_context = stream_context_create($captcha_opts);
        $captcha_response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify", false, $captcha_context) , true);

        if ($captcha_response['success']) return true;
        else return false;
    }

    function verify_google_recaptcha()
    {
        $recaptcha = $_POST['g-recaptcha-response'];
        if (empty($recaptcha)) wp_die(__("<b>ERROR:</b> please select <b>I'm not a robot!</b><p><a href='javascript:history.back()'>« Back</a></p>"));
        else if (!is_valid_captcha($recaptcha)) wp_die(__("<b>Go away spammer!</b><p><a href='javascript:history.back()'>« Back</a></p>"));
    }
    if (!is_user_logged_in())
    {
        add_action('pre_comment_on_post', 'verify_google_recaptcha');
    }

}

// Remove posts from specific categories from Yoast Posts Sitemap
if (get_option('wdss_yoast_posts_exclude', '') !== '')
{
    add_filter('wpseo_exclude_from_sitemap_by_post_ids', 'wdss_remove_individual_category_posts_from_sitemap');
    function wdss_remove_individual_category_posts_from_sitemap()
    {
        $args = array(
            'posts_per_page' => - 1,
            'cat' => strval(get_option('wdss_yoast_posts_exclude')) ,
            'post_type' => 'post'
        );
        $the_query = new WP_Query($args);
        if ($the_query->have_posts())
        {
            $exclude_array = array();
            while ($the_query->have_posts())
            {
                $the_query->the_post();
                $this_testimonial_array = get_the_ID();
                $exclude_array[] = $this_testimonial_array;
            }
        }
        wp_reset_postdata();
        return $exclude_array;
    }
}

