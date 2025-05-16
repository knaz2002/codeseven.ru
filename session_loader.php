<?php
session_start();

if(isset($_GET['session_loader_start'])) {
  $_SESSION['session_loader'] = true;

  return;
}

if(isset($_GET['is_session_loader'])) {
  if($_SESSION['session_loader'] == true) {
    echo json_encode(['isSession' => true]);

    return;
  } else {
    echo json_encode(['isSession' => false]);

    return;
  }
}
?>