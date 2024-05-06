<?php
include_once './components/Product.php';
include_once 'user.php';
include_once 'cart.php';

use app\User;

class Database
{
	private const string host = "localhost";
	private const string username = "sasso";
	private const string password = "";
	private const string database = "ecom";

	private static $connection = null;

	private static function connect(): void
	{
		if (self::$connection !== null) {
			return;
		}
		self::$connection = new mysqli(self::host, self::username, self::password, self::database);
		if (self::$connection->connect_error) {
			die("Connection failed: " . self::$connection->connect_error);
		}
	}

	private static function query(string $sql): mysqli_result
	{
		self::connect();
		$result = self::$connection->query($sql);
		if ($result === false) {
			die("Error executing the query: " . self::$connection->error);
		}
		return $result;
	}

	public static function getProducts(): array
	{
		self::connect();
		$sql = "SELECT * FROM products";

		$result = self::query($sql);
		$products = array();
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$product = new Product($row['name'], $row['price'], $row['quantity'], $row['description'], $row['img_path'], $row['id']);
				array_push($products, $product);
			}
		}
		return $products;
	}

	public static function getProduct(int $id): Product
	{
		self::connect();
		$sql = "SELECT * FROM products WHERE id = ?";
		$stmt = self::$connection->prepare($sql);
		$stmt->bind_param("i", $id);
		$stmt->execute();

		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$product = new Product($row['name'], $row['price'], $row['quantity'], $row['description'], $row['img_path'], $row['id']);
			return $product;
		}
		return null;
	}

	public static function loginUser(string $username, string $password): User
	{
		self::connect();
		$sql = "SELECT * FROM users WHERE username = ? AND password = MD5(?)";
		$stmt = self::$connection->prepare($sql);
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();

		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$user = new User((int)$row['id'], $row['username'], $row['password'], (bool)$row['is_admin']);
			return $user;
		}

		return null;
	}

	public static function signupUser(User $user): bool
	{
		self::connect();
		$sql = "INSERT INTO users (username, password, is_admin) VALUES (?, MD5(?), ?)";
		$stmt = self::$connection->prepare($sql);
		$stmt->bind_param("ssi", $user->getUsername(), $user->getPassword(), $user->isAdmin());
		$stmt->execute();

		return $stmt->affected_rows > 0;
	}

	public static function createCart(User $user): bool
	{
		self::connect();
		$sql = "INSERT INTO shopping_carts (cart_id, user_id) VALUES (UUID(), ?)";
		$stmt = self::$connection->prepare($sql);
		$stmt->bind_param("i", $user->getId());
		$stmt->execute();
		return $stmt->affected_rows > 0;
	}

	public static function getCart(User $user): Cart | null
	{
		self::connect();
		$sql = "SELECT cart_id FROM shopping_carts WHERE user_id = ?";
		$stmt = self::$connection->prepare($sql);
		$stmt->bind_param("i", $user->getId());
		$stmt->execute();

		$result = $stmt->get_result();
		$cart = null;
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			try {
				$cart = new Cart($row['cart_id'], array());
			} catch (Exception) {
				return null;
			}
		} else {
			return null;
		}

		$productsInCart = self::getProductsInCart($cart->getUUID());

		$cart->addProducts($productsInCart);
		return $cart;
	}

	public static function getProductsInCart(string $cart_id): array
	{
		self::connect();
		$sql = "SELECT * FROM products_in_carts WHERE cart_id = ?";
		$stmt = self::$connection->prepare($sql);
		$stmt->bind_param("s", $cart_id);
		$stmt->execute();

		$result = $stmt->get_result();
		$products = array();
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$product = self::getProduct($row['product_id']);
				$product->setQuantity($row['quantity']);
				array_push($products, $product);
			}
		}
		return $products;
	}

	public static function addToCart(User $user, int $productId, int $quantity): bool
	{
		if ($quantity <= 0) {
			return false;
		}
		self::connect();
		$cart = self::getCart($user);
		if ($cart === null) {
			self::createCart($user);
			$cart = self::getCart($user);
		}

		#get if the quantity of the product is available
		$sql = "SELECT quantity FROM products WHERE id = ?";
		$stmt = self::$connection->prepare($sql);
		$stmt->bind_param("i", $productId);
		$stmt->execute();

		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$quantityInStock = $row['quantity'];

		if ($quantityInStock < $quantity) {
			return false;
		}

		$sql = "INSERT INTO products_in_carts (cart_id, product_id, quantity) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity = quantity + ?";
		$stmt = self::$connection->prepare($sql);
		$stmt->bind_param("siii", $cart->getUUID(), $productId, $quantity, $quantity);
		$stmt->execute();
		if ($stmt->affected_rows > 0) {
			self::setQuantityOfProductInStock(-$quantity, $productId);
		}
		return $stmt->affected_rows > 0;
	}

	public static function setQuantityOfProductInStock(int $quantityDelta, int $productId): void
	{
		self::connect();
		$sql = "UPDATE products SET quantity = quantity + ? WHERE id = ?";
		$stmt = self::$connection->prepare($sql);
		$stmt->bind_param("ii", $quantityDelta, $productId);
		$stmt->execute();
	}

	public static function setQuantity(User $user, int $productId, int $quantity): bool
	{
		if ($quantity <= 0) {
			return false;
		}
		self::connect();
		$cart = self::getCart($user);
		if ($cart === null) {
			return false;
		}

		$sql = "UPDATE products_in_carts SET quantity = ? WHERE cart_id = ? AND product_id = ?";
		$stmt = self::$connection->prepare($sql);
		$stmt->bind_param("isi", $quantity, $cart->getUUID(), $productId);
		$stmt->execute();

		return $stmt->affected_rows > 0;
	}

	public static function removeFromCart(User $user, int $productId): bool
	{
		self::connect();
		$cart = self::getCart($user);
		if ($cart === null) {
			return false;
		}

		#get the quantity of the product in the cart 
		$sql = "SELECT quantity FROM products_in_carts WHERE cart_id = ? AND product_id = ?";
		$stmt = self::$connection->prepare($sql);
		$stmt->bind_param("si", $cart->getUUID(), $productId);
		$stmt->execute();

		$result = $stmt->get_result();
		$row = $result->fetch_assoc();
		$quantity = $row['quantity'];

		$sql = "DELETE FROM products_in_carts WHERE cart_id = ? AND product_id = ?";
		$stmt = self::$connection->prepare($sql);
		$stmt->bind_param("si", $cart->getUUID(), $productId);
		$stmt->execute();

		self::setQuantityOfProductInStock($quantity, $productId);

		return $stmt->affected_rows > 0;
	}
	public static function addProduct(string $name, float $price, int $quantity, string $description, string $image): bool
	{
		self::connect();
		$sql = "INSERT INTO products (name, price, quantity, description, img_path) VALUES (?, ?, ?, ?, ?)";
		$stmt = self::$connection->prepare($sql);
		$stmt->bind_param("sdsbs", $name, $price, $quantity, $description, $image);
		$stmt->execute();
		return $stmt->affected_rows > 0;
	}
}
