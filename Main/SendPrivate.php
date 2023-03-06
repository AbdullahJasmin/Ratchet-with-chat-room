<?php
session_start();
$_POST = json_decode(file_get_contents('php://input'), true);
$con = new mysqli("localhost", "test", "test", "ratchet");
if(!isset($_POST)){
    $array['Status']= "Post not set";
    echo json_encode($array);
    die();
}
$message = $_POST['message'];
$user = $_SESSION['Name'];
$roomId = $_POST['roomId'];

$sql = "INSERT INTO PersonalChatRecord (Connection, SentBy, Message) VALUES ('$roomId', '$user', '$message')";

$con->query($sql);
if ($con->affected_rows > 0) {
    // json encode sent
    $array['Status']= "Message sent";
    echo json_encode($array);
} else {

    $array['Status']= "Message not sent";
    echo json_encode($array);
}