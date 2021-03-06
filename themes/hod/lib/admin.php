<?php

// Edit capabilities
$edit_contributor = get_role('editor');
$edit_contributor->add_cap('edit_theme_options');
$edit_contributor->add_cap('edit_users');
$edit_contributor->add_cap('list_users');
$edit_contributor->add_cap('remove_users');
$edit_contributor->add_cap('delete_users');
$edit_contributor->remove_cap('add_users');
$edit_contributor->remove_cap('create_users');
$edit_contributor->remove_cap('manage_links');
$edit_contributor->remove_cap('manage_categories');

function nhop_addbuttons() {

	// Don't bother doing this stuff if the current user lacks permissions
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
		return;
	}

	// Add only in Rich Editor mode
	if ( get_user_option('rich_editing') == 'true') {
		add_filter('mce_buttons_2', 'register_nhop_buttons');
	}
}

function register_nhop_buttons($buttons) {
   array_push($buttons, "|", "anchor");
   return $buttons;
}

// init process for button control
add_action('init', 'nhop_addbuttons');

?>