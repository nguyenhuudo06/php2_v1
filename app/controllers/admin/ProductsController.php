<?php

class Products extends Controller
{

    public $model, $model_categories;
    public $data = [];

    function __construct()
    {
        $this->model = $this->model('AdminProductsModel');
        $this->model_categories = $this->model('AdminCategoriesModel');
    }

    function index()
    {
        $this->data['assets']['js'] = [_WEB_ROOT_ . '/public/assets/admin/js/admin-products.js'];

        $product_list = $this->model->index();
        $this->data['data']['all'] = $product_list;
        $this->data['info']['page_title'] = 'Admin - Products';
        $this->data['contents'] = 'admin/products/index';

        $this->render('layouts/admin_layout', $this->data);
    }

    // Thêm sản phẩm mới
    // function add()
    // {
    //     $this->data['assets']['js'] = [_WEB_ROOT_ . '/public/assets/admin/js/admin-products.js'];
    //     $this->data['categories']['list'] = $this->model_categories->categoryTree();

    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //         $name = $_POST['name'];
    //         $price = $_POST['price'];
    //         $categories_id = $_POST['categories_id'];
    //         $description = $_POST['description'];
    //         $quantity = $_POST['quantity'];
    //         $image = $_FILES['image'] ?? null;

    //         // Xử lý upload file
    //         if ($image['error'] == UPLOAD_ERR_OK) {
    //             // Kiểm tra kích thước file
    //             if ($image['size'] > 5 * 1024 * 1024) {
    //                 echo "File quá lớn. Vui lòng chọn file nhỏ hơn 5MB.";
    //                 return;
    //             }

    //             if ($image['error'] !== UPLOAD_ERR_OK) {
    //                 echo "Upload ảnh không thành công. Mã lỗi: " . $image['error'];
    //                 return;
    //             }

    //             // Kiểm tra định dạng file
    //             $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    //             $fileType = mime_content_type($image['tmp_name']);

    //             if (!in_array($fileType, $allowedTypes)) {
    //                 echo "File không hợp lệ. Vui lòng chọn file ảnh (jpg, png, gif).";
    //                 return;
    //             }

    //             $img_name = $_FILES['image']['name'];
    //             $imageOriginExtension = pathinfo($img_name, PATHINFO_EXTENSION);
    //             $imageOriginName = pathinfo($img_name, PATHINFO_FILENAME);
    //             $newFileName = time() . $imageOriginName . '.' . $imageOriginExtension;
    //             $uploadDir = '/public/uploads/' . $newFileName;

    //             if (move_uploaded_file($image['tmp_name'],  _DIR_ROOT_ . $uploadDir)) {
    //                 $result = $this->model->addProduct($name, $price, (int)$categories_id, $description, $quantity, $uploadDir);
    //                 if ($result->rowCount() > 0) {
    //                     header("Location: " . _WEB_ROOT_ .  "/admin/products");
    //                     exit();
    //                 }
    //                 echo "Thêm sản phẩm không thành công";
    //             } else {
    //                 echo "Uplaoad ảnh không thành công";
    //             }
    //         } else {
    //             echo "Ảnh là bắt buộc";
    //         }
    //     } else {
    //         $this->data['info']['page_title'] = 'Admin - Add Product';
    //         $this->data['contents'] = 'admin/products/add';

    //         $this->render('layouts/admin_layout', $this->data);
    //     }
    // }

