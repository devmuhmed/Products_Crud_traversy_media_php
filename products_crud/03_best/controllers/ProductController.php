<?php

namespace app\controllers;
use app\Router; 
use app\Database;
use app\models\Product;

class ProductController{

    public function index(Router $router)
    {
        $search = $_GET['search'] ?? '';
        $products = $router->db->getProducts($search);
        $router->renderView('products/index',[
            'products' => $products,
            'search' => $search
        ]);
    }
    public function create(Router $router)
    {
        $errors = [];
        $productData = [
            'title'=> '',
            'description' => '',
            'image' => '',
            'price' => ''
        ];
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $productData['title']=$_POST['title'];
            $productData['description']=$_POST['description'];
            $productData['price']=(float)$_POST['price'];
            $productData['imageFile']=$_FILES['imageFile'] ?? null;
            $product = new Product();
            $product->load($productData);
            $errors = $product->save();
            if (empty(errors)){

                header('Location: /products');
                exit;
            }
        }
        $router->renderView('products/create',[
            'product' => $productData,
            'errors' => $errors
        ]);
    }
    public function update(){
        
        echo "update page";
        
    }
    public function delete(){
        
        echo "delete page";
        
    }
}
?>