<?php

namespace osoznan\patri;

/**
 * Class Router
 * Makes route from url to controller/action and params
 */
class Router extends Component {
    /** @var App */
    public $application;

    public $controller;
    public $action;

    /**
     * Convert url to framework router params.
     * @param $url string Url to show
     * @return array
     */
    public function urlToControllerAndAction($url) {
        $parts = explode('?', $url);
        $urlPath = trim($parts[0], '/');

        // if query string exist, set GET data properly
        if (isset($parts[1])) {
            foreach (explode('&', $parts[1]) as $pair) {
                $elem = explode('=', $pair);
                $_GET[$elem[0]] = $elem[1];
            }
        }

        $urlPathParts = explode('/', $urlPath);

        $basePath = $this->application->basePath . 'apps';
        $curPath = '';

        $part = reset($urlPathParts);
        $controllerInstance = $app = $appClass = null;

        $apps = $this->application->getConfig('apps');

        // Getting the adressed module of the url
        while (isset($apps[$part])) {
            $appConfig = $apps[$part];
            $appClass = $appConfig['class'];
            $app = new $appClass();

            $curPath .= ("$part/");

            $part = next($urlPathParts);

            if (isset($appConfig['basePath'])) {
                $modulePath .= $appConfig['basePath'];
            }

            if (isset($apps[$part])) {
                $apps = $apps[$part];
            }
        }

        // if module is not identified then assume the default controller
        if (!$part) {
            $part = $this->application->defaultControllerName;
            $curPath = "$part/";
        } elseif (!$appClass) {
            throw new \Exception("wrong module: $part");
        }

        $controllerPath = "{$curPath}controllers";
        if (!is_dir("$basePath/$controllerPath")) {
            throw new \Exception('no controller path');
        }

        do {
            if (is_file("$basePath/$controllerPath/" . ucfirst($part) . "Controller.php")) {
                $fullClassName = 'app\\' . str_replace('/', '\\', $controllerPath) . '\\' . ucfirst($part) . "Controller";

                if (class_exists($fullClassName)) {
                    $controllerInstance = new $fullClassName();

                    $action = next($urlPathParts);
                    $action = $action ? $action : 'index';
                    $action = str_replace('-', '_', $action);

                    if (method_exists($controllerInstance, "action" . ucfirst($action))) {
                        return [
                            'controller' => $controllerInstance,
                            'action' => $action,
                            'path' => $basePath . '/' . $curPath
                        ];
                    } else {
                        throw new \Exception('wrong controller action: ' . $action);
                    }
                } else {
                    throw new \Exception('wrong controller class: ' . $fullClassName);
                }
            } /*elseif (is_dir("$basePath/{$controllerPath}/" . $part)) {

            }*/ else {
                throw new \Exception("wrong controller filename path: $controllerPath/$part");
            }

            $controllerPath .= "/$part";
            $curPath .= "$part/";
            $part = next($urlPathParts);

        } while ($part);

        return false;
    }

}
