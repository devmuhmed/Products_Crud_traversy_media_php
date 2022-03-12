<?php 
/** User: TheCodeholic */
namespace app;
use PDO;
use app\models\Product;
class Database {
    
    public \PDO $pdo; //$pdo created instance of PDO class in php version 7.4 or above
    public static Database $db;    
    public function __construct(){
        
        $this->pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud;', 'root', '');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$db = $this; 

    }

    public function getProducts($search = ''){
        if($search){
            $statement = $this->pdo->prepare('SELECT * FROM products WHERE title LIKE :title ORDER BY create_date DESC');
            $statement->bindValue(':title',"%$search%");
        }else{
            $statement = $this->pdo->prepare('SELECT * FROM products ORDER BY create_date DESC');
        }
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }

    public function createProduct(Product $product)
    {
        $statement = $this->pdo->prepare("INSERT INTO products (title, description,image, price, create_date) 
                                    VALUES(:title,:description,:image,:price,:date)
                                        ");
        $statement->bindValue(':title',$product->title);
        $statement->bindValue(':description',$product->description);
        $statement->bindValue(':image',$product->imagePath);
        $statement->bindValue(':price',$product->price);
        $statement->bindValue(':date',date('Y-m-d H:i:s'));
        $statement->execute();
    }
}


?>