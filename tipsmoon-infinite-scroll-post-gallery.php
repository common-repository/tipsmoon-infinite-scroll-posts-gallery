<?php
/*
Plugin Name: Tipsmoon Infinite Scroll Posts Gallery
Description: Add a scroll gallery of related posts on all of your posts
Version: 1.1
Author: Ramzan Ullah
Author URI: http://www.tipsmoon.com
License: 

  This file is part of Tipsmoon Infinite Scroll Posts Gallery.

    Tipsmoon Infinite Scroll Posts Gallery is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Tipsmoon Infinite Scroll Posts Gallery is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Tipsmoon Infinite Scroll Posts Gallery.  If not, see <http://www.gnu.org/licenses/>.

*/


function Tipsmoon_scroll_style_and_script()
{
   /*
     // Register the script like this for a theme:
    wp_register_script( 'custom-script', get_template_directory_uri() . '/js/custom-script.js', array( 'jquery' ) );
   */
    wp_enqueue_script( 'tipsmoon-slider-jquery', plugins_url( '/js/slider_jquery.js', __FILE__ ), array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'tipsmoon-app', plugins_url( '/js/app.js', __FILE__ ), array('jquery'), '1.0.0', true );
	// Register the style like this for a plugin:
	wp_register_style( 'tipsmoon-new-style', plugins_url( '/css/new_style.css', __FILE__ ), array(), '20120208', 'all' );
    // or
    // Register the style like this for a theme:
   // wp_register_style( 'custom-style', get_template_directory_uri() . '/css/custom-style.css', array(), '20120208', 'all' );
     wp_enqueue_style( 'tipsmoon-new-style');
	 wp_localize_script( 'tipsmoon-app', 'my_ajax_url',array('ajaxurl' => admin_url( 'admin-ajax.php' )) );
 }
add_action( 'wp_enqueue_scripts', 'Tipsmoon_scroll_style_and_script',99999);
add_action( 'wp_ajax_tipsmoon_scroll_ajax', 'tipsmoon_scroll_ajax' );
add_action( 'wp_ajax_nopriv_tipsmoon_scroll_ajax', 'tipsmoon_scroll_ajax' );



//****************************************************************************

function Tipsmoon_add_page_scroll($params = array()) {
extract(shortcode_atts(array(
	    'category_name'      => 'default',
		't_background_color' => 'default'
	), $params));
	
	
ob_start(); 
	

$category_ids1=-1;


 ?>
<script>   var categ_id = <?php echo $category_ids1; ?>;  </script>
<script>   //var categ_id = 1;  </script>

<?php

	$htmcode1='<div class="gal_posts_h"><div class="slider"> <ul id="zero1" >
      '.Tipsmoon_Get_default_posts(4).'</ul>
      <a href="#" class="button back"></a>
      <a href="#" class="button forward"></a>
      <span class="index">1</span>
	  <div id="loading_ajax"><br/>Loading..</div></div></div>
    ';
//	onclick="load_my_ajax2('.$category_ids1.');"

echo $htmcode1;
	
return ob_get_clean();
	

}

function Tipsmoon_add_post_scroll($content) {
ob_start(); 
	if (is_single()){
	

	$category1 = get_the_category(); 
   
  $category_ids1= $category1[0]->term_id;

?>
<script>   var categ_id = <?php echo $category_ids1; ?>;  </script>
<script>   //var categ_id = 1;  </script>

<?php

	$htmcode1='<div class="gal_posts_h"><div class="slider"> <ul id="zero1" >
      '.Tipsmoon_Get_default_posts(4).'</ul>
      <a href="#" class="button back"></a>
      <a href="#" class="button forward"></a>
      <span class="index">1</span>
	  <div id="loading_ajax"><br/>Loading..</div></div></div>
    ';
//	onclick="load_my_ajax2('.$category_ids1.');"

$content .= $htmcode1;
	return $content;
	return ob_get_clean();

} else {

return $content;
return ob_get_clean();

}
}

 
// register shortcode
add_shortcode('tipsmoon_add_scroll', 'Tipsmoon_add_page_scroll');
add_filter( "the_content", "Tipsmoon_add_post_scroll" );


