<?php

class AdminProductsModel extends Model
{

    protected $_table = 'products';

    function tableFill()
    {
        return 'products';
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
        $data = $this->db->query("SELECT p.*, c.name AS category_name FROM products p INNER JOIN categories c ON p.categories_id = c.id ORDER BY id DESC");
        return $data;
    }

    // Phương thức thêm sản phẩm mới
    function addProduct($name, $price, $categories_id, $description, $quantity, $img)
    {
        $sql = "INSERT INTO products (name, price, categories_id, description, quantity, img) VALUES (:name, :price, :categories_id, :description, :quantity, :img)";
        $params = [
            ':name' => $name,
            ':price' => (int)$price,
            ':categories_id' => (int)$categories_id,
            ':description' => $description,
            ':quantity' => (int)$quantity,
            ':img' => $img,
        ];
        return $this->db->query2($sql, $params);
    }

    // Phương thức xóa sản phẩm
    function deleteProduct($id)
    {
        $sql = "DELETE FROM products WHERE id = :id";
        $params = [
            ':id' => (int)$id,
        ];
        $result = $this->db->query3($sql, $params);

        // Kiểm tra thực thi câu lệnh SQL có bị lỗi không
        if ($result instanceof PDOStatement) {
            $rowCount = $result->rowCount();

            // Kiểm tra số hàng bị ảnh hưởng
            if ($rowCount === 0) {
                return [
                    'status' => 'error',
                    'data' => [],
                    'message' => 'Không thể xóa bản ghi trong cơ sở dữ liệu'
                ];
            } else {
                return [
                    'status' => 'success',
                    'data' => ['affected_rows' => $rowCount],
                    'message' => 'Xóa sản phẩm thành công'
                ];
            }
        } else {
            // Xử lý lỗi khi thực thi truy vấn
            $error = $result; // $result sẽ là một mảng chứa thông tin lỗi từ query3()
            return [
                'status' => 'error',
                'data' => [],
                'message' => isset($error['message']) ? $error['message'] : 'Lỗi không xác định'
            ];
        }
    }


    // Lấy dữ liệu bản ghi theo id sản phẩm
    function getProductById($id)
    {
        $sql = "SELECT * FROM products WHERE id = :id";
        $params = [
            ':id' => (int)$id,
        ];
        $result = $this->db->query3($sql, $params);

        // Kiểm tra thực thi câu lệnh SQL có bị lỗi không
        if ($result instanceof PDOStatement) {
            $row = $result->fetch(PDO::FETCH_ASSOC);
            // Kiểm tra kết quả có tìm được bản ghi không
            if ($row === false) {
                return [
                    'status' => 'error',
                    'data' => [],
                    'message' => 'Không tìm được bản ghi trong cơ sở dữ liệu'
                ];
            } else {
                return [
                    'status' => 'success',
                    'data' => $row ? ['record' => $row] : [],
                    'message' => 'Bản ghi tồn tại trong cơ sở dữ liệu'
                ];
            }
        } else {
            $error = $result;
            return [
                'status' => 'error',
                'data' => [],
                'message' => isset($error['message']) ? $error['message'] : 'Lỗi không xác định'
            ];
        }
    }
}
