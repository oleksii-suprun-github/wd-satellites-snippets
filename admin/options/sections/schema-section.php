<?php

if( get_option('wdss_advanced_jsonld_schema') != '1' ) {
	add_action('wp_head', 'json_ld_schema_template');
	function json_ld_schema_template() {
		global $post;

    $count_posts = wp_count_posts();
    $published_posts = $count_posts->publish;

		$logo_url = get_option('wdss_jsonld_schema_logo', '');
		
		if(is_singular() && get_the_post_thumbnail_url($post->ID)) {
			$image_url = get_the_post_thumbnail_url($post->ID);
		}
		else {
			$image_url = $logo_url;
		}
	
		if($published_posts <= 1): ?>
			<script type="application/ld+json">
					{
							"@context": "http://schema.org",
							"@type": "Article",
							"name": "<?php echo get_the_title($post->id); ?>",
							"datePublished": "<?php the_time('Y-m-d\'T\'H:m:s'); ?>",
							"dateModified": "<?php the_time('Y-m-d\'T\'H:m:s'); ?>",
							"headline": "<?php wp_title() ?>",
							"author": {
									"@type": "Person",
									"name": "<?= get_option('wdss_jsonld_schema_author_name', ''); ?>",
									"url": "<?php echo get_site_url(); ?>"
							},
							"mainEntityOfPage": "<?php echo get_permalink(); ?>",
							"image": "<?= $image_url; ?>",
							"url": "<?php echo get_site_url(); ?>",
							"articleBody": "<?php echo preg_replace( '/\s+/', ' ', str_replace( '"', '\"', wp_strip_all_tags( get_the_excerpt() ) ) ) ?>",
							"publisher": {
									"@type": "Organization",
									"name": "<?= get_option('wdss_jsonld_schema_orgname'); ?>",
									"logo": {
											"@type": "ImageObject",
											"url": "<?= $image_url; ?>"
									}
							}
					}
			</script>
		<?php
		else :
			if(is_front_page()): ?>
				<script type="application/ld+json">
						{
								"@context": "http://schema.org/",
								"@type": "Organization",
								"name": "<?= get_option('wdss_jsonld_schema_orgname'); ?>",
								"url": "<?= get_site_url(); ?>",
								"address": {
										"@type": "PostalAddress",
										"addressLocality": "<?= get_option('wdss_jsonld_schema_locality'); ?>",
										"addressRegion": "<?= get_option('wdss_jsonld_schema_region'); ?>",
										"postalCode": "<?= get_option('wdss_jsonld_schema_postal_code'); ?>",
										"streetAddress": "<?= get_option('wdss_jsonld_schema_street'); ?>",
										"addressCountry": "<?= get_option('wdss_jsonld_schema_country'); ?>"
								},
								"logo": {
										"@type": "ImageObject",
										"contentUrl": "<?= $logo_url; ?>"
								},
								"contactPoint": {
										"@type": "contactPoint",
										"contactType": "Customer Service",
										"telephone": "<?= get_option('wdss_jsonld_schema_telephone'); ?>",
										"email": "<?= get_option('wdss_jsonld_schema_email'); ?>"
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
						"@id": "<?= get_permalink();?>"
					},
					"headline": "<?= the_title(); ?>",
					"description": "<?= get_post_meta($post->ID, "
					_yoast_wpseo_metadesc ", true); ?>",
					"image": "<?= $image_url; ?>",
					"author": {
						"@type": "Person",
						"name": "<?= get_the_author(); ?>"
					},
					"publisher": {
						"@type": "Organization",
						"name": "<?= get_option('wdss_jsonld_schema_orgname'); ?>",
						"logo": {
							"@type": "ImageObject",
							"url": "<?= $logo_url; ?>"
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
						"item": "<?= get_site_url(); ?>"
					}, {
						"@type": "ListItem",
						"position": 2,
						"name": "<?php $cat = get_the_category(); echo $cat[0]->cat_name; ?>",
						"item": "<?php $category = get_the_category(); $link = get_category_link( $category[0]->term_id ); echo $link; ?>"
					}, {
						"@type": "ListItem",
						"position": 3,
						"name": "<?= the_title(); ?>",
						"item": "<?= get_permalink();?>"
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
						"item": "<?= get_site_url(); ?>"
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
						"item": "<?= get_site_url(); ?>"
					}, {
						"@type": "ListItem",
						"position": 2,
						"name": "<?= get_the_author_link() ?>",
						"item": "<?= get_author_posts_url(1); ?>"
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
						"item": "<?= get_site_url(); ?>"
					}, {
						"@type": "ListItem",
						"position": 2,
						"name": "<?= the_title() ?>",
						"item": "<?= get_page_link() ?>"
					}]
				}
			</script>
			<script type="application/ld+json">
				{
					"@context": "https://schema.org",
					"@type": "Article",
					"mainEntityOfPage": {
						"@type": "WebPage",
						"@id": "<?= get_page_link();?>"
					},
					"headline": "<?= the_title(); ?>",
					"image": "<?= $image_url;?>",
					"author": {
						"@type": "Organization",
						"name": "<?= get_option('wdss_jsonld_schema_orgname'); ?>",
					},
					"publisher": {
						"@type": "Organization",
						"name": "<?= get_option('wdss_jsonld_schema_orgname'); ?>",
						"logo": {
							"@type": "ImageObject",
							"url": "<?= $logo_url; ?>"
						}
					},
							"datePublished": "<?php the_time('Y-m-d\'T\'H:m:s'); ?>",
							"dateModified": "<?php the_time('Y-m-d\'T\'H:m:s'); ?>"
		
				}
				</script>
			<?php endif;
		endif;
	}	
}
elseif(get_option('wdss_advanced_jsonld_schema') === '1') {
	add_action('wp_head', 'json_ld_custom_schema_template');
	function json_ld_custom_schema_template() {
		
		if(is_front_page()) {
			echo get_option('wdss_advanced_jsonld_schema_homepage', '');
		} elseif ( is_singular('post')) {
			echo get_option('wdss_advanced_jsonld_schema_single', '');
		}
		if(is_category()) {
			echo get_option('wdss_advanced_jsonld_schema_category', '');
		}
		if(is_page() && !is_front_page()) {
			echo get_option('wdss_advanced_jsonld_schema_page', '');
		}
	}		
}

