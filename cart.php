<?php
include_once './components/Product.php';
class Cart
{
	private $uuid;
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

	public function getUUID()
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

	public function updateProduct($id, int $quantity)
	{
		foreach ($this->products as $product) {
			if ($product->getId() == $id) {
				$product->setQuantity($quantity);
			}
		}
	}

	public function getTotal()
	{
		$total = 0;
		foreach ($this->products as $product) {
			$total += $product->getPrice() * $product->getQuantity();
		}
		return $total;
	}
}
