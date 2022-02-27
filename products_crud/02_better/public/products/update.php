<?php
/** @var $pdo \PDO */
require_once "../../database.php";
require_once "../../function.php";
$id = $_GET['id'] ?? null;
if (!$id){
    header('Location: index.php');
}
$st = $pdo->prepare('SELECT * FROM products WHERE id =:id');
$st->bindValue(':id',$id);
$st->execute();
$product = $st->fetch(PDO::FETCH_ASSOC);


$errors = [];
$title = $product['title'];
$description = $product['description'];
$price = $product['price'];
if ($_SERVER['REQUEST_METHOD'] ==='POST'){
    // to insert these coming variable from input 
    require_once "../../validate_product.php"; 
    if (empty($errors)){
        
        $statement = $pdo->prepare("UPDATE products SET title =:title, image = :image, description =:description, price = :price WHERE id= :id");
        $statement->bindValue(':title',$title);
        $statement->bindValue(':description',$description);
        $statement->bindValue(':image',$imagePath);
        $statement->bindValue(':price',$price);
        $statement->bindValue(':id',$id);
        $statement->execute();
        header('Location: index.php');
    }
}

?>


<?php include_once '../../views/partials/header.php';?>
    <p>
        <a href="index.php" class="btn btn-secondary">Go HomePage</a>
    </p>
    <h1>Edit Product</h1>
    <?php include_once "../../views/products/form.php"?>
</body>
</html>