<?php
/**
 * Register Movie CPT and Genre Taxonomy.
 *
 * @package gbr-assesment
 */

declare( strict_types = 1 );

namespace GOBankingRates\Assessment\Movie_WP_CLI;

use Exception;
use WP_CLI;
use WP_Error;

/**
 * Class Movie_WP_CLI.
 */
class Movie_WP_CLI {
	
	/**
	 * Movie_WP_CLI constructor.
	 */
	public function __construct() {

		if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
			return;
		}

		add_action( 'init', [ $this, 'add_commands' ] );
	}

	/**
	 * Register commands.
	 *
	 * @return void
	 * @throws Exception Command cannot be registered.
	 */
	public function add_commands(): void {

		WP_CLI::add_command(
			'gbr create-sample-content',
			[ $this, 'create_sample_content_cli_script_action' ]
		);
	}

	/**
	 * Create sample content.
	 * 
	 * @return void
	 */
	public function create_sample_content_cli_script_action(): void {

		// Update permalink option and flush rewrite rules.
		$new_structure = '/%postname%/';
    	update_option( 'permalink_structure', $new_structure );
		
		global $wp_rewrite;
		$wp_rewrite->set_permalink_structure( $new_structure );
		$wp_rewrite->flush_rules();

		WP_CLI::Success( 'Updated permalink structure' );

		// Import image.
		$theme_directory = get_template_directory();
		$image_path = $theme_directory . '/movie.jpg';
	
		$attachment_id = $this->import_local_image($image_path);
	
		if ( is_wp_error( $attachment_id ) ) {
			WP_CLI::Error( 'Failed to import image: ' . $attachment_id->get_error_message() );
		} else {
			WP_CLI::Success( 'Image imported successfully with ID: ' . $attachment_id );
		}

		// Generate test posts.
		for ( $i = 1; $i <= 5; $i++ ) {
			$post_id = wp_insert_post( [
				'post_title'   => 'Post ' . $i,
				'post_content' => 'This is the content for test post ' . $i . '. There is a lot that could be said here, but you will have to wait until this site is live to see that. This content will be updated.',
				'post_status'  => 'publish',
				'post_author'  => 1,
			] );

			set_post_thumbnail( $post_id, $attachment_id );

			WP_CLI::Success( 'Post ' . $i . ' created.' );
		}

		// Generate test pages.
		for ( $i = 1; $i <= 5; $i++ ) {
			wp_insert_post( [
				'post_title'   => 'Page ' . $i,
				'post_content' => 'This is the content for test page ' . $i . '. There is a lot that could be said here, but you will have to wait until this site is live to see that. This content will be updated.',
				'post_status'  => 'publish',
				'post_type'    => 'page',
				'post_author'  => 1,
			] );

			WP_CLI::Success( 'Page ' . $i . ' created.' );
		}

		// Generate movie articles.
		wp_insert_term( 'Action', 'genre' );
		wp_insert_term( 'Romance', 'genre' );
		wp_insert_term( 'Comedy', 'genre' );

		for ( $i = 1; $i <= 10; $i++ ) {
			$movie_id = wp_insert_post( [
				'post_title'   => 'Movie ' . $i,
				'post_content' => 'Movie ' . $i . ' is awesome! It is a must-watch. It is a great movie.',
				'post_status'  => 'publish',
				'post_type'    => 'movies',
				'post_author'  => 1,
			] );

			set_post_thumbnail( $movie_id, $attachment_id );

			// if ( term_exists( 'Action', 'genre' ) ) {
			// 	wp_set_post_terms( $movie_id, 'Action', 'genre' );
			// 	WP_CLI::Success( 'Genre added to Movie ' . $i . '.' );
			// } else {
			// 	WP_CLI::Warning( 'Action genre does not exist, skipping genre assignment.' );
			// }

			WP_CLI::Success( 'Movie ' . $i . ' created.' );
		}

		// Final messages.
		WP_CLI::Success( 'Sample content created.' );
	}

	/**
	 * Imports a local image into the WordPress Media Library.
	 *
	 * @param string $image_path Absolute path to the image file in the local file system.
	 * @param int $post_id The post ID to attach the image to (optional).
	 * @return int|WP_Error The attachment ID on success, WP_Error on failure.
	 */
	public function import_local_image( $image_path, $post_id = 0 ) {
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/media.php' );

		// Ensure the file exists
		if ( ! file_exists( $image_path ) ) {
			return new WP_Error( 'file_does_not_exist', 'File does not exist.' );
		}

		$file_array = [
			'name'     => basename( $image_path ),
			'type'     => mime_content_type( $image_path ),
			'tmp_name' => $image_path,
			'error'    => 0,
			'size'     => filesize( $image_path ),
		];

		// If error storing temporarily, return the error.
		if ( ! empty( $file_array['error'] ) ) {
			return new WP_Error('upload_error', 'Error uploading file to server.');
		}

		// Do the validation and storage stuff.
		$attachment_id = media_handle_sideload( $file_array, $post_id );

		// If error storing permanently, unlink.
		if ( is_wp_error( $attachment_id ) ) {
			@unlink( $file_array['tmp_name'] ); // Clean up.
			return $attachment_id; // Return the error.
		}

		return $attachment_id; // Return the attachment ID.
	}

}

new Movie_WP_CLI();
