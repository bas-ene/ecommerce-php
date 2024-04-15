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

	private function addDummys()
	{
		$this->addProduct(new Product('Prodotto1', 100, 10, 'Descrizione del p1', 'img/p1.jpg', 'p1'));
		$this->addProduct(new Product('Prodotto2', 95, 16, 'Descrizione del p2', 'img/p2.jpg', 'p2'));
		$this->addProduct(new Product('Prodotto3', 118, 24, 'Descrizione del p2', 'img/p3.jpg', 'p2'));
		$this->addProduct(new Product('Prodotto1', 100, 10, 'Descrizione del p1', 'img/p1.jpg', 'p1'));
		$this->addProduct(new Product('Prodotto2', 95, 16, 'Descrizione del p2', 'img/p2.jpg', 'p2'));
		$this->addProduct(new Product('Prodotto3', 118, 24, 'Descrizione del p2', 'img/p3.jpg', 'p2'));
	}
}