    function add()
    {
        $this->data['assets']['js'] = [_WEB_ROOT_ . '/public/assets/admin/js/admin-products.js'];
        $this->data['categories']['list'] = $this->model_categories->categoryTree();

        // Khởi tạo mảng lưu trữ lỗi
        $errors = [
            'name' => '',
            'price' => '',
            'categories_id' => '',
            'description' => '',
            'quantity' => '',
            'image' => ''
        ];

        // Biến lưu trữ giá trị đã nhập
        $inputValues = [
            'name' => '',
            'price' => '',
            'categories_id' => '',
            'description' => '',
            'quantity' => '',
        ];

        // Kiểm tra nếu là phương thức POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy dữ liệu từ form
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? '';
            $categories_id = $_POST['categories_id'] ?? '';
            $description = $_POST['description'] ?? '';
            $quantity = $_POST['quantity'] ?? '';
            $image = $_FILES['image'] ?? null;

            // Validate dữ liệu và xử lý lỗi
            if (empty($name)) {
                $errors['name'] = "Tên sản phẩm không được để trống";
            } else {
                $inputValues['name'] = $name;
            }

            if (!is_numeric($price) || $price <= 0) {
                $errors['price'] = "Giá sản phẩm phải là một số dương";
            } else {
                $inputValues['price'] = $price;
            }

            if (empty($categories_id)) {
                $errors['categories_id'] = "Danh mục sản phẩm không được để trống";
            } else {
                $inputValues['categories_id'] = $categories_id;
            }

            if (empty($description)) {
                $errors['description'] = "Mô tả sản phẩm không được để trống";
            } else {
                $inputValues['description'] = $description;
            }

            if (!ctype_digit($quantity) || $quantity <= 0) {
                $errors['quantity'] = "Số lượng sản phẩm phải là một số nguyên dương";
            } else {
                $inputValues['quantity'] = $quantity;
            }

            // Kiểm tra ảnh
            if ($image['error'] !== UPLOAD_ERR_OK) {
                $errors['image'] = "Upload ảnh không thành công. Mã lỗi: " . $image['error'];
            } elseif ($image['size'] > 5 * 1024 * 1024) {
                $errors['image'] = "File quá lớn. Vui lòng chọn file nhỏ hơn 5MB.";
            } else {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $fileType = mime_content_type($image['tmp_name']);
                if (!in_array($fileType, $allowedTypes)) {
                    $errors['image'] = "File không hợp lệ. Vui lòng chọn file ảnh (jpg, png, gif).";
                }
            }

            // Nếu có lỗi, hiển thị và dừng lại
            if (array_filter($errors)) {
                $this->data['errors'] = $errors; // Truyền mảng lỗi vào view để hiển thị
            } else {
                // Tiến hành upload ảnh và thêm sản phẩm vào cơ sở dữ liệu
                $img_name = $_FILES['image']['name'];
                $imageOriginExtension = pathinfo($img_name, PATHINFO_EXTENSION);
                $imageOriginName = pathinfo($img_name, PATHINFO_FILENAME);
                $newFileName = time() . $imageOriginName . '.' . $imageOriginExtension;
                $uploadDir = '/public/uploads/' . $newFileName;

                if (move_uploaded_file($image['tmp_name'],  _DIR_ROOT_ . $uploadDir)) {
                    $result = $this->model->addProduct($name, $price, (int)$categories_id, $description, $quantity, $uploadDir);
                    if ($result->rowCount() > 0) {
                        header("Location: " . _WEB_ROOT_ .  "/admin/products");
                        exit();
                    }
                    echo "Thêm sản phẩm không thành công";
                } else {
                    echo "Upload ảnh không thành công";
                }
            }
        }

        // Truyền giá trị đã nhập và mảng lỗi vào view để hiển thị form
        $this->data['inputValues'] = $inputValues;
        $this->data['info']['page_title'] = 'Admin - Add Product';
        $this->data['contents'] = 'admin/products/add';

        $this->render('layouts/admin_layout', $this->data);
    }


    function delete()
    {
        // header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];

            // Tìm sản phẩm theo id
            $findProduct = $this->model->getProductById($id);
            if ($findProduct['status'] == 'success') {
                // Xóa ảnh
                $imagePath = $findProduct['data']['record']['img'];
                if (file_exists(_DIR_ROOT_ . $imagePath)) {
                    unlink(_DIR_ROOT_ . $imagePath);
                }

                // Xóa sản phẩm khỏi CSDL - chưa làm xong
                $deleteProduct = $this->model->deleteProduct($id);
                if ($deleteProduct['status'] == 'success') {
                    echo json_encode(['status' => $deleteProduct['status'], 'data' => $deleteProduct['data'], 'message' => $deleteProduct['message']]);
                } else {
                    echo json_encode(['status' => $deleteProduct['status'], 'data' => $deleteProduct['data'], 'message' => $deleteProduct['message']]);
                }
            } else {
                echo json_encode(['status' => $findProduct['status'], 'data' => $findProduct['data'], 'message' => $findProduct['message']]);
            }
        }
    }
}
