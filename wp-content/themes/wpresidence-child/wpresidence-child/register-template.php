<?php
/******
* Template Name: Register Page
******/
// Wp Estate Pack
global $post;
get_header(); 
$options=wpestate_page_details($post->ID); 
?>

<?php 

	if (isset( $_POST["submit"] )) { 
		$user_login		= $_POST["user_login_register"];	
		$user_email		= $_POST["user_email_register"];
		$user_pass		= $_POST["user_password"];
		$pass_confirm 	= $_POST["user_password_retype"];
 
		// this is required for username checks
		//require_once(ABSPATH . WPINC . '/registration.php');
		$message = '';
		if(username_exists($user_login)) {
			// Username already registered
			//pippin_errors()->add('username_unavailable', __('Username already taken'));
			$message = 'Username already taken';
		}
		if(!validate_username($user_login)) {
			// invalid username
			//pippin_errors()->add('username_invalid', __('Invalid username'));
			$message = 'Invalid username';
		}
		if($user_login == '') {
			// empty username
			//pippin_errors()->add('username_empty', __('Please enter a username'));
			$message = 'Please enter a username';
		}
		if(!is_email($user_email)) {
			//invalid email
			//pippin_errors()->add('email_invalid', __('Invalid email'));
			$message = 'Invalid email';
		}
		if(email_exists($user_email)) {
			//Email address already registered
			//pippin_errors()->add('email_used', __('Email already registered'));
			$message = 'Email already registered';
		}
		if($user_pass == '') {
			// passwords do not match
			//pippin_errors()->add('password_empty', __('Please enter a password'));
			$message = 'Please enter a password';
		}
		if($user_pass != $pass_confirm) {
			// passwords do not match
			//pippin_errors()->add('password_mismatch', __('Passwords do not match'));
			$message = 'Passwords do not match';
		}
 
		//$errors = pippin_errors()->get_error_messages();
		//echo $message;
		// only create the user in if there are no errors
		if(empty($message)) { 
 
			$new_user_id = wp_insert_user(array(
					'user_login'		=> $user_login,
					'user_pass'	 		=> $user_pass,
					'user_email'		=> $user_email,
					'user_registered'	=> date('Y-m-d H:i:s'),
					'role'				=> 'subscriber'
				)
			);
			//echo "OK Inserted: ".$new_user_id;
			if($new_user_id) {
				// send an email to the admin alerting them of the registration
				wp_new_user_notification($new_user_id);
 
				// log the new user in
				//wp_setcookie($user_login, $user_pass, true);
				//wp_set_current_user($new_user_id, $user_login);	
				//do_action('wp_login', $user_login);
 
				// send the newly created user to the home page after logging them in
				//wp_redirect(home_url()); exit;
				$success = 'Registration was sucessful. <a href="/login">Log in?</a>';
			}
		} else {
			 //echo "Not Inserted";
		}
	}
?>

<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class="col-xs-12 <?php print $options['content_class'];?> ">
        
         <?php get_template_part('templates/ajax_container'); ?>
        
        <?php while (have_posts()) : the_post(); ?>
            <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
                <h1 class="entry-title"><?php the_title(); ?></h1>
            <?php } ?>
         
            <div class="single-content"><?php the_content();?>
				
				<div class="regiter-form">
					<form action="" name="registerform" method="POST">
					<?php //wp_register('', ''); ?>
					
					<h3 class="widget-title-sidebar"  id="register-div-title-topbar"><?php _e('Register','wpestate');?></h3>
					<div class="loginalert" id="register_message_area_topbar" ><?php if(isset($success)){ echo $success; }?></div>

					<input type="text" name="user_login_register" id="user_login_register_topbar" class="form-control" placeholder="<?php _e('Username','wpestate');?>"/>

					<input type="text" name="user_email_register" id="user_email_register_topbar" class="form-control" placeholder="<?php _e('Email','wpestate');?>"  />

					<?php
					//$enable_user_pass_status= esc_html ( get_option('wp_estate_enable_user_pass','') );
					?>

					<input type="password" name="user_password" id="user_password_topbar" class="form-control" placeholder="<?php _e('Password','wpestate');?>"/>

					<input type="password" name="user_password_retype" id="user_password_topbar_retype" class="form-control" placeholder="<?php _e('Retype Password','wpestate');?>" /> 

					
					<input type="checkbox" name="terms" id="user_terms_register_topbar" />

					<label id="user_terms_register_topbar_label" for="user_terms_register_topbar"><?php _e('I agree with ','wpestate');?><a href="<?php print get_terms_links();?> " target="_blank" id="user_terms_register_topbar_link"><?php _e('terms & conditions','wpestate');?></a> </label> <br>

						

					<?php //wp_nonce_field( 'register_ajax_nonce_topbar', 'security-register-topbar',true );?>   

					<div class="error"><?php if(isset($message)){ echo $message; }?></div>
					<input type="submit" name="submit" class="wpb_button  wpb_btn-info wpb_btn-large" value="Register">

  
					</form>
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