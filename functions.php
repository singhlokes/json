
<?php

	add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

	function enqueue_parent_styles() {

	wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );

	}

	// Our custom post type function
	function create_posttype() {
	 
	    register_post_type( 'movies',
	    // CPT Options
	        array(
	            'labels' => array(
	                'name' => __( 'Movies' ),
	                'singular_name' => __( 'Movie' )
	            ),
	            'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
	            'public' => true,
	            'has_archive' => true,
	            'rewrite' => array('slug' => 'movies'),
	            'show_in_rest' => true,
	 
	        )
	    );
	}
	// Hooking up our function to theme setup
	add_action( 'init', 'create_posttype' );

	// add custom texonomies
	function add_custom_taxonomies() {
		register_taxonomy('MovieCategory','movies',array(    
    		'hierarchical' => true,
    		'labels' => array(
			    'name' => _x('MovieCategory', 'taxonomy general name' ),
			    'singular_name' => _x('MovieCategory', 'taxonomy singular name' ),
			     'search_items' =>  __('Search MovieCategory' ),
      			'all_items' => __('All MovieCategory' ),
			     'parent_item' => __('Parent MovieCategory '),
      			'parent_item_colon' => __('Parent MovieCategory' ),
      			'edit_item' => __('Edit MovieCategory '),
      			'update_item' => __('Update MovieCategory '),
      			'add_new_item' => __('Add New MovieCategory' ),
			   'new_item_name' => __('New MovieCategoryName' ),
      			'menu_name' => __('MovieCategory' ),
			),

	    	 // Control the slugs used for this taxonomy
		    'rewrite' => array(
		      'slug' => 'MovieCategory', // This controls the base slug that will display before each term
		      'with_front' => false, // Don't display the category base before "/locations/"
		      'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
		    ),
    	));	
	}		
 
	add_action( 'init', 'add_custom_taxonomies', 0 );
	
	//ajax using
	add_action( 'wp_ajax_load_filter_product_categorywise', 'load_filter_product_categorywise' );
	add_action( 'wp_ajax_nopriv_load_filter_product_categorywise', 'load_filter_product_categorywise' );
	
	function load_filter_product_categorywise() {
	    $term_id= $_POST['termId'];
	    if($term_id){
	        $alldata = array(
	          'post_type'      => 'movies',
	          'post_status'    => 'publish',  
	          'posts_per_page' => -1,   
	          'tax_query' => array(
	              	array(
	                	'taxonomy' => 'MovieCategory',
	                	'field' => 'term_id',
	                	'terms' => $term_id
	              	)
	          	),
	      	);
		}
	  
	  // Get all movies
	    /*else{
	    $alldata = array(
	          'post_type'      => 'movies',
	          'post_status'    => 'publish',  
	          'posts_per_page' => -1,
	      );
	  }
	    */
	    $allProducts = new WP_Query( $alldata );
	    if ( $allProducts->have_posts() ) : 
	        while ( $allProducts->have_posts() ) : $allProducts->the_post();
	            //$short_post = get_the_ID();
	            //$author_id = get_post_field ('post_author', $short_post);
	            //$display_name = get_the_author_meta( 'display_name' , $author_id ); ?>
	            <!-- <div class="mix <?php //echo get_term($term_id)->slug; ?> col-12 col-sm-6 col-lg-4" data-bound="" style="display: inline-block;"> -->
	        <div class="mixs">
	          <div class="img-brdr">
	            <?php echo get_the_post_thumbnail(); ?>
	          </div>
	          <h3 class="pro-name"><?php echo get_the_title(); ?></h3>
	          <p class="pro-desc">
	            <span>Suggested Applications:</span>
	            <?php echo get_the_content(); ?>
	          </p>
	        </div>
	      </div>
	        <?php endwhile; 
	        wp_reset_postdata();
	    else : ?>
	      <h2>Not Found..</h2>
	    <?php
	    endif;
	    die(); 
	}





?>