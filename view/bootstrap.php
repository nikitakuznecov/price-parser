<?
    ini_set('error_reporting', E_ERROR);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    require_once __DIR__ .'/../vendor/autoload.php';

    use PParser\Core\Di;
    use PParser\Core\DataBase;
    use PParser\Core\Config;
    use PParser\Core\PParser;
    use PParser\Core\Request;
    use PParser\Core\Router;

    try{
        //Include DI
        $di = new Di();

        //Add config
        $di->set("Config",Config::getInstance()->get());

        //Add DataBase object
        $di->set("DataBase",DataBase::getInstance());

        //Add Request object
        $di->set("Request", new Request());

        //Add Router object
        $di->set("Router", new Router(gethostname()));

        $fenom = new \Fenom(new \Fenom\Provider( __DIR__.'/../template/tpl/'));

        $fenom->setCompileDir(__DIR__.'/../cache/');

        $fenom->setOptions(array("auto_reload"=>true,"force_include"=>true,"strip"=>true,"disable_cache" => 1));

        //Add Fenom object
        $di->set("Fenom", $fenom);

        //Instantiate Project
        $project = new PParser($di);

        //Project run
        $project->run();

    }catch (\ErrorException $e) {

        echo $e->getMessage();

    }
?>