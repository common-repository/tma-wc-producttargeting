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
 * Description of TMA_ProductLoader
 *
 * @author thmarx
 */
class TMA_ProductLoader {
	public static function getProduct($segments, $productCount) {

		$params = array(
			'post_type' => array('product', 'product_variation'),
			'orderby' => 'rand',
			'posts_per_page' => $productCount,
			'meta_query' => array(
				array(
					'key' => 'tma_segment',
					'value' => $segments,
					'compare' => 'IN'
				)
			)
		);

		$wc_query = new \WP_Query($params);

		$products = array();

		if ($wc_query->have_posts()) :
			while ($wc_query->have_posts()) :
				$wc_query->the_post();
				$product = new \WC_Product(get_the_ID());
				array_push($products, $product);
			endwhile;
			wp_reset_postdata();
		endif;
		
		return $products;
	}
}
