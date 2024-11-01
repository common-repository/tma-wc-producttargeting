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

/**
 * Description of tma_product_slider
 *
 * @author thmarx
 */
class TMA_Product_Slider {
	
	private $sliderID;
	private $request;
	private $response;
	private $segments;

	private $params;
	
	public function __construct($params) {
		$this->sliderID = uniqid();
		$this->params = $params;
		
		$this->request = new TMA_Request();
		$uid = TMA_COOKIE_HELPER::getCookie(TMA_COOKIE_HELPER::$COOKIE_USER, UUID::v4(), TMA_COOKIE_HELPER::$COOKIE_USER_EXPIRE);
		if (isset($uid)) {
			$this->response = $this->request->getSegments($uid);
			$this->segments = $this->response->user->segments;
		}
		
		if (sizeof($this->segments) == 0) {
			$this->segments[] = "default";
		}
		
	}

	public function getSliderHtml() {

		$products = TMA_ProductLoader::getProduct($this->segments, $this->params['items']);

		$productsHtml = '<div id=' . $this->sliderID . '>';
		foreach ($products as $i => $product) {
			$productsHtml .= $this->getProductHtml($product);
		}
		$productsHtml .= '</div>';
		
		return $productsHtml;
	}

	private function getProductHtml($product) {

		$productLink = '<a href="' . $product->get_permalink() . '">';
		if ($product->get_image_id() !== 0) {
			$productLink .= $product->get_image();
		} else {
			$productLink .= '<h3>' . $product->get_title() . '</h3>';
		}
		$productLink .= '</a>';

		$html = '<div>' . $productLink . '</div>';
		
		return $html;
	}
	
	public function initScripts () {
		wp_enqueue_script("slick.min.js", plugins_url( '../assets/slick/slick.min.js', __FILE__ ));
		wp_enqueue_style("slick.css", plugins_url( '../assets/slick/slick.css', __FILE__ ));
		wp_enqueue_style("slick-theme.css", plugins_url( '../assets/slick/slick-theme.css', __FILE__ ));
	}
	
	public function footerScript () {
		$footerScript = '<script>'
				. 'jQuery(document).ready(function () {'
				. 'jQuery("#' . $this->sliderID . '").slick({'
				. ' infinite: true, '
				. ' autoplay: true, '
				. ' arrows: false, '
				. ' autoplaySpeed : 1000, '
				. ' slidesToShow: ' . $this->params['productstoshow'] . ', '
				. ' slidesToScroll: 1 '
				. '});'
				. '});'
				. '</script>';
		echo $footerScript;
	}

}
