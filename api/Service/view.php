<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../model/Service.php';

  $database = new Database();
  $db = $database->connect();

  $service = new Service($db);
  $result = $service->view();
  $num = $result->rowCount();

  if($num > 0) {
    $service_arr = array();
    $service_arr['data'] = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $service_item = array(
        'name' => $name,
        'price' => $price
      );
      array_push($service_arr['data'], $service_item);
    }
    echo json_encode($service_arr);

  } else {
    echo json_encode(
      array('message' => 'No services Found')
    );
  }