<?php
/** @var $pdo \PDO */
require_once "../../database.php";
require_once "../../function.php";
$errors = [];
$title = '';
$description = '';
$price = '';
$product =[
    'image' => ''
];
if ($_SERVER['REQUEST_METHOD'] ==='POST'){
    require_once "../../validate_product.php";
    // to insert these coming variable from input 
    if (empty($errors)){
        
        $statement = $pdo->prepare("INSERT INTO products (title, description,image, price, create_date) 
                                    VALUES(:title,:description,:image,:price,:date)
                                        ");
        $statement->bindValue(':title',$title);
        $statement->bindValue(':description',$description);
        $statement->bindValue(':image',$imagePath);
        $statement->bindValue(':price',$price);
        $statement->bindValue(':date',date('Y-m-d H:i:s'));
        $statement->execute();
        header('Location: index.php');
    }
}
?>

<?php include_once '../../views/partials/header.php';?>
    <p>
        <a href="index.php" class="btn btn-secondary">Go HomePage</a>
    </p>
    <h1>Create New Product</h1>
    <?php include_once "../../views/products/form.php"?>
</body>
</html>