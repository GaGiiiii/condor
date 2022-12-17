<?php

class EntryPoint
{
    /**
     * This function loads the .env file in root directory.
     *
     * @return void
     */
    private function loadEnv(): void
    {
        require_once "vendor/autoload.php";

        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
    }

    /**
     * This function handles errors.
     *
     * It checks if the app is in production or not. It it is in production
     * Then errors will only be logged to file and not displayed on the screen
     * Also it creates log file if it doesn't exist.
     *
     * @return void
     */
    private function handleErrors(): void
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

    /**
     * This function auto loads controllers.
     *
     * @return void
     */
    private function autoLoadControllers(): void
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

    /**
     * This function handles routing in the application.
     *
     * @return void
     */
    private function handleRouting(): void
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

            if (isset($actions['PROTECTED'])) {
                if (!$this->authorizationTokenPresent()) {
                    header('Content-Type: application/json');
                    http_response_code(401);

                    echo json_encode([
                        'message' => 'You need to login for this action.',
                    ]);

                    exit;
                }
            }

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

    /**
     * This function checks if authorization header is present in correct format
     *
     * @return bool
     */
    private function authorizationTokenPresent(): bool
    {
        // Read the token from the header
        $headers = getallheaders();
        $auth_header = $headers['Authorization'] ?? '';

        return preg_match('/^Bearer (\S+)$/', $auth_header, $match);
    }

    /**
     * This function init's the application.
     *
     * @return void
     */
    public function __init(): void
    {
        $this->loadEnv();
        $this->handleErrors();
        $this->autoLoadControllers();
        $this->handleRouting();
    }
}

(new EntryPoint())->__init();
