<?php
require_once __DIR__ . "/../core/Database.php";
require_once __DIR__ . '/../core/Response.php';
require_once __DIR__ . '/../core/Router.php';

//

require_once __DIR__ . "/../model/UserModel.php";
require_once __DIR__ . "/../model/TokenModel.php";

//

require_once __DIR__ . "/../middleware/ValidationMiddleware.php";
require_once __DIR__ . "/../middleware/AuthMiddleware.php";
require_once __DIR__ . "/../controller/UserController.php";

$router = new Router();

$router->post('/user/register', [UserController::class, 'register']);
$router->get('/user/index', [UserController::class, 'index']);
$router->get('/user/{id}', [UserController::class, 'show']);
$router->patch('/user/update/{id}', [UserController::class, 'patch']);
$router->put('/user/update/{id}', [UserController::class, 'update']);
$router->post('/user/login', [UserController::class, 'login']);

$router->run();