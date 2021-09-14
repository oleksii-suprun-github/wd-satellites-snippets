<?php 

class Wd_Satellites_Snippets_Admin_Options {

	// Last-modifed Settings
	public function wdss_last_modified() {
				function last_modified_default() {
					$LastModified_unix = getlastmod();
					$LastModified = gmdate( "D, d M Y H:i:s \G\M\T", $LastModified_unix );
					$IfModifiedSince = false;
					if ( isset($_ENV['HTTP_IF_MODIFIED_SINCE']) ) {
						$IfModifiedSince = strtotime( substr($_ENV['HTTP_IF_MODIFIED_SINCE'], 5) );
					}
					if ( isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ) {
						$IfModifiedSince = strtotime(substr($_SERVER['HTTP_IF_MODIFIED_SINCE'], 5));
					}
					if ( $IfModifiedSince && $IfModifiedSince >= $LastModified_unix ) {
						header( $_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified' );
						exit;
					}
					header( 'Last-Modified: '. $LastModified );

					add_action('wbcr/factory/option_if_modified_since_headers', function($option_value){
						$server_headers = apache_response_headers();
						if (isset($server_headers['Last-Modified'])
							&& !empty($server_headers['Last-Modified'])
							&& $option_value){
							
							header_remove('Set-Cookie');
						}
							
						return $option_value;
					}, 1);
				}

				function last_modified_polylang() {
					if ( ( defined( 'DOING_AJAX' ) && DOING_AJAX ) || ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || ( is_admin() ) ) {
						return;
					}
				
					$last_modified = '';
				
					if ( is_singular() ) {
						global $post;
				
						if ( post_password_required( $post ) )
							return;
				
						if ( !isset( $post -> post_modified_gmt ) ) {
							return;
						}
				
						$post_time = strtotime( $post -> post_modified_gmt );
						$modified_time = $post_time;
				
						if ( ( int ) $post -> comment_count > 0 ) {
							$comments = get_comments( array(
								'post_id' => $post -> ID,
								'number' => '1',
								'status' => 'approve',
								'orderby' => 'comment_date_gmt',
									) );
							if ( !empty( $comments ) && isset( $comments[0] ) ) {
								$comment_time = strtotime( $comments[0] -> comment_date_gmt );
								if ( $comment_time > $post_time ) {
									$modified_time = $comment_time;
								}
							}
						}
				
						$last_modified = str_replace( '+0000', 'GMT', gmdate( 'r', $modified_time ) );
					}
				
					if ( is_archive() || is_home() ) {
						global $posts;
				
						if ( empty( $posts ) ) {
							return;
						}
				
						$post = $posts[0];
				
						if ( !isset( $post -> post_modified_gmt ) ) {
							return;
						}
				
						$post_time = strtotime( $post -> post_modified_gmt );
						$modified_time = $post_time;
				
						$last_modified = str_replace( '+0000', 'GMT', gmdate( 'r', $modified_time ) );
					}
				
					if ( headers_sent() ) {
						return;
					}
				
					if ( !empty( $last_modified ) ) {
						header( 'Last-Modified: ' . $last_modified );
				
						if ( !is_user_logged_in() ) {
							if ( isset( $_SERVER['HTTP_IF_MODIFIED_SINCE'] ) && strtotime( $_SERVER['HTTP_IF_MODIFIED_SINCE'] ) >= $modified_time ) {
								$protocol = (isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1');
								header( $protocol . ' 304 Not Modified' );
							}
						}
					}
				}

				if( function_exists('pll_the_languages') ) {
					add_action( 'template_redirect', 'last_modified_polylang' );
				}
				else {
					last_modified_default();
				}
	}

	// Basic Snippets List 
  public function wdss_snippets() {
    include_once('sections/snippets-section.php');
    include_once('sections/title-clipping-section.php');
    include_once('sections/featured-images-section.php');
    include_once('sections/polylang-section.php');
    include_once('sections/410-status-section.php');
		include_once('sections/schema-section.php');
  }
}