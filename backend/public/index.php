<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

use App\SQLiteConnection;

// create an app object
$app = new \Slim\App;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


// create a container object
$container = $app->getContainer();

// create a db object from PDO
$container['db'] = function () {
    return new PDO('sqlite:users.db');
};


// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
};

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
};

// return all users
$app->get('/users', function (Request $request, Response $response) {

    $user_mapper = new UserMapper($this->db);
    $result = $user_mapper->getUsers();

    return $response->withJson($result);
});


// get one user by id
$app->get('/users/{id}', function (Request $request, Response $response, array $args) {

    $id = $args['id'];
    
    $user_mapper = new UserMapper($this->db);
    $result = $user_mapper->getUserById($id);
    
    $user_data = ["first_name" => $result->getFirstName(), 
                    "last_name" => $result->getLastName(), 
                    "phone_number" => $result->getPhoneNumber(), 
                    "password" => $result->getPassword()
                    ];

    return $this->response->withJson($user_data);

    
});

// get one user by name
$app->post('/user', function (Request $request, Response $response, array $args) {

    $data = $request->getParsedBody();
    $first_name = $data['first_name'];
    $last_name = $data['last_name'];
    
    $user_mapper = new UserMapper($this->db);
    $result = $user_mapper->getUserByName($first_name, $last_name);
    
    if($result != false){
        $user_data = ["first_name" => $result->getFirstName(), 
                    "last_name" => $result->getLastName(), 
                    "phone_number" => $result->getPhoneNumber(), 
                    "password" => $result->getPassword()
                    ];

        return $this->response->withJson($user_data);
    }else{
        $arr = array("message" => "user not found");
        return $this->response->withJson($arr);
    }


});



// add user
$app->post('/users/add', function (Request $request, Response $response) {

    $data = $request->getParsedBody();

    $user_data = [];

    $user_data['first_name'] = filter_var($data['first_name'], FILTER_SANITIZE_STRING);
    $user_data['last_name'] = filter_var($data['last_name'], FILTER_SANITIZE_STRING);
    $user_data['phone_number'] = filter_var($data['phone_number'], FILTER_SANITIZE_STRING);
    $user_data['password'] = filter_var($data['password'], FILTER_SANITIZE_STRING);


    $user = new UserEntity($user_data);
    $user_mapper = new UserMapper($this->db);
    $result = $user_mapper->save($user);

    return $result;
    
});


// get auth token
$app->post('/token', function(Request $request, Response $response, array $args) {
    
    $now = new DateTime();
    $future = new DateTime("+5 minutes");
    $data = $request->getParsedBody();
    $username = $data['first_name']."@".$data['last_name'];

    $payload = [
        'iat' => $now->getTimestamp(),
        'exp' => $future->getTimestamp(),
        'username' => $username 
    ];

    $secret = $_ENV['SECRET'];

    $token = JWT::encode($payload, $secret, "HS256");

    $data['token'] = $token;
    $data['expires'] = $future->getTimestamp();

    return $response->withStatus(201)
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));

});

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
    $handler = $this->notFoundHandler; // handle using the default Slim page not found handler
    return $handler($req, $res);
});

// run the app
$app->run();