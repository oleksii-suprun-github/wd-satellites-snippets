<?php 
    class DoSiteMapXML{
    private static $_xml;
    private static $_init = '<urlset xmlns="http://www.google.com/schemas/sitemap/0.84" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/sitemap.xsd"></urlset>';

    public static function start($root = false)
    {
		header('Content-Type: application/xml');
         if ($root) {
             self::$_xml = new SimpleXMLElement('<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></sitemapindex>');
         } else {
             //$dom = new DOMDocument('1.0', 'UTF 8');
             self::$_xml = new SimpleXMLElement(self::$_init);
         }
 
     }
 
     public static function createRootSiteMap()
     {
        $langs = pll_languages_list();
 		$arr = explode(".", $_SERVER['SERVER_NAME']);
        if (count($arr) == 3) {
            $server_name = substr( $_SERVER['SERVER_NAME'],3);
        } else {
            $server_name = $_SERVER['SERVER_NAME'];
        }

         $_item = self::$_xml;
         foreach($langs as $lang) {
                 $lang = $lang == 'pl' ? '' : $lang . '.';
                 $url = 'https://'. $lang . $server_name . '/sitemap.xml';
                 $sitemap = $_item->addChild("sitemap");
                 $sitemap->addChild("loc", $url);
        }

        $file = $_SERVER['DOCUMENT_ROOT'] . '/sitemap_index.xml';
        return self::$_xml->asXML($file);

    }

    public static function add($_url, $_update = "", $_priority = "0.5", $_freq = "monthly", $_url_alts = []) {
        $_item = self::$_xml->addChild("url");
        $_item->addChild("loc", $_url);

        $_item->addChild("priority", $_priority);
        if ($_update)
            $_item->addChild("lastmod", $_update);
    }

    public static function getMaterialsByLang($lang)
    {
        $pages = get_pages();
        $posts = get_posts(
            [
                'numberposts' => -1,
           ]
       );
        $terms = get_terms(
           [
                'taxonomy' => 'category',
            ]);
        foreach ($pages as $page) {

            $url = get_the_permalink($page->ID);
            $update = $page->post_modified;
            self::add($url, $update);
        }
        foreach ($posts as $post) {
            $arrayUrl = array_values(array_filter(explode('/', get_the_permalink($post->ID))));
            if (in_array('uncategorized', $arrayUrl )){
                continue;
            }
            $url = get_the_permalink($post->ID);
            $update = $post->post_modified;
			if(strtotime($update) < 0) {
				$update= $post->post_date;
			}
            self::add($url, $update);
        }
        if (!empty($terms)) {

            foreach ($terms as $term) {
                $url = 'https://'. $_SERVER['SERVER_NAME'] . '/' . $term->slug.'/';
                self::add($url);
            }
        }
		
		$users = get_users( array('has_published_posts'=>'post'));

        foreach($users as $user) {

            $user_url = 'https://'. $_SERVER['SERVER_NAME'] . '/author/' . $user->user_nicename.'/';
            self::add($user_url);
        }
        echo self::$_xml->asXML();
        exit();
    }
}

function sitemap(){
    if (!is_admin()) {
        header("Content-Type:", 'application/xml');
        DoSiteMapXML::start(true);
        $requestUri = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $requestUri = urldecode($requestUri);
		
		$arr = explode(".", $_SERVER['SERVER_NAME']);
        if (count($arr) == 3) {
            $server_name = substr( $_SERVER['SERVER_NAME'],3);
        } else {
            $server_name = $_SERVER['SERVER_NAME'];
        }


        DoSiteMapXML::createRootSiteMap();
        DoSiteMapXML::start();
        switch ($requestUri) {
            case 'https://es.' . $server_name . '/sitemap.xml':
                DoSiteMapXML::getMaterialsByLang('es');
                break;
            case 'https://de.' . $server_name . '/sitemap.xml':
                    DoSiteMapXML::getMaterialsByLang('de');
                break;
            case 'https://' . $server_name . '/sitemap.xml':
                    DoSiteMapXML::getMaterialsByLang('pl');
                break;
        }
    }
}

sitemap();
