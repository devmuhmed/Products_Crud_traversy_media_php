<?php

$title = $_POST['title'];
$description = $_POST['description'];
$price = $_POST['price'];
$imagePath ='';

//VALIDATION 
if (!$title) {
    //product title required
    $errors[] = 'product title is required';
}
if (!$price) {
    //product price required
    $errors[] = 'product price is required';
}

if (!is_dir('images')) {
    mkdir('images');
}
// to insert these coming variable from input 
if (empty($errors)) {
    $image = $_FILES['image'] ?? null;
    $imagePath = $product['image'];


    if ($image && $image['tmp_name']) {
        if ($product['image']) {
            unlink($product['image']);
        }
        $imagePath = 'images/' . randomString(8) . '/' . $image['name'];
        mkdir(dirname($imagePath));

        move_uploaded_file($image['tmp_name'], $imagePath);
    }
}
