<?php
header('Access-Control-Allow-Origin: *');

$users = array
(
  array('name' =>'Dimi','email'=>'dimi@grupow.com.br'),
  array('name' =>'Walter','email'=>'walter@grupow.com.br'),
  array('name' =>'Marcos','email'=>'marcos@grupow.com.br')
);

echo json_encode($users);

