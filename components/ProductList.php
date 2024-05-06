<?php
require_once 'Product.php';

class ProductList
{
	private $products = array();

	public function __construct($products)
	{
		$this->products = $products;
		// $this->addDummys();
	}

	public function render()
	{
		echo '<div class="grid grid-cols-3 gap-4 p-4 m-4">';
		foreach ($this->products as $product) {
			$product->render();
		}
		echo '</div>';
	}

	public function addProduct($product)
	{
		array_push($this->products, $product);
	}

	public function renderAsTable()
	{
		echo '<table class="table-auto">';
		echo '<thead>'; // Table header
		echo '<tr>';
		echo '<th class="px-4 py-2">Name</th>';
		echo '<th class="px-4 py-2">Price</th>';
		echo '<th class="px-4 py-2">Quantity</th>';
		echo '<th class="px-4 py-2">Description</th>';
		echo '</tr>';
		echo '</thead>';
		echo '<tbody>'; // Table body
		foreach ($this->products as $product) {
			$product->renderAsRow();
		}
		echo '</tbody>';
		echo '</table>';
	}
}
