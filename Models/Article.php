<?php

namespace Models;

use App\ConnectionFactory;
use App\Query;

use PDO;

class Article extends Model
{
    // BUG static::$table retour false
    // protected static $c = 'article';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public $titre = "";
    public $descr = "";
    public $auteur = "";
    public $tarif = 0;
    public $stock = 0;

   

    public function table($table = false)
    {
        $article = new Article;
        Article::$table = $table;

        $pdo = ConnectionFactory::getConnection();
        $create = $pdo->prepare("CREATE TABLE IF NOT EXISTS `article` (
            id INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
            `titre` varchar(255) NOT NULL,
            `descr` varchar(255) NOT NULL,
            `auteur` varchar(255) NOT NULL,
            `tarif` INT NOT NULL,
            `stock` INT NOT NULL  
        )");
        $create->execute();

        // var_dump("je rentre dans Article");

        return $article;
    }

    public function insert()
    {
        // FIXME Add auteur, tarif, stock;
        $fields = ["titre","descr", "auteur", "tarif", "stock"];
        $args = [];
        array_push($args, $this->titre, $this->descr, $this->auteur, $this->tarif, $this->stock);

        $req = new Query();
        return $this->_v["id"] = $req->insert($args, $fields, "article");
        
        /* … */
    }

    // PAGE 19

    // public function __construct(array $t = null)
    // {
    //     /* initialiser les attributs */
    // }

    // public static function findById(Int $id): Article
    // {
    //     $pdo = new \PDO('dsn', 'user', 'pass');
    //     $sql = 'SELECT * FROM article WHERE id= ?';
    //     $stmt = $pdo->prepare($sql);
    //     $stmt->bindParam(1, $id, \PDO::PARAM_INT);
    //     if ($stmt->execute()) {
    //         $article_data = $stmt->fetch(\PDO::FETCH_ASSOC);
    //         return new \models\Article($article_data);
    //     } else return null;
    // }

    // public static function findById(Int $id): Article
    // {
    //     return Article::where('id', '=', $id)->firstOrFail();
    // }

    // public function estDisponible(): bool
    // {
    //     return ($this->stock > 0);
    // }

    // public function categorie(): \models\Categorie
    // {
    //     return $this->belongsTo('\models\Categorie', 'c_id');
    // }


    // private function update()
    // {
    //     $sql = 'update article set .... where id= ?';
    // }

    // private function delete()
    // {
    //     $sql = 'delete from article where id= ?';
    // }

    // public function modifierStock($nb): Int
    // {
    //     $this->stock += $nb;
    //     $this->update();
    // }
}
