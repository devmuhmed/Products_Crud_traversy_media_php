<?php 

require_once "../../database.php";    
$id = $_POST['id'] ?? null;
if(!$id ){
    header('Location: index.php');
}
$st = $pdo->prepare('DELETE FROM products WHERE id = :id');
$st->bindValue(':id',$id);
$st->execute();

header("Location: index.php");

?>