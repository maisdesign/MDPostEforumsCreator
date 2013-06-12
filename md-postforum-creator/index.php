<?php
/*
Plugin Name: Post And Forum Creator by MaisDesign & Stestaz
Plugin URI: http://maisdesign.it
Description: You give it a title and it automatically create a blank post and forum with that title, that's it!
Version: 1.0.0
Author: MaisDesign & Stestaz
Author URI: http://maisdesign.it
License: 
License URI: 
*/
/* Documentazione:
	Quello che sto cercando di ottenere è di svolgere tutto in una sola pagina, sono certo che non serva richiamare BBHOST e compagnia bella per inserire un cavolo di articolo ma sono le 2.20 AM e non so più che pesci pigliare!
	In fondo a questa pagina troverai del codice commentato, se ci sono bestemmie nei commenti lasciale dove stanno, sono di buon auspicio :-P
*/
/* Definiamo la versione */

if (!defined('MD_POSTFORUM_CREATOR_VERSION_KEY'))
    define('MD_POSTFORUM_CREATOR_VERSION_KEY', 'md_postforum_creator_version');

if (!defined('MD_POSTFORUM_CREATOR_VERSION_NUM'))
    define('MD_POSTFORUM_CREATOR_VERSION_NUM', '1.0.0');

add_option(MD_POSTFORUM_CREATOR_VERSION_KEY, MD_POSTFORUM_CREATOR_VERSION_NUM);

/*
    * This example will work at least on WordPress 2.6.3, 
    * but maybe on older versions too.
    */
   add_action( 'admin_init', 'md_postforum_creator_init' );
   add_action( 'admin_menu', 'md_postforum_creator_menu' );
   
   function md_postforum_creator_init() {
       /* Register our stylesheet. */
       wp_register_style( 'mdPostforumCreatorStyle', plugins_url('css/mdpostforumstyle.css', __FILE__) );
	       wp_register_script( 'mdPostforumCreatorScript', plugins_url( '/js/alajax-1.2.js', __FILE__ ) );
   };   
   function md_postforum_creator_menu() {
       /* Register our plugin page */
       $page = add_submenu_page( 'options.php', 
                                 __( 'MDPFC Plugin', 'md-postforum-creator' ), 
                                 __( 'MDPFC Plugin', 'md-postforum-creator' ),
                                 'administrator',
                                 __FILE__, 
                                 'md_postforum_creator_manage_menu' );
  
       /* Using registered $page handle to hook stylesheet loading */
       add_action( 'admin_print_styles-' . $page, 'md_postforum_creator_styles' );
		add_action('admin_print_scripts-' . $page, 'md_postforum_creator_scripts');
   };   
   function md_postforum_creator_styles() {
       /*
        * It will be called only on your plugin admin page, enqueue our stylesheet here
        */
       wp_enqueue_style( 'mdPostforumCreatorStyle' );
   };
   function md_postforum_creator_scripts() {
        /* Link our already registered script to a page */
        wp_enqueue_script( 'mdPostforumCreatorScript' );
    };
   /*function md_postforum_creator_manage_menu() {
   };*/
   add_action('admin_menu', 'register_md_postforum_creator_menu');
function register_md_postforum_creator_menu() {
   add_menu_page( 'MDPFC Options', // $page_title
                  'MDPFC Options', // $menu_title
                  'manage_options', // $capability
                  'md-postforum-creator-menu-page-slug', // $menu_slug
                  'md_postforum_creator_menu_page', // $function
                  plugins_url( 'md-postforum-creator/images/mdpostforum.png' ), /* $icon_url*/
                  3 ); /* $position*/
};

function md_postforum_creator_menu_page() {
   /* Does the user have the right permissions?*/
   if (!current_user_can('manage_options')) {
      wp_die( 'Sorry, you do not have permission to access this page.');
   };
  if(isset($_POST['new_post']) == '1') {
    $post_title = $_POST['post_title'];
    $post_category = $_POST['cat'];
    $post_content = $_POST['post_content'];

    $new_post = array(
          'ID' => '',
          'post_author' => $user->ID, 
          'post_category' => array($post_category),
          'post_content' => '', 
          'post_title' => wp_strip_all_tags($post_title),
          'post_status' => 'draft'
        );
    $post_id = wp_insert_post($new_post);
	if (is_plugin_active('bbpress/bbpress.php')) {
	$forum_id = bbp_insert_forum( array(
				/*'post_parent'  => bbp_get_group_forums_root_id(),*/
				'post_title'   => $post_title,
				/*'post_content' => $group->description,*/
				'post_status'  => 'draft'
			) );
	/*$default_forum = array(	
		$_POST['post_title']     => array($post_category),
	);
	
 
	$forum = bbp_insert_forum( $default_forum );*/
	};
};          
echo '
<form action="'.admin_url('admin.php?page=md-postforum-creator-menu-page-slug').'" method="post">
    <input type="text" name="post_title" size="45" id="input-title"/>
    <input type="hidden" name="new_post" value="1"/>';

	wp_dropdown_categories('orderby=name&hide_empty=0&exclude=1&hierarchical=1');
	
    echo '<input class="subput round" type="submit" name="submit" value="Post"/>
</form>';
};?>
