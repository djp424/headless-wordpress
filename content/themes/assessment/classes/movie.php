<?php
/**
 * Register Movie CPT and Genre Taxonomy.
 *
 * @package gbr-assesment
 */

declare( strict_types = 1 );

namespace GOBankingRates\Assessment\Movie;

/**
 * Class Movie.
 */
class Movie {

	/**
	 * Movie constructor.
	 */
	public function __construct() {

		add_action( 'init', [ $this, 'add_movie_cpt' ] );
		add_action( 'init', [ $this, 'register_genre_taxonomy' ] );
	}

	/**
	 * Register commands.
	 *
	 * @return void
	 * @throws Exception Command cannot be registered.
	 */
	public function add_movie_cpt(): void {

		$labels = array(
			'name'                  => _x( 'Movies', 'Post type general name', 'gbr' ),
			'singular_name'         => _x( 'Movie', 'Post type singular name', 'gbr' ),
			'menu_name'             => _x( 'Movies', 'Admin Menu text', 'gbr' ),
			'name_admin_bar'        => _x( 'Movie', 'Add New on Toolbar', 'gbr' ),
			'add_new'               => __( 'Add New', 'gbr' ),
			'add_new_item'          => __( 'Add New Movie', 'gbr' ),
			'new_item'              => __( 'New Movie', 'gbr' ),
			'edit_item'             => __( 'Edit Movie', 'gbr' ),
			'view_item'             => __( 'View Movie', 'gbr' ),
			'all_items'             => __( 'All Movies', 'gbr' ),
			'search_items'          => __( 'Search Movies', 'gbr' ),
			'parent_item_colon'     => __( 'Parent Movies:', 'gbr' ),
			'not_found'             => __( 'No movies found.', 'gbr' ),
			'not_found_in_trash'    => __( 'No movies found in Trash.', 'gbr' ),
			'featured_image'        => _x( 'Movie Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'gbr' ),
			'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'gbr' ),
			'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'gbr' ),
			'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'gbr' ),
			'archives'              => _x( 'Movie archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'gbr' ),
			'insert_into_item'      => _x( 'Insert into movie', 'Overrides the “Insert into post”/“Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'gbr' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this movie', 'Overrides the “Uploaded to this post”/“Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'gbr' ),
			'filter_items_list'     => _x( 'Filter movies list', 'Screen reader text for the filter links heading on the post type listing screen. Added in 4.4', 'gbr' ),
			'items_list_navigation' => _x( 'Movies list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Added in 4.4', 'gbr' ),
			'items_list'            => _x( 'Movies list', 'Screen reader text for the items list heading on the post type listing screen. Added in 4.4', 'gbr' ),
		);
	
		$args = [
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => [ 'slug' => 'movie' ],
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => [ 'title', 'editor', 'author', 'thumbnail', 'excerpt' ],
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-editor-video',
		];
	
		register_post_type( 'movies', $args );
	}

	/**
	 * Registers a custom taxonomy 'genre' for the 'movie' post type.
	 */
	function register_genre_taxonomy(): void {

		$labels = [
			'name'              => _x( 'Genres', 'taxonomy general name', 'gbr' ),
			'singular_name'     => _x( 'Genre', 'taxonomy singular name', 'gbr' ),
			'search_items'      => __( 'Search Genres', 'gbr' ),
			'all_items'         => __( 'All Genres', 'gbr' ),
			'parent_item'       => __( 'Parent Genre', 'gbr' ),
			'parent_item_colon' => __( 'Parent Genre:', 'gbr' ),
			'edit_item'         => __( 'Edit Genre', 'gbr' ),
			'update_item'       => __( 'Update Genre', 'gbr' ),
			'add_new_item'      => __( 'Add New Genre', 'gbr' ),
			'new_item_name'     => __( 'New Genre Name', 'gbr' ),
			'menu_name'         => __( 'Genre', 'gbr' ),
		];
	
		$args = [
			'hierarchical'      => true, // Set to true to behave like categories, false to behave like tags.
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => [ 'slug' => 'genre' ],
			'show_in_rest'      => true,
		];
	
		register_taxonomy( 'genre', 'movies', $args );
	}
}

new Movie();
