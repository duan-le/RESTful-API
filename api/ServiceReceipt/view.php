<?php
  session_start();
  
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../model/ServiceReceipt.php';

  if (isset($_SESSION['user_id'])
    && isset($_SESSION['user_type'])
    && $_SESSION['user_type'] == 'admin'
  ) {
    $database = new Database();
    $db = $database->connect();
    $service_receipt = new ServiceReceipt($db);

    $result = $service_receipt->view();
    $num = $result->rowCount();
    $rows = $result->fetchAll(\PDO::FETCH_ASSOC);
    if($num > 0) echo json_encode($rows);
    else echo json_encode(array('message' => 'No Service Receipt Found'));
  } else {
    http_response_code(401);
    echo json_encode(array('message' => 'You Are Not Authorized'));
  }
