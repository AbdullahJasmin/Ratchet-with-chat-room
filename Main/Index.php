<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>


    <div class="container">
        <h1>WebSocket with ChatRoom</h1>
        <?php
        session_start();
        if (isset($_SESSION['Name'])) {
            echo "Logged in as " . $_SESSION['Name'];


            echo " <a href='http://localhost/kuppi/Ratchet-with-chat-room/Main/Logout.php'>Logout</a>";
        } else {
            echo "Not logged in ";
            echo "<a href='http://localhost/kuppi/Ratchet-with-chat-room/Main/Login.php'>Login</a>";
        }

        echo "
        <div class='container mt-4'>
            <div class='row'>
                <div class='col-6'>
        ";

        $con = new mysqli("localhost", "test", "test", "ratchet");
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        $sql = "SELECT * FROM User";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['Name'] != $_SESSION['Name']) {
                    echo "<button class='btn btn-primary rounded-pill shadow col-4 ' onclick='window.location.href = \"http://localhost/kuppi/Ratchet-with-chat-room/Main/chatroom.php?id=" . $row['UserId'] . "\"'>" . $row['Name'] . "</button>";
                }
            }
        } else {
            echo "No users";
        }
        echo "</div> </div> </div>";
        ?>
        <!-- <div class="row">
            <div class="col-6">
                <div class=" bg-light row p-3" id="chat-window">

                </div>
                <div id="form" class="row rounded-pill shadow">
                    <input class="col-8 rounded-pill  p-1 ps-3  border-0" id="comment-input" type="text"
                        placeholder="comment">
                    <button id="send-button" class="btn btn-primary rounded-pill shadow col-4 "
                        onclick="send()">Send</button>
                </div>
            </div>
        </div> -->

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
</body>

</html>