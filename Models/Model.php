<?php

namespace Models;

use App\Query;

abstract class Model
{
    protected static $table = "article";
    protected static $idColumn = 'id';

    protected $_v = [];

    public function __construct(array $t = null)
    {
        // var_dump("construc article");
        if (!is_null($t)) $this->_v = $t;
    }

    public function __get($attr_name)
    {
        var_dump("__GETTER TEST");
        if (array_key_exists($attr_name, $this->_v))
            return $this->_v[$attr_name];
    }

    public function __set($attr_name, $value)
    {   
        var_dump("__SET TEST");
        if (array_key_exists($attr_name, $this->_v)) {
            var_dump("__SET TEST222");
            $this->_v = $value;
        }
    }

    public function delete() {
        var_dump("enter delete");
        /* … */
        return Query::table('article')
        ->where(static::$idColumn, '=', $this->_v[static::$idColumn])
        ->delete();
    }

    public static function all(): array
    {
        $all = Query::table('article')->get();
        $return = [];
        foreach ($all as $m) {
            var_dump($return);
            $return[] = new static($m);
        }
        return $return;
    }

    public static function find(array $condition = null, array $fields = null): array
    {
        $condition = implode(" ", $condition);
        var_dump($condition);
        // BUG Add this->table 
        $query = Query::table('article');
        $query->where($condition);
        $article = $query->get($fields);
        var_dump(static::$table);
        return $article;
    }

    public static function first()
    {

    }
}
