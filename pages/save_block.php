<?php
$id = $_GET['id'];
$users = json_decode(file_get_contents("../storage/users.json"), true);

foreach ($users as &$user){
    if ($user['id'] == $id){
        $user['block'] = true;

        echo $user['name'] . ' is block now';
    }
}
$jsonData = json_encode($users);
file_put_contents("../storage/users.json", $jsonData);
