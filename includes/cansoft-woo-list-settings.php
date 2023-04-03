<?php

// Create menu list
function cansoft_options_menu_list(){
	add_options_page(
		'Cansoft woo list Options',
		'Cansoft woo list',
		'manage_options',
		'cansoft-options',
		'cansoft_options_content'
	);
}

// Create Options Page Content
function cansoft_options_content(){

	// Init Options Global
	global $cansoft_options;

	ob_start(); ?>
		<div class="wrap">
			<h2><?php _e('Cansoft woo list Settings', 'cansoft_domain'); ?></h2>
			<p><?php _e('Settings for the Cansoft woo list plugin', 'cansoft_domain'); ?></p>
			<form method="post" action="options.php">
				<?php settings_fields('cansoft_settings_group'); ?>
				<table class="form-table">
					<tbody>
						 <tr>
							<th scope="row"><label for="cansoft_settings[enable]"><?php _e('Enable','cansoft_domain'); ?></label></th>
							<td>
								<input name="cansoft_settings[enable]" type="checkbox" id="cansoft_settings[enable]" value="1" <?php @checked('1', $cansoft_options['enable']); ?>
							</td>
						</tr> 
						<tr>
							<th scope="row"><label for="cansoft_settings[Cansoft_url]"><?php _e('API URL','cansoft_domain'); ?></label></th>
							<td>
								<input name="cansoft_settings[Cansoft_url]" type="text" id="cansoft_settings[Cansoft_url]" value="<?php echo $cansoft_options['Cansoft_url']; ?>" class="regular-text">
								<p class="description"><?php _e('Enter your Cansoft profile URL', 'cansoft_domain'); ?></p>
							</td>
						</tr>

						<tr>
							<th scope="row"><label for="cansoft_settings[list_color]"><?php _e('Time','cansoft_domain'); ?></label></th>
							<td><input name="cansoft_settings[list_color]" type="text" id="cansoft_settings[list_color]" value="<?php echo $cansoft_options['list_color']; ?>" class="regular-text">
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="cansoft_settings[cron_job_enable]"><?php _e('Sync Product','cansoft_domain'); ?></label></th>
							<td><input name="cansoft_settings[cron_job_enable]" type="checkbox" id="cansoft_settings[cron_job_enable]" value="1" <?php @checked('1', $cansoft_options['cron_job_enable']); ?>
						</td>
						</tr> 
					</tbody>
				</table>
				<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes', 'cansoft_domain'); ?>"</p>
			</form>
		</div>
	<?php
	echo ob_get_clean();
}

add_action('admin_menu', 'cansoft_options_menu_list');

// Register Settings
function cansoft_register_settings(){
	register_setting('cansoft_settings_group', 'cansoft_settings');
}

add_action('admin_init', 'cansoft_register_settings');