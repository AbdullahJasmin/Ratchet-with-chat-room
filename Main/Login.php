<!DOCTYPE html>
<html lang="en">

<?php
session_start();
if (isset($_SESSION['Name'])) {
    header("Location: http://localhost/kuppi/Ratchet-with-chat-room/Main/Index.php");
} else {
    if (isset($_POST['username'])) {
        $uname = $_POST['username'];
        $pass = $_POST['password'];

        $con = new mysqli("localhost", "test", "test", "ratchet");

        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        $sql = "SELECT * FROM User WHERE username = '$uname' AND password = '$pass'";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc();
            $_SESSION['Name'] = $result['Name'];
            $_SESSION['Id'] = $result['UserId'];
            echo "Logged in";
            echo $_SESSION['Name'];
            header("Location: http://localhost/kuppi/Ratchet-with-chat-room/Main/Index.php");
        } else {
            echo "Wrong username or password";
        }
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    Sign in
    <form action="Login.php" method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <input type="submit" value="Login">
    </form>
</body>

</html>