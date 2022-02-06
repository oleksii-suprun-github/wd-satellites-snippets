<?php
// Picks random image from predifined lists
function rand_image_from_list($post_id, $default = false)
{

    if($default) {
        $option = get_option('wdss_featured_images_list_default');
    
        if ($option)
        {
            $images_ids_arr = explode(',', $option);
            $rand_index = array_rand($images_ids_arr);
            $image_id = intval($images_ids_arr[$rand_index]);
            set_post_thumbnail($post_id, $image_id);
        }
    } 
    else {
        $category = get_the_category($post_id);

        if (!empty($category))
        {
    
            $option_postfix = preg_replace('/\-+/', '_', strtolower($category[0]->slug));
    
            $option = get_option('wdss_featured_images_list_' . $option_postfix, '');
    
            if ($option)
            {
                $images_ids_arr = explode(',', $option);
                $rand_index = array_rand($images_ids_arr);
                $image_id = intval($images_ids_arr[$rand_index]);
                set_post_thumbnail($post_id, $image_id);
            }
        }
    }
}


// Checks image dimensions
function check_image_size($url)
{
    list($width, $height) = getimagesize($url);

    if (isset($width) && isset($height) && $width > 100)
    {
        return true;
    }
    return false;
}

// URL Status Code Checker
function check_url_status($url, $condition = null)
{

    $meeting_conditions = true;

    if ($condition)
    {
        switch ($condition)
        {
            case 'local-only':

                if (!preg_match('/' . $_SERVER['SERVER_NAME'] . '/'))
                {
                    $meeting_conditions = false;
                }
            break;

            default:
            break;
        }
    }

    // Checks the existence of URL
    if ($meeting_conditions && @fopen($url, "r"))
    {
        return true;
    }
    else
    {
        return false;
    }
}

