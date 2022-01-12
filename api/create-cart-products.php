<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database file
include_once 'mongodb_config.php';

$dbname = 'db';
$collection = 'cart-products';

//DB connection
$db = new DbManager();
$conn = $db->getConnection();
$_POST = json_decode(file_get_contents("php://input"), true);

//record to add
$data = [
    'id' => $_POST["id"],
    'name' => $_POST["name"],
    'description' => $_POST["description"],
    'price' => $_POST["price"],
    'tax' => $_POST["tax"],
    'imageUrl' => $_POST["imageUrl"]
  ];

// insert record
if(!is_null($data["id"])) {
  $insert = new MongoDB\Driver\BulkWrite();
  $insert->insert($data);

  $result = $conn->executeBulkWrite("$dbname.$collection", $insert);

}

// verify
if ($result->getInsertedCount() == 1) {
    echo json_encode(
		array("message" => "Record successfully created")
	);
} else {
    echo json_encode(
            array("message" => "Error while saving record")
    );
}

?>