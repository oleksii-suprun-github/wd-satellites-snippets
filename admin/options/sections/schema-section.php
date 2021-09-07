<?php

if(get_the_post_thumbnail_url($post->ID)) {
	$image = get_the_post_thumbnail_url($post->ID);
}
else {
	$image = 'https://coinranking.info/wp-content/uploads/2020/09/bitcoin-news-1.png';	
}


if(is_front_page()): ?>
    <script type="application/ld+json">
        {
            "@context": "http://schema.org/",
            "@type": "Organization",
            "name": "coinranking.info",
            "url": "https://coinranking.info/",
            "address": {
                "@type": "PostalAddress",
                "addressLocality": "Brestska St, 8",
                "addressRegion": "Kyiv, 02000",
                "addressCountry": "UA"
            },
            "logo": {
                "@type": "ImageObject",
                "contentUrl": "https://coinranking.info/wp-content/uploads/2020/09/bitcoin-news-1.png"
            },
            "contactPoint": {
                "@type": "contactPoint",
                "contactType": "Customer Service",
                "telephone": "+7 781-738-8276",
                "email": "gena_ant@coinranking.info"
            }
        }
    </script>
<?php elseif ( is_singular('post')) : ?>
    <script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "Article",
		"mainEntityOfPage": {
			"@type": "WebPage",
			"@id": "<?php echo get_permalink();?>"
		},
		"headline": "<?php echo the_title(); ?>",
		"description": "<?php echo get_post_meta($post->ID, "
		_yoast_wpseo_metadesc ", true); ?>",
		"image": "<?php echo $image;?>",
		"author": {
			"@type": "Person",
			"name": "Hennadii Antipov"
		},
		"publisher": {
			"@type": "Organization",
			"name": "coinranking",
			"logo": {
				"@type": "ImageObject",
				"url": "https://coinranking.info/wp-content/uploads/2020/09/bitcoin-news-1.png"
			}
		},
"datePublished": "<?php the_time('Y-m-d\'T\'H:m:s'); ?>",
"dateModified": "<?php the_time('Y-m-d\'T\'H:m:s'); ?>"

	}
	</script>
    <script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "BreadcrumbList",
		"itemListElement": [{
			"@type": "ListItem",
			"position": 1,
			"name": "Main",
			"item": "<?php echo get_site_url(); ?>"
		}, {
			"@type": "ListItem",
			"position": 2,
			"name": "<?php $cat = get_the_category(); echo $cat[0]->cat_name; ?>",
			"item": "<?php $category = get_the_category(); $link = get_category_link( $category[0]->term_id ); echo $link; ?>"
		}, {
			"@type": "ListItem",
			"position": 3,
			"name": "<?php echo the_title(); ?>",
			"item": "<?php echo get_permalink();?>"
		}]
	}
	</script>
<?php endif; ?>
<?php if(is_category()) : ?>
    <script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "BreadcrumbList",
		"itemListElement": [{
			"@type": "ListItem",
			"position": 1,
			"name": "Main",
			"item": "<?php echo get_site_url(); ?>"
		}, {
			"@type": "ListItem",
			"position": 2,
			"name": "<?php $cat = get_the_category(); echo $cat[0]->cat_name; ?>",
			"item": "<?php $category = get_the_category(); $link = get_category_link( $category[0]->term_id ); echo $link; ?>"
		}]
	}
	</script>
<?php elseif(is_author()): ?>
    <script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "BreadcrumbList",
		"itemListElement": [{
			"@type": "ListItem",
			"position": 1,
			"name": "Main",
			"item": "<?php echo get_site_url(); ?>"
		}, {
			"@type": "ListItem",
			"position": 2,
			"name": "<?php echo get_the_author_link() ?>",
			"item": "<?php echo get_author_posts_url(1); ?>"
		}]
	}
	</script>
<?php endif; ?>

<?php  if(is_page() && !is_front_page()) : ?>
<script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "BreadcrumbList",
		"itemListElement": [{
			"@type": "ListItem",
			"position": 1,
			"name": "Main",
			"item": "<?php echo get_site_url(); ?>"
		}, {
			"@type": "ListItem",
			"position": 2,
			"name": "<?php echo the_title() ?>",
			"item": "<?php echo get_page_link() ?>"
		}]
	}
</script>
<script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "Article",
		"mainEntityOfPage": {
			"@type": "WebPage",
			"@id": "<?php echo get_page_link();?>"
		},
		"headline": "<?php echo the_title(); ?>",
		"image": "<?php echo $image;?>",
		"author": {
			"@type": "Organization",
			"name": "coinranking"
		},
		"publisher": {
			"@type": "Organization",
			"name": "coinranking",
			"logo": {
				"@type": "ImageObject",
				"url": "https://coinranking.info/wp-content/uploads/2020/09/bitcoin-news-1.png"
			}
		},
        "datePublished": "<?php the_time('Y-m-d\'T\'H:m:s'); ?>",
        "dateModified": "<?php the_time('Y-m-d\'T\'H:m:s'); ?>"

	}
	</script>
<?php endif; ?>
