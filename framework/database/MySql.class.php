<?php
/**
 * 数据库链接对象
 */
class Mysql{
    protected $db = null;
    protected $sql = null;

    public function __construct($config = []){
        $host = isset($config['host']) ? $config['host'] : 'localhost';
        $user = isset($config['user']) ? $config['user'] : 'root';
        $password = isset($config['password']) ? $config['password'] : '';
        $dbname = isset($config['dbname']) ? $config['dbname'] : '';
        $port = isset($config['port']) ? $config['port'] : '3306';
        $charset = isset($config['charset']) ? $config['charset'] : 'utf8';

        try{
            $this->db = new PDO("mysql:host=${host}; dbname=${dbname}; port=${port}; charset=${charset}", ${user}, ${password});
        }catch(PDOException $e){
            echo "数据库链接失败类：".$e->getMessage();
            exit;
        }



    }

    public function prepare($sql){
        $statement = $this->db->prepare($sql);

        $statement->execute();
    }


    /**
     * PDO使用query来执行sql语句（不常用）
     * 用来处理有结果集的语句 如 select  desc  show  （如果不需要处理结果集的用什么都可以）
     * 返回的是PDOStatement对象，再通过这个类的方法获取结果
     */

    public function query($sql){
        try{
            $result = $this->db->query($sql);
        }catch(PDOException $e){

        }
        return $reqult;
    }
    /**
     * PDO使用exec来执行sql语句（不常用）
     * 用来处理没有结果集的  如 ： insert update delete create ...
     * 返回影响的行数
     * 如何是插入语句，可以使用lastinsertid()方法获取最后插入的id
     * @return [type]      [description]
     */
    public function exec($sql){
        try{
            $reqult = $this->db->exec($sql);
        }catch(PDOException $e){

        }
        return $result;
    }


}
