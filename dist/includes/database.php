<?php 

// same root as public_html
$config = parse_ini_file(__DIR__ . "./../../.env", true);

// create constants
define("DB_HOST", "localhost");
define("DB_NAME", $config["database"]["name"]);
define("DB_USER", $config["database"]["user"]);
define("DB_PASSWORD", $config["database"]["pass"]);

try {
    // setup connection
    $db = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME.';charset=utf8mb4', DB_USER, DB_PASSWORD, array(
        PDO::ATTR_EMULATE_PREPARES => false, 
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );
    // die(json_encode(array('outcome' => true)));
}
catch(PDOException $ex) {
    // failed connection
    die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
}