<?php

class EntryPoint
{
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
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = trim($uri, '/condor');
        $uri = trim($uri, '/index.php');
        $uri = "/" . $uri;

        // Load the routes array
        include 'routes/routes.php';

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
        $this->autoLoadControllers();
        $this->handleRouting();
    }
}

(new EntryPoint())->__init();
