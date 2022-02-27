<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud;', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$errors = [];
$title = '';
$description = '';
$price = '';
if ($_SERVER['REQUEST_METHOD'] ==='POST'){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $date = date('Y-m-d H:i:s');
    //VALIDATION 
    if (!$title){
        //product title required
        $errors[]='product title is required';
    }
    if (!$price){
        //product price required
        $errors[]='product price is required';
    }

    if(!is_dir('images')){
        mkdir('images');
    }
    // to insert these coming variable from input 
    if (empty($errors)){
        $image = $_FILES['image'] ?? null;
        $imagePath = '';
        if ($image){
            $imagePath = 'images/'.randomString(8).'/'.$image['name'];
            mkdir(dirname($imagePath));

            move_uploaded_file($image['tmp_name'],$imagePath);
        }
        $statement = $pdo->prepare("INSERT INTO products (title, description,image, price, create_date) 
                                    VALUES(:title,:description,:image,:price,:date)
                                        ");
        $statement->bindValue(':title',$title);
        $statement->bindValue(':description',$description);
        $statement->bindValue(':image',$imagePath);
        $statement->bindValue(':price',$price);
        $statement->bindValue(':date',$date);
        $statement->execute();
        header('Location: index.php');
    }
}

    function randomString($n)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyaABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str = '';
        for ($i = 0; $i< $n; $i++){
            $index = rand(0,strlen($characters)-1);
            $str .=$characters[$index];
        }
        return $str;
    }
?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="app.css">
    <title>Products Crud</title>
</head>

<body>
    <h1>Create New Product</h1>
    <?php if (!empty($errors)):?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error):?>
                <div>
                    <?php echo $error ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif;?>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Product Image</label>
            <br>
            <input type="file" name="image">
        </div>
        <div class="form-group">
            <label>Product Title</label>
            <input type="text" class="form-control" name="title" value="<?php echo $title;?>">
        </div>
        <div class="form-group">
            <label>Product Description</label>
            <textarea class="form-control" name="description"><?php echo $description;?></textarea>
        </div>
        <div class="form-group">
            <label>Product Price</label>
            <input type="number" class="form-control" name="price" value="<?php echo $price;?>">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</body>
</html>