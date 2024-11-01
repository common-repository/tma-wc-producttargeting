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
?>

<h2>Documentation</h2>
With the ProductTargeting addon your customers get product recommendations based on the segments they are assigned to.
<br/>
To mark a product as interesting for a target audience, you must add a custom field (<b>tma_segment</b>) with the ID of the segment you hav definded in your webTools installation.
If the product should match more than one segment, add another custom field.
<h3>ProductWidget</h3>
The widget displays a single, random product in your widget area. The product is selected by the user segments. You can use as many widgets as you like per page. 
But keep in mind that every widget executes a database query. 
If the user is currently not assigned to any target audience, the <b>default</b> segment is used to select products. If no product has the default segment assigned, 
no product will be displayed.
<h3>ProductSlider - ShortCode</h3>
The slider displays random products based on the users segments.
<h4>Usage</h4>
[tma_product_slider items='3' productstoshow='3']
<table>
	<thead>
	<th>
	<td>Attribute</td>
	<td>Description</td>
	</th>
	</thead>
	<tbody>
		<tr>
			<td>items</td>
			<td>The total number of items loaded for the slider. <i>default=3</i></td>
		</tr>
		<tr>
			<td>productstoshow</td>
			<td>The number of items displayed at the same time. If the total number of items is greater thnn the number of items that should
				be displayed at once, the slider will scroll automatically from right to left. <i>default=3</i></td>
		</tr>
	</tbody>
</table>