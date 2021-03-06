<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/allies.php';

$database = new Database();
$db = $database->getConnection();
$ally = new Ally($db);
$server=isset($_GET["server"]) ? $_GET["server"] : "";
$stmt = $ally->clanlist($server);
$num = $stmt->rowCount();
 

if($num>0){
    $ally_arr=array();
    $ally_arr["records"]=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $ally_item=array(
          "clan" => $clan,
		  "server" => $server,
      );
 
        array_push($ally_arr["records"], $ally_item);
    }
 
    http_response_code(200);
    echo json_encode($ally_arr);
}
 
else{
    http_response_code(404);
    echo json_encode(
        array("message" => "No clans found.")
    );
}
?>