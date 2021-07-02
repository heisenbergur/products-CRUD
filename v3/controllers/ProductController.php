<?php

namespace app\controllers;

use app\models\Product;
use app\Router;

class ProductController
{
    public function index($router)
    {
        $products = $router->db->getProducts();
        $router->renderView('products/index', [
            'products' => $products
        ]);
    }

    public function create($router)
    {
        $errors = [];
        $productData = [
            'title' => '',
            'description' => '',
            'image' => '',
            'price' => ''
        ];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productData['title'] = $_POST['title'];
            $productData['description'] = $_POST['description'];
            $productData['imageFile'] = $_FILES['image'] ?? null;
            $productData['price'] = (float)$_POST['price'];

            $product = new Product();
            $product->load($productData);
            $errors = $product->save();
            if(empty($errors)) {
                header('Location: /products');
                exit;
            }
        }

        $router->renderView('products/create', [
            'product' => $productData,
            'errors' => $errors
        ]);
    }

    public function update($router)
    {
        $router->renderView('products/update', [
            // 'products' => $products
        ]);
    }

    public function delete()
    {
        echo 'delete';
    }
}