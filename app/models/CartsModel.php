<?php

class CartsModel extends Model
{

    protected $_table = 'carts';

    function tableFill()
    {
        return 'carts';
    }

    function fieldFill()
    {
        return '*';
    }

    function primaryKey()
    {
        return 'id';
    }

    function index()
    {
        $user_id = $_SESSION['user_id'];

        $sql = "
            SELECT cart_items.*, products.img, products.name, products.price
            FROM cart_items
            LEFT JOIN products ON cart_items.product_id = products.id
            WHERE cart_items.user_id = :user_id";
        $params = [':user_id' => $user_id];

        $cartItems = $this->db->query2($sql, $params)->fetchAll(PDO::FETCH_ASSOC);

        $total = $this->calculateTotal($cartItems);

        return [
            'cartItems' => $cartItems,
            'total' => $total
        ];
    }

    function calculateTotal($cartItems)
    {
        $total = 0;

        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }

    function addToCart($user_id, $product_id, $quantity)
    {
        // Kiểm tra sản phẩm đã tồn tại trong giỏ hàng của người dùng hay chưa
        $sql = "SELECT * FROM cart_items WHERE user_id = :user_id AND product_id = :product_id";
        $params = [
            ':user_id' => $user_id,
            ':product_id' => $product_id
        ];
        $existingCartItem = $this->db->query2($sql, $params)->fetch(PDO::FETCH_ASSOC);

        if ($existingCartItem) {
            // Nếu sản phẩm đã tồn tại, cập nhật số lượng
            $sql = "UPDATE cart_items SET quantity = quantity + :quantity WHERE user_id = :user_id AND product_id = :product_id";
            $params[':quantity'] = $quantity;
        } else {
            // Nếu sản phẩm chưa tồn tại, thêm mới vào giỏ hàng
            $sql = "INSERT INTO cart_items (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
            $params[':quantity'] = $quantity;
        }

        return $this->db->query2($sql, $params);
    }

    function removeFromCart($user_id, $product_id)
    {
        $sql = "DELETE FROM cart_items WHERE user_id = :user_id AND product_id = :product_id";
        $params = [
            ':user_id' => $user_id,
            ':product_id' => $product_id
        ];
        return $this->db->query2($sql, $params);
    }

    function createOrder($user_id, $total_price)
    {
        $sql = "INSERT INTO orders (user_id, status, total_price) VALUES (:user_id, 'pending', :total_price)";
        $params = [
            ':user_id' => $user_id,
            ':total_price' => $total_price
        ];
        $this->db->query2($sql, $params);
        return $this->db->lastInsertId();
    }

    function addOrderItems($order_id, $cartItems)
    {
        foreach ($cartItems as $item) {
            $sql = "INSERT INTO order_items (order_id, product_id, price, quantity, total_price) VALUES (:order_id, :product_id, :price, :quantity, :total_price)";
            $params = [
                ':order_id' => $order_id,
                ':product_id' => $item['product_id'],
                ':price' => $item['price'],
                ':quantity' => $item['quantity'],
                ':total_price' => $item['price'] * $item['quantity']
            ];
            $this->db->query2($sql, $params);
        }
    }

    function clearCart($user_id)
    {
        $sql = "DELETE FROM cart_items WHERE user_id = :user_id";
        $params = [':user_id' => $user_id];
        return $this->db->query2($sql, $params);
    }
}
