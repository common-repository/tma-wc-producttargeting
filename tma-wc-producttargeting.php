<?php
/*
 * Copyright (C) 2016 thmarx
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

/**
 * @package TMA-ProductTargeting
 * @version 1.6
 */
/*
  Plugin Name: TMA WC ProductTargeting
  Plugin URI: http://thorstenmarx.com/projects/webtools/wordpress-addon/product-targeting/
  Description: ProductTargeting plugin for WooCommerce
  Author: Thorsten Marx
  Version: 0.4.0
  Author URI: http://thorstenmarx.com/
 */
if (!defined('ABSPATH')) {
	exit;
}


add_action('plugins_loaded', 'init_tma_producttargeting');

function init_tma_producttargeting() {
	require_once 'includes/tma_product_targeting_settingspage.php';
	/**
	 * Detect woocommerce and webtools addon
	 */
	$pluginsArray = apply_filters('active_plugins', get_option('active_plugins'));
	if (in_array('woocommerce/woocommerce.php', $pluginsArray) && in_array('tma-webtools/tma-webtools.php', $pluginsArray)) {
		require_once 'includes/widgets/tma_producttargeting_widget.php';
		require_once 'includes/tma_product_loader.php';
		require_once 'includes/tma_product_slider.php';

		// add widget
		// register Foo_Widget widget
		function tma_register_widget() {
			register_widget('TMA\TMA_ProductTargeting_Widget');
		}

		add_action('widgets_init', 'tma_register_widget');

		//[tma_product_slider items="5" productsToShow='1']
		function tma_slider_shortcode($atts) {
			$a = shortcode_atts(array(
				'items' => 3,
				'productstoshow' => 3,
					), $atts);

			$slider = new TMA\TMA_Product_Slider($a);
			$slider->initScripts();
			
			add_action('wp_footer', array( $slider, 'footerScript' ), 1000);
			
			return $slider->getSliderHtml();
		}
		add_shortcode( 'tma_product_slider', 'tma_slider_shortcode' );

	}
}

?>
