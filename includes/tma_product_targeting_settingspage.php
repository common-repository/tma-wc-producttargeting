<?php
/*
 * Copyright (C) 2016 marx
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace TMA;

class TMA_ProductTargeting_SettingsPage {

	/**
	 * Holds the values to be used in the fields callbacks
	 */
	private $options;

	/**
	 * Start up
	 */
	public function __construct() {
		add_action('admin_menu', array($this, 'add_plugin_page'));
//		add_action('admin_init', array($this, 'page_init'));
	}

	/**
	 * Add options page
	 */
	public function add_plugin_page() {
		add_submenu_page('tma-webtools/pages/tma-webtools-admin.php', __("WC ProductTargeting", "tma-wc-producttargeting"), __("WC ProductTargeting", "tma-wc-producttargeting"), 'manage_options', 'tma-producttargeting-setting', array($this, 'create_admin_page'));
	}

	/**
	 * Options page callback
	 */
	public function create_admin_page() {
		// Set class property
		$this->options = get_option('tma_webtools_option');
		
		$wooActive = is_plugin_active( 'woocommerce/woocommerce.php' );
		$wooHint = '';
		if (!$wooActive) {
			$wooHint = '<h2>WooCommerce must be installed and activated!</h2>';
		}
		
		
		?>
		<div class="wrap">
			<?php echo $wooHint?>
			<?php include dirname(__FILE__) . ('/../pages/documentation.php'); ?>
		</div>
		<?php
	}
}

if (is_admin()) {
	$my_settings_page = new TMA_ProductTargeting_SettingsPage();
}