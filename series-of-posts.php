<?php
/*
Plugin Name: Post Series
Plugin URI: http://mikslatvis.com
Description: Allows you to add posts to a series and show the list by the posts.
Version: 0.4
Author: Miks Latvis
Author URI: http://mikslatvis.com
License: GPL2
*/


wp_enqueue_style( 'my-style', plugins_url( '/style.css', __FILE__ ), false, '1.0', 'all' ); // Inside a plugin

function series_of_posts_init() {
	// create a new taxonomy
	register_taxonomy(
		'series_of_posts',
		'post',
		array(
			'label' => __( 'Series of posts' ),
			'sort' => true,
			'args' => array( 'orderby' => 'term_order' ),
			'rewrite' => array( 'slug' => 'series_of_posts' )
		)
	);
}
add_action( 'init', 'series_of_posts_init' );


add_filter( 'the_content', 'series_of_posts_filter', 20 );
/**
 * Add a series box to the beginning of post page wich have a series.
 *
 */
function series_of_posts_filter( $content ) {

    if ( is_single() && has_term('', 'series_of_posts') )
        
        {

$terms = get_terms('series_of_posts');
 $count = count($terms);
 if ( $count > 0 ){
     echo "<div id='series-of-posts-box'><ul>";
     foreach ( $terms as $term ) {
       echo "<p class='one-series'>" . $term->name . ":</p>";
       
       $series_of_posts = $term->slug; 
		
		$args = array(
	'tax_query' => array(
		array(
			'taxonomy' => 'series_of_posts',
			'field' => 'slug',
			'terms' => $series_of_posts
		)
	)
);

       
      $the_query = new WP_Query( $args );

// The Loop
while ( $the_query->have_posts() ) : $the_query->the_post();
	echo '<li class="one-link">'; ?>
	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>

	
	<?php echo '</li>';
endwhile;

// Reset Post Data
wp_reset_postdata(); 


 ?>
       
       
     <?php   
     }
     echo "</ul></div>";
 }


    // Returns the content.
    return $content; } else {return $content;}
}



?>