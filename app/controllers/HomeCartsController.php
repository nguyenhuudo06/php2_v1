<?php

class HomeCarts extends Controller
{

    public $model;
    public $data = [];

    function __construct()
    {
        $this->model = $this->model('CartsModel');
    }

    function index()
    {
        $this->data['assets']['js'] = [_WEB_ROOT_ . '/public/assets/users/js/ajax-cart.js'];
        $this->data['contents'] = 'users/carts/index';
        $result = $this->model->index();
        $this->data['data']['all'] = $result['cartItems'];
        $this->data['data']['total'] = $result['total'];

        $this->render('layouts/users_layout', $this->data);
    }

    function add()
    {
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['status' => 'unauthorized', 'redirect_url' => _WEB_ROOT_ . '/auth/login']);
            exit();
        }

        // Lấy thông tin từ yêu cầu POST hoặc sử dụng giá trị mặc định
        $userId = $_SESSION['user_id'];
        $productId = $_POST['id'];
        $quantity = $_POST['quantity'];

        // Gọi phương thức thêm sản phẩm vào giỏ hàng từ model
        $result = $this->model->addToCart($userId, $productId, $quantity)->rowCount();

        if ($result >= 1) {
            http_response_code(200);
            echo json_encode(['status' => 'success']);
            exit();
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error']);
            exit();
        }
        // }
    }

    function delete()
    {
        $user_id = $_GET['user_id'] ?? null;
        $product_id = $_GET['product_id'] ?? null;

        // Kiểm tra xác thực người dùng
        if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $user_id) {
            // Nếu không xác thực được, chuyển hướng đến trang đăng nhập
            header("Location: " . _WEB_ROOT_ . "/auth/login");
            exit();
        }

        // Gọi phương thức xóa sản phẩm khỏi giỏ hàng từ model
        $result = $this->model->removeFromCart($user_id, $product_id)->rowCount();

        // Kiểm tra kết quả và chuyển hướng người dùng đến trang giỏ hàng
        if ($result >= 1) {
            header("Location: " . _WEB_ROOT_ . "/homecarts"); // Điều hướng đến trang giỏ hàng
            exit();
        } else {
            echo ('Something wrong');
        }
    }

    function checkout()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . _WEB_ROOT_ . "/auth/login");
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $cartItems = $this->model->index()['cartItems'];
        

        if (empty($cartItems)) {
            echo 'Your cart is empty!';
            exit();
        }

        $total_price = $this->model->calculateTotal($cartItems);
        $order_id = $this->model->createOrder($user_id, $total_price);
        $this->model->addOrderItems($order_id, $cartItems);
        $this->model->clearCart($user_id);

        header("Location: " . _WEB_ROOT_ . "/homecarts/orderSuccess?order_id=" . $order_id);
        exit();
    }

    function orderSuccess()
    {
        $order_id = $_GET['order_id'] ?? null;
        if ($order_id) {
            echo "Order ID: " . htmlspecialchars($order_id) . " has been successfully placed!";
        } else {
            echo "There was an error processing your order.";
        }
    }
}
