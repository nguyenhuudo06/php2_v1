<?php

class Orders extends Controller
{
    public $model;
    public $data = [];

    function __construct()
    {
        $this->model = $this->model('OrdersModel');
    }

    function index()
    {
        $this->data['all'] = $this->model->index();
        $this->data['contents'] = 'admin/orders/index';

        $this->render('layouts/admin_layout', $this->data);
    }
}