//****************************************************************
function Tipsmoon_show_feature_img(){

//image url escaped

 $image_feature1 = wp_get_attachment_image_src(get_post_thumbnail_id(), 'tipsmoonbasic-thumb-400');
				$image_alt1 = get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true);
				echo '<img width="150px" height="100px" src="'. esc_url($image_feature1[0]).'" alt="'.$image_alt1.'" />'; 


}

//*****************************************************************

function Tipsmoon_Get_default_posts($No_of_posts){

if (is_single()){


ob_start();
$orig_post = $post;
global $post;

$category = get_the_category(); 

$category_ids= $category[0]->term_id;

?>
<script>   var post_array_id = <?php echo array($post->ID); ?>;  </script>
<?php
if ($category) {

$args=array(
'category__in' => $category_ids,
 'post__not_in' => array($post->ID),
'posts_per_page'=> $No_of_posts, // Number of related posts that will be shown.
'caller_get_posts'=>1

);
$my_query = new wp_query( $args );
if( $my_query->have_posts() ) {


while( $my_query->have_posts() ) {
$my_query->the_post();
 ?>
 

<li> 
<div class="gal_thumb_h">
<a href="<?php the_permalink();?>" rel="bookmark" title="<?php the_title(); ?>"><?php Tipsmoon_show_feature_img(); /*echo catch_that_image(); */?></a>
</div>
 
<div class="gal_content_h">
<a href="<?php the_permalink();?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>

</div>
 </li>
 

<?php

}


}

}

$post = $orig_post;
wp_reset_query(); 

$content1 = ob_get_clean();

return $content1; 


} 
//****************************************************************
else {


ob_start();
$orig_post = $post;
global $post;


?>
<script>   var post_array_id = <?php echo array($post->ID); ?>;  </script>
<?php

$args=array(
'post_type' => 'post',
//'category__in' => $id,
// 'post__not_in' => array($post->ID),
'posts_per_page'=> 4, // Number of related posts that will be shown.
'caller_get_posts'=>1,
'post_status' => 'publish',
'offset'=>0
);
$my_query = new wp_query( $args );
if( $my_query->have_posts() ) {


while( $my_query->have_posts() ) {
$my_query->the_post();
 ?>
 

<li> 
<div class="gal_thumb_h">
<a href="<?php the_permalink();?>" rel="bookmark" title="<?php the_title(); ?>"><?php Tipsmoon_show_feature_img(); /*echo catch_that_image(); */?></a>

</div>
 
<div class="gal_content_h">
<a href="<?php the_permalink();?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>

</div>
 </li>
 

<?php

}




}

$post = $orig_post;
wp_reset_query(); 

$content1 = ob_get_clean();

return $content1; 


}

}


//*************************************************************************************


function tipsmoon_scroll_ajax(){

//proper sanitizing and validating input data


$offset_id = sanitize_text_field($_POST['off_id']);
$offset_int_id=(int)$offset_id;


$cat_in= sanitize_text_field($_POST['cat_in']);
$cat_in_int = (int)$cat_in;


$post_not_in= sanitize_text_field($_POST['post_not_in']);
$post_not_in_int = (int)$post_not_in;

ob_start();


 
 
 
//show all posts on home or other page	
	$args=array(
'category__in' => $cat_in_int,
'post_type' => 'post',
'posts_per_page'=> 1, // Number of related posts that will be shown.
'caller_get_posts'=>1,
'post_status' => 'publish',
'offset'=>$offset_int_id

);
$the_query = new wp_query( $args );



//$the_query=new WP_Query(array('posts_per_page'=>2));
	if($the_query->have_posts()):
	while($the_query->have_posts()): $the_query->the_post(); ?>

 <li >
<div class="gal_thumb_h">
<a href="<?php the_permalink();?>" rel="bookmark" title="<?php the_title(); ?>"><?php Tipsmoon_show_feature_img();/*echo catch_that_image(); */?>


</a>
</div>
 
<div class="gal_content_h">
<a href="<?php the_permalink();?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>

</div>
 </li>
 

	<?php endwhile;

	wp_reset_postdata();
	   
endif;

	
	
	
	
wp_die();
return ob_get_clean();


}

?>




