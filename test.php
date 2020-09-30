<?php 

 $update = json_decode(file_get_contents("php://input"), true);

$chat_id = 1164076579;
$name = $update["message"]["chat"]["first_name"];

file_get_contents("https://api.telegram.org/bot1210455223:AAEK6SrKXgxWjtQpv1uBVAI7-B41zohuIVw/sendMessage?chat_id=$chat_id&text=$name");

 ?>