<?php

class HomeProducts extends Controller
{

    public $model;
    public $data = [];

    function __construct()
    {
        $this->model = $this->model('ProductsModel');
    }

    function index()
    {
        try{
            $err = throw new Error('GHello');
        }catch(Throwable $e){
            App::$app->loadError('exception', $e->getMessage());
            exit();
        }
    }

    function details()
    {
        $this->model->increaseViews($_GET['id']);
        $this->data['data']['details'] = $this->model->index($_GET['id']);
        $this->data['data']['categories'] = $this->model->homeCategories();
        $this->data['contents'] = 'users/products/details';

        $this->render('layouts/users_layout', $this->data);
    }
}
