<?php 

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud;', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_POST['id'] ?? null;
if(!$id ){
    header('Location: index.php');
}
$st = $pdo->prepare('DELETE FROM products WHERE id = :id');
$st->bindValue(':id',$id);
$st->execute();

header("Location: index.php");

?>