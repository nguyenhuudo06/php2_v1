<?php

class OrdersModel extends Model
{
    protected $_table = 'orders';

    function tableFill()
    {
        return 'orders';
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
        
        $sql = "SELECT orders.*, users.name FROM orders JOIN users ON orders.user_id = users.id WHERE orders.user_id = :user_id";
        $params = [':user_id' => $user_id];

        $orders = $this->db->query2($sql, $params)->fetchAll(PDO::FETCH_ASSOC);

        return $orders;
    }
}
