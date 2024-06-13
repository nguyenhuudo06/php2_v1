<?php

class AdminCategoriesModel extends Model
{

    protected $_table = 'categories';

    function tableFill()
    {
        return 'categories';
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
        $data = $this->db->query("SELECT c1.id, c1.name, c1.home, c1.parent_id, c2.name AS parent_name FROM categories c1 LEFT JOIN categories c2 ON c1.parent_id = c2.id");
        return $data;
    }

    function tree()
    {
        $sql = "SELECT * FROM categories";
        $result = $this->db->query2($sql)->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function categoryTree()
    {
        $result = $this->tree();
        $tree = $this->buildTree($result);

        // Bắt đầu chuỗi HTML
        $html = '';
        $html .= $this->displayTree($tree);

        return $html;
    }

    // Hàm để xây dựng cây phân cấp
    function buildTree(array $elements, $parentId = 0)
    {
        $branch = [];

        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children =  $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

    function displayTree($tree, $level = 0)
    {
        $html = '';
        foreach ($tree as $branch) {
            $html .= '<option value="' . $branch['id'] . '">' . str_repeat('--', $level) . ' ' . $branch['name'] . '</option>';

            if (!empty($branch['children'])) {
                $html .= $this->displayTree($branch['children'], $level + 1);
            }
        }

        return $html;
    }
}
