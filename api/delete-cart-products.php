<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database file
include_once 'mongodb_config.php';

$dbname = 'db';
$collection = 'cart-products';

//DB connection
$db = new DbManager();
$conn = $db->getConnection();


//get _id field value
$id = $_GET["id"];


// delete record
$delete = new MongoDB\Driver\BulkWrite();
$delete->delete(
	['_id' => new MongoDB\BSON\ObjectId($id)],
	['limit' => 0]
);

$result = $conn->executeBulkWrite("$dbname.$collection", $delete);

// verify
if ($result->getDeletedCount() == 1) {
    echo json_encode(
		array("message" => "Record successfully deleted")
	);
} else {
    echo json_encode(
            array("message" => "Error while deleting record")
    );
}

?>