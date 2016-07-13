<?php
/**
* Template Name: Login Page
**/
global $post;
get_header(); 
$options=wpestate_page_details($post->ID); 
?>



<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class="col-xs-12 <?php print $options['content_class'];?> ">
        
         <?php get_template_part('templates/ajax_container'); ?>
        
        <?php while (have_posts()) : the_post(); ?>
            <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
                <h1 class="entry-title"><?php the_title(); ?></h1>
            <?php } ?>
         
            <div class="single-content"><?php //the_content();?>

				<div class="login-form">
				 <?php 
					 $args = array(
						'echo'           => true,
						'remember'       => true,
						'redirect'       => ( is_ssl() ? 'https://http://subleaster.marmondesigns.com' : 'http://http://subleaster.marmondesigns.com' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
						'form_id'        => 'loginform',
						'id_username'    => 'user_login',
						'id_password'    => 'user_pass',
						'id_remember'    => 'rememberme',
						'id_submit'      => 'wp-submit',
						'label_username' => __( 'Username' ),
						'label_password' => __( 'Password' ),
						'label_remember' => __( 'Remember Me' ),
						'label_log_in'   => __( 'Log In' ),
						'value_username' => '',
						'value_remember' => false
					);
					 wp_login_form( $args ); 
				?> 
				</div>
			</div><!-- single content-->

                   
        
        <!-- #comments start-->
        <?php comments_template('', true);?> 	
        <!-- end comments -->   
        
        <?php endwhile; // end of the loop. ?>
    </div>
  
    
<?php  include(locate_template('sidebar.php')); ?>
</div>   
<?php get_footer(); ?>