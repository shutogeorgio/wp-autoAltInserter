<?php

/*
   Plugin Name: WP Auto Alt Inserter
   Text Domain: 
   Description: Insert Alt Tag Automatically if there is no alt tags.
   Author: shutoGeorgio
   Author URI: https://onejapanesedev.com/
   License: GPLv2
   Version: 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Invalid request.' );
}

function alt_settings_page()
{
    add_settings_section("alt_section", "Activate for Inserter of alt tag automatically", null, "alt");
    add_settings_field("alt-checkbox", "Activate", "alt_checkbox_display", "alt", "alt_section");  
    register_setting("alt_section", "alt-checkbox");
}

function alt_checkbox_display()
{
   ?>
        <input type="checkbox" name="alt-checkbox" value="1" <?php checked(1, get_option('alt-checkbox'), true); ?> />
   <?php
}

add_action("admin_init", "alt_settings_page");

function alt_page()
{
  ?>
      <div class="wrap">
         <h1>Activate for adding alt tag automatically.(if there is a alt tag, the alt tag should be used.)</h1>
 
         <form method="post" action="options.php">
            <?php
               settings_fields("alt_section");
 
               do_settings_sections("alt");
                 
               submit_button();
            ?>
         </form>
      </div>
   <?php
}

function menu_item()
{
  add_submenu_page("options-general.php", "Alt Insertion", "Alt Insertion", "manage_options", "alt", "alt_page");
}
add_action("admin_menu", "menu_item");

/* main function */
if (!get_option('alt-checkbox')){
	return;
} else {
  /* judge by the existance of alt tag */
	function auto_alt_filter($html) {
    global $post;
  
    $post_title = get_the_title();
    $post_category = get_the_category();

    $post_title = get_the_category();
  
    if ( $post_title !== '' ) {
      $html = str_replace('alt=""', 'alt="'.esc_attr($post_title).'"', $html);
    }else{
      $html = str_replace('alt=""', 'alt="'.esc_attr($post_category).'"', $html);
    }
    return $html;
  }
  add_filter('the_content', 'auto_alt_filter');
}
