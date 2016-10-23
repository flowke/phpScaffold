<?php
/**
 * 基础模型类
 * 定制的模型应该继承此模型
 */
class BaseModel{
    protected $db = null;
    protected $table = null;
    protected $fields = []; //字段列表

    public function __construct($table){
        $dbconfig['host'] = $GLOBALS['config']['host'];
        $dbconfig['user'] = $GLOBALS['config']['user'];
        $dbconfig['password'] = $GLOBALS['config']['password'];
        $dbconfig['dbname'] = $GLOBALS['config']['dbname'];
        $dbconfig['port'] = $GLOBALS['config']['port'];
        $dbconfig['charset'] = $GLOBALS['config']['charset'];

        $this->db = new MySql($dbconfig);
        $this->table = $GLOBALS['config']['prefix'].$table;
        $this->getFields();

    }
}
