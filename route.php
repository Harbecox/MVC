<?php

class Route {

    static function start() {
        $controllerName = DEFOULT_CONTROLLER;
        $actionName = DEFOULT_ACTION;
        $arguments = array();

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        if ($routes[count($routes) - 1] == "") {
            header("location:/" . $controllerName);
        }

        if (!empty($routes[1])) {
            $controllerName = $routes[1];
        }

        if (!empty($routes[2])) {
            $actionName = $routes[2];
        }

        for ($i = 3; $i < count($routes); $i++) {
            $arguments[$i - 3] = $routes[$i];
        }

        $modelName = 'model_' . $controllerName;
        $controllerName = 'controller_' . $controllerName;
        $actionName = 'action_' . $actionName;
        $modelFile = strtolower($modelName) . '.php';
        $modelPath = "model/" . $modelFile;

        if (file_exists($modelPath)) {
            include "model/" . $modelFile;
        }
        $controllerFile = strtolower($controllerName) . '.php';
        $controllerPath = "controller/" . $controllerFile;
        if (file_exists($controllerPath)) {
            include "controller/" . $controllerFile;
        } else {
            Route::ErrorPage404();
        }
        $controller = new $controllerName($modelName);
        $action = $actionName;
        if (method_exists($controller, $action)) {
            $controller->$action($arguments);
        }
//        elseif($controller->checkSeoUrl(substr($action,7))){
//            $prod_id = $controller->checkSeoUrl(substr($action,7));
//            array_unshift($arguments,$prod_id);
//            $controller->action_product_details($arguments);
//        }
        else {
            Route::ErrorPage404();
        }
    }

    static function ErrorPage404() {
        //header("location:/");
        include ERROR_PAGE;
          die();
    }

}

?>