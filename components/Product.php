<?php
class Product
{
	private $name;
	private $price;
	private $quantity;
	private $description;
	private $image;
	private $id;
	public function __construct($name, $price, $quantity, $description, $image, $id)
	{
		$this->name = $name;
		$this->price = $price;
		$this->quantity = $quantity;
		$this->description = $description;
		$this->image = 'img/' . $image;
		$this->id = $id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getPrice()
	{
		return $this->price;
	}

	public function getQuantity()
	{
		return $this->quantity;
	}

	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function getImage()
	{
		return $this->image;
	}

	public function getId()
	{
		return $this->id;
	}
	public function render()
	{
		echo '
		<div class="bg-white shadow-md rounded-lg" id="product-' . $this->getId() . '">
			<img class="w-auto h-48 object-cover" src="' . $this->getImage() . '" alt="' . $this->getName() . '">
			<h2 class="text-3xl font-bold mt-4 ml-4">' . $this->getName() . '</h2>
			<div class="flex items-center mt-2 ml-4">
				<p class="text-gray-700 mt-2 ml-4">' . $this->getDescription() . '</p>
				<p class="text-gray-700 mt-2 ml-4">Price: ' . $this->getPrice() . '</p>
				<p class="text-gray-700 mt-2 ml-4">Quantity: ' . $this->getQuantity() . '</p>
			</div>
			<form action="./productDetails.php" method="get">
				<input type="hidden" name="id" value="' . $this->getId() . '" />
				<button class="bg-blue-700 text-white py-2 px-4 rounded-lg ml-4 mt-4 mb-4 cursor-pointer" type="submit">Add to cart</button>
			</form>
		</div>';
	}

	public function renderInCart()
	{
		echo '
		<div class="bg-white shadow-md rounded-lg" id="product-' . $this->getId() . '">
			<img class="w-auto h-48 object-cover" src="' . $this->getImage() . '" alt="' . $this->getName() . '">
			<h2 class="text-3xl font-bold mt-4 ml-4">' . $this->getName() . '</h2>
			<div class="flex items center mt-2 ml-4">
				<p class="text-gray-700 mt-2 ml-4">' . $this->getDescription() . '</p>
				<p class="text-gray-700 mt-2 ml-4">Price: ' . $this->getPrice() . '</p>
				<p class="text-gray-700 mt-2 ml-4">Quantity: ' . $this->getQuantity() . '</p>
			</div>
			<form action="./updateCart.php" method="post">
				<input type="hidden" name="id" value="' . $this->getId() . '" />
				<input type="number" name="quantity" value="1" min="0"/>
				<button class="bg-blue-700 text-white py-2 px-4 rounded-lg ml-4 mt-4 mb-4 cursor-pointer" type="submit">Update quantity</button>
			</form>
		</div>';
	}

	public function renderDetails()
	{
		echo '
		<div class="bg-white shadow-md rounded-lg" id="product-' . $this->getId() . '">
			<img class="w-auto h-48 object-cover" src="' . $this->getImage() . '" alt="' . $this->getName() . '">
			<h2 class="text-3xl font-bold mt-4 ml-4">' . $this->getName() . '</h2>
			<div class="flex items center mt-2 ml-4">
				<p class="text-gray-700 mt-2 ml-4">' . $this->getDescription() . '</p>
				<p class="text-gray-700 mt-2 ml-4">Price: ' . $this->getPrice() . '</p>
				<p class="text-gray-700 mt-2 ml-4">Quantity: ' . $this->getQuantity() . '</p>
			</div>
			<form action="./addToCart.php" method="post" class="flex items-center ml-5">
				<input type="hidden" name="id" value="' . $this->getId() . '" />
				<input type="number" name="quantity" value="1" min="1" max="' . $this->getQuantity() . '" />
				<button class="bg-blue-700 text-white py-2 px-4 rounded-lg ml-5 mt-4 mb-4 cursor-pointer" type="submit">Add to cart</button>
			</form>
		</div>';
	}

	public function renderAsRow()
	{
		echo '
			<td>' . $this->getName() . '</td> 
			<td>' . $this->getPrice() . '</td>
			<td>' . $this->getQuantity() . '</td>
			<td>' . $this->getDescription() . '</td>
		';
	}
}
