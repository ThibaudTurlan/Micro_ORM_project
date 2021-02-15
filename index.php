<?php

require 'vendor/autoload.php';

use App\ConnectionFactory;
use App\Query;
use Models\Article;

// une fois au lancement de l'application
$conf = parse_ini_file('conf/db.conf.ini');

$db = ConnectionFactory::makeConnection($conf);

$q = Query::table("table_base");

echo "<b>TEST QUERY CLASS</b>";
// var_dump($q);
var_dump($q->insert(["test", 237]));
// var_dump($q->get());
// var_dump($q->select(["test"]));
// var_dump($q->delete(["test", "=", "237"]));


 echo "<b>Utilisation CLASS ARTICLE </b>";


 echo '<b>ARTICLE</b>';
 $a = new Article;
 $a->table();
 $a->titre = "velo";
 $a->descr = "beau vélo rouge et bleu";
 $a->auteur = "Thibaud";
 $a->tarif = 100;
 var_dump($a->insert());
 var_dump($a);
 echo '<b>ARTICLE : Delete</b>'; 
// $a->delete();

echo "<b>Article::all()</b>";

// $liste = Article::all();
// var_dump($liste);   
// foreach ($liste as $article) print $article->descr;

echo "<b>find</b>";
$l = Article::find(['tarif', '<=', 100 ], ['auteur', 'tarif']);
$article = $l[0];
var_dump($l[0]);

