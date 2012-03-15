<?php
/*
Plugin Name: Rakstu Sērija
Plugin URI: http://mikslatvis.com
Description: You can finally make a list of articles.
Version: 0.1
Author: Miks Latvis
Author URI: http://mikslatvis.com
License: GPL2
*/


wp_enqueue_style( 'my-style', plugins_url( '/style.css', __FILE__ ), false, '1.0', 'all' ); // Inside a plugin

function people_init() {
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
add_action( 'init', 'people_init' );


add_filter( 'the_content', 'my_the_content_filter', 20 );
/**
 * Add a icon to the beginning of every post page.
 *
 * @uses is_single()
 */
function my_the_content_filter( $content ) {

    if ( is_single() )
        
        {

$terms = get_terms('series_of_posts');
 $count = count($terms);
 if ( $count > 0 ){
     echo "<div id='rakstu-serija'><ul>";
     foreach ( $terms as $term ) {
       echo "<p class='viena-serija'>" . $term->name . ":</p>";
       
       $seriju_liste = $term->slug; 
		
		$args = array(
	'tax_query' => array(
		array(
			'taxonomy' => 'series_of_posts',
			'field' => 'slug',
			'terms' => $seriju_liste
		)
	)
);

       
      $the_query = new WP_Query( $args );

// The Loop
while ( $the_query->have_posts() ) : $the_query->the_post();
	echo '<li class="viena-saite">'; ?>
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
    return $content; }
}



?>