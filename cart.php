<?php
include_once './components/Product.php';
class Cart
{
	private string $uuid;
	private $products = array();

	public function __construct(string $uuid, array $products)
	{
		$this->uuid = $uuid;
		$this->products = $products;
	}

	public function render()
	{
		echo '<div class="grid grid-cols-3 gap-4 p-4 m-4">';
		foreach ($this->products as $product) {
			$product->renderInCart();
		}
		echo '</div>';
	}

	public function getUUID(): string
	{
		return $this->uuid;
	}

	public function addProduct(Product $product)
	{
		array_push($this->products, $product);
	}

	public function addProducts(array $products)
	{
		$this->products = array_merge($this->products, $products);
	}

	public function removeProduct(Product $product)
	{
		$index = array_search($product, $this->products);
		if ($index !== false) {
			unset($this->products[$index]);
		}
	}
}
