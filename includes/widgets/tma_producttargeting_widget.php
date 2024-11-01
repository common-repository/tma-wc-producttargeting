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

namespace TMA;

if (!defined('ABSPATH')) {
	exit;
}

/**
 * Description of TMA_Widget
 *
 * @author thmarx
 */
class TMA_ProductTargeting_Widget extends \WP_Widget {

	private $request;
	private $response;
	private $segments;

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
				'tma_wc_producttargeting_widget', // Base ID
				__('TMA WC Product Targeting', 'tma_wc_producttargeting'), // Name
				array('description' => __('Displays products matching customer segments', 'tma_wc_producttargeting'),) // Args
		);

		$this->request = new TMA_Request();
		if (array_key_exists("_tma_uid", $_COOKIE)) {
			$this->response = $this->request->getSegments($_COOKIE["_tma_uid"]);
			$this->segments = $this->response->user->segments;
			if (sizeof($this->segments) == 0) {
				$this->segments[] = "default";
			}
		} else {
			$this->segments[] = "default";
		}
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()

	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance) {
		echo $args['before_widget'];
		if (!empty($instance['title'])) {
			echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
		}
		echo $this->getProduct();
		echo $args['after_widget'];
	}

	private function getProduct() {

		$products = TMA_ProductLoader::getProduct($this->segments, 1);
				
		if (sizeof($products) == 1) {
			$item = array_rand($products);
			$product = $products[$item];
			$productLink = '<a href="' . $product->get_permalink() . '">';
			if ($product->get_image_id() !== 0) {
				$productLink .= $product->get_image();
			}// else {
			$productLink .= '<h4>' . $product->get_title() . '</h4>';
			//}
			$productLink .= '</a>';
			return $productLink;
		} else {
			return '';
		}
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance) {
		$title = !empty($instance['title']) ? $instance['title'] : __('New title', 'tma_wc_producttargeting');
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';

		return $instance;
	}

}
