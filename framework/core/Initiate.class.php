
<?php
// 启动类
class Initiate{
    /**
     * index.hph:p=admin&c=goods&a=add
     * 解析路由，确定是哪个平台，哪个控制器，调用哪个方法
     * 然后实例化控制器，并调用方法
     * 主要完成三个功能:
     *  初始化，主要是定义项目等路径常量
     *  路由，其实就是实例化控制器，调用方法
     *  自定载入
     * @return [type] [description]
     */
    public static function run(){
        self::init();
        self::autoload();
        self::dispatch();

    }
    // 初始化方法
    private static function init(){
    // 路径常量
    // for level1
        define("DS", DIRECTORY_SEPARATOR);//得到一个操作系统的分隔符号，window '\', mac '/'
        define("ROOT", getcwd().DS); //cwd得到当前工作目录
        define("APP_PATH", ROOT."app".DS);
        define("FRAMEWORK_PATH", ROOT."framework".DS);
        define("PUBLIC_PATH", ROOT."public".DS);
    // for app
        define("CONFIG_PATH", APP_PATH."config".DS);
        define("CONTROLLER_PATH", APP_PATH."controller".DS);
        define("MODEL_PATH", APP_PATH."model".DS);
        define("VIEW_PATH", APP_PATH."view".DS);
    // for frameowrk
        define("CORE_PATH", FRAMEWORK_PATH."core".DS);
        define("DATABASE_PATH", FRAMEWORK_PATH."database".DS);
        define("HELPER_PATH", FRAMEWORK_PATH."helper".DS);
        define("LIBRARY_PATH", FRAMEWORK_PATH."library".DS);
    // for public
        define("UPLOAD_PATH", PUBLIC_PATH."upload".DS);
    // for current controller path , admin or home
    // index.hph:p=admin&c=goods&a=add  =》  后台的 GoodController 的 addAction
        define("PLATFORM", isset($_GET['p']) ? $_GET['P'] : "home" );
        define("CONTROLLER", isset($_GET['c']) ? ucfirst($_GET['c']) : "Index" );
        define("ACTION", isset($_GET['a']) ? $_GET['a'] : "index" );
        define("CUR_CONTROLLER_PATH", CONTROLLER_PATH.PLATFORM.DS );
        define("CUR_VIEW_PATH", VIEW_PATH.PLATFORM.DS );
    /**
     * 在此框架中使用了三种类载入的方式：
     * 通过load自动载入controller和model的类
     * 通过在init中手动载入非controller和model中用到的类，但确是通用类
     * 通过在某些模块中需要用到时才手动载入但类，如文件上传类，图像处理类，这些只是在某些时候用到
     */

    /**
     * 加载核心类
     * 此处应预先加载非controller目录上的controller
     * 防止load加载不到另外的一些controller，比如framework上的，这些类何时加载需要根据使用频率决定要不要在init中加载
     * 当controller中的一些类extends framework 上的类的时候，load函数可能在controller目录中找
     * 所有要在init的时候就加载进来
     */
        include CORE_PATH."BaseController.class.php";
        include CORE_PATH."BaseModel.class.php";
        include DATABASE_PATH.'MySql.class.php';

    /**
     * 加载配置文件
     */
        $GLOBALS['config'] = include CONFIG_PATH.'config.php';

    }
    // 路由分发, 实例化对象，并调用方法
    private static function dispatch(){
        //在new的时候，会自动尝试调用load方法，并且把controllerName传进去，（此时此类可能并不存在）
        $controllerName = CONTROLLER."Controller";
        $actionName = ACTION."Action";
        // 实例化controller
        $controller = new $controllerName();
        // 调用相应方法
        $controller->$actionName();
    }
    /**
     * 自动加载，只加载appcontroller 和 modue
     * __autoload  : 如果使用类某函数， 此函数尝试加载未定义的类
     * spl_autoload_register 将普通函数（或方法）注册为自动加载的，在类中，只能这样
     */
    private static function autoload(){
        //spl_autoload_register([__CLASS__,'load']); // 表示当前类的load方法
        spl_autoload_register('self::load'); // 表示当前类的load方法

    }
    /**
     * 完成指定类的加载
     * 自动加载，只加载appcontroller 和 modue, 如GooDController, BrandModel
     */
    public static function load($classname)
    {
        echo $classname;
        if(substr($classname, -10) === 'Controller'){
            include CUR_CONTROLLER_PATH."{$classname}.class.php";
        } elseif(substr($classname, -5) === 'Model'){
            include MODEL_PATH."{$classname}.class.php";
        }else{}
    }
}
