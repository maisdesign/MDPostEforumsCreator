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
                  3 ); // $position
};
/* Opzione 1 Brutalmente dal DB 
global $md_postforum_creator_versione;
$md_postforum_creator_versione = "1.0";

function jal_install() {
   global $wpdb;
   global $md_postforum_creator_versione;

   $table_name = $wpdb->prefix . "wp_posts";
      
   $sql = "CREATE TABLE $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  name tinytext NOT NULL,
  text text NOT NULL,
  url VARCHAR(55) DEFAULT '' NOT NULL,
  UNIQUE KEY id (id)
    );";

   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
   dbDelta( $sql );
 
   add_option( "md_postforum_creator_versione", $md_postforum_creator_versione );
}

function jal_install_data() {
   global $wpdb;
   $welcome_name = "Mr. WordPress";
   $welcome_text = "Congratulations, you just completed the installation!";

   $rows_affected = $wpdb->insert( $table_name, array( 'time' => current_time('mysql'), 'name' => $welcome_name, 'text' => $welcome_text ) );
}
*/
 /*Fine opzion1 Brutale */


   /* Opzione 2 Usando insert_post (forse) */
function md_post_creator_inserimento_post() {
$new_post = array(
'post_title' => $_POST['name'] ,
'post_content' => 'Asganaway',
'post_status' => 'draft',
'post_date' => date('Y-m-d H:i:s'),
'post_author' => 1,
'post_type' => 'post',
'post_category' => array(0)
);
$post_id = wp_insert_post($new_post);
};

function md_postforum_creator_menu_page() {
   /* Does the user have the right permissions?*/
   if (!current_user_can('manage_options')) {
      wp_die( 'Sorry, you do not have permission to access this page.');
   };
	if (!empty($_POST)) {
echo $categoria;
     md_post_creator_inserimento_post();
   	}
   _e('<h3>Generates Posts and Forums</h3>','md_postforum_creator');
   echo '<h3>My Custom Menu Page</h3>';
   echo '<div class="mdpostform container">
			<form action="'.admin_url('admin.php?page=md-postforum-creator-menu-page-slug').'" method="post">
			<div class="descmdpost"><p>';
		_e('Nome Clan','md_postforum_creator');
$categoria= wp_dropdown_categories('show_count=1&hierarchical=1');
	echo '</p></div>
			<div class="inputpost"><input name="name" type="text" id="name" value="'.$_POST['name'].'"></div>
			<div id="clickmdpost"><input id="inviapost" name="button" type="submit" value="Invia"></div>
		</form>
	</div>';
};?>