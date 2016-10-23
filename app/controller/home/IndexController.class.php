<?php

/**
 *
 */
class IndexController{

    public function indexAction(){
        //载入首页
        include CUR_VIEW_PATH."index.html";
    }

    public function addAction(){
        //实例化模型, 此时load函数会自动在model目录载入此模型类
        $index = new IndexModel('tiles');
    }
}
