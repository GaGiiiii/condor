<?php

class EntryPoint
{
    private function loadEnv()
    {
        require_once "vendor/autoload.php";

        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
    }

    private function handleErrors()
    {
        $pathToLogFile = __DIR__ . '/storage/logs/errors.log';

        // Show errors on the page if app is not in production
        if ($_ENV['APP_PRODUCTION'] === "false") {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
        }

        // Save errors to log file
        ini_set('log_errors', 1);
        ini_set('error_log', $pathToLogFile);
        error_reporting(E_ALL);

        if (!file_exists($pathToLogFile)) {
            touch($pathToLogFile);
        }

        error_log(print_r(error_get_last(), true), 3, $pathToLogFile);
    }

    private function autoLoadControllers()
    {
        // Define the base directory for your controllers
        $baseDir = __DIR__ . '/app/controllers';

        // Register the autoloader function
        spl_autoload_register(function ($className) use ($baseDir) {
            // Convert the class name to a file name
            $fileName = str_replace('\\', '/', $className) . '.php';

            // Include the file if it exists
            if (file_exists($baseDir . '/' . $fileName)) {
                require $baseDir . '/' . $fileName;
            }
        });
    }

    private function handleRouting()
    {
        // Get the current request httpVerb and URI
        $httpVerb = $_SERVER['REQUEST_METHOD'];

        if ($httpVerb === "POST" && $_SERVER['CONTENT_TYPE'] !== 'application/json') {
            http_response_code(400);
            echo '400 API works only with JSON.';
        }

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = str_replace('/condor', '', $uri);
        $uri = str_replace('/index.php', '', $uri);

        // Load the routes array
        include 'routes/v1/routes.php';

        // Check if the current request URI matches any of the defined routes
        foreach ($routes as $route => $actions) {

            // Check if the current request httpVerb is supported by the route
            if (isset($actions[$httpVerb])) {
                // Check if the current request URI matches the route pattern
                if (preg_match("#^$route$#", $uri, $matches)) {
                    // Extract any route parameters
                    $params = array_slice($matches, 1);

                    // Call the appropriate controller method and pass the parameters
                    list($controller, $method) = explode('@', $actions[$httpVerb]);
                    call_user_func_array([new $controller(), $method], $params);

                    exit;
                }
            }
        }

        // If no matching route is found, return a 404 response
        http_response_code(404);
        echo '404 Not Found';
    }

    public function __init()
    {
        $this->loadEnv();
        $this->handleErrors();
        $this->autoLoadControllers();
        $this->handleRouting();
    }
}

(new EntryPoint())->__init();
