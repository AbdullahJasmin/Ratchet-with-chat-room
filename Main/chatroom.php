<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatRoom</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>

    <?php

    session_start();
    $con = new mysqli("localhost", "test", "test", "ratchet");

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $to = $_GET['id'];
    $from = $_SESSION['Id'];
    $roomid = 0;

    echo "From: " . $from;
    echo "To: " . $to;

    $user = $_SESSION['Name'];

    echo $_SESSION['Name'];
    $sql = "SELECT * FROM PersonalChat WHERE FromUser = '$from' AND ToUser = '$to' OR FromUser = '$to' AND ToUser = '$from'";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $roomid = $row['ChatId'];
        }
    } else {
        $sql = "INSERT INTO PersonalChat (FromUser, ToUser) VALUES ('$from', '$to')";
        $con->query($sql);
        if ($con->affected_rows > 0) {
            echo "Chat created";
            // header("Location: http://localhost/kuppi/Ratchet-with-chat-room/Main/chatroom.php?id=".$to);
        } else {
            echo "Chat not created";
        }
    }

    if ($roomid != 0) {


        echo "
    <div class='container mt-4'>
        <div class='row'>
            <div class='col-6'>
                <div class=' bg-light row p-3' id='chat-window'>
    ";

        $sql = "SELECT * FROM PersonalChatRecord WHERE Connection = $roomid";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['SentBy'] == $_SESSION['Name']) {
                    echo "<div class='bg-white  ms-auto col-6 rounded-pill p-1 ps-3 shadow border-0 m-1'>";
                    echo $row['SentBy'];
                    echo " : ";
                    echo $row['Message'];
                    echo " : ";
                    echo $row['Date'];
                    echo "</div>";
                } else {
                    echo "<div class='bg-white col-6 rounded-pill p-1 ps-3 shadow border-0 m-1'>";
                    echo $row['SentBy'];
                    echo " : ";
                    echo $row['Message'];
                    echo " : ";
                    echo $row['Date'];
                    echo "</div>";
                } 
            }
        }

        echo "
                </div>
                <div id='typing'></div>
                <div id='form' class='row rounded-pill shadow'>
                    <input class='col-8 rounded-pill  p-1 ps-3  border-0' onkeyup='typing()' id='comment-input' type='text'
                        placeholder='comment'>
                    <button id='send-button' class='btn btn-primary rounded-pill shadow col-4 '
                        onclick='send()'>Send</button>
                </div>
            </div>
        </div>
    </div>
    ";

    }

    ?>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>


    <script>
        var conn = new WebSocket('ws://localhost:8080');
        conn.onopen = function (e) {
            console.log('Connection established!');
            conn.send(JSON.stringify({
                'newRoute': 'Personalchat-<?= $roomid ?>'
            }));

        };

        // conn.onmessage = function (e) {
        //     console.log(e.data);
        //     var chatWindow = document.getElementById('chat-window');
        //     var newMessage = document.createElement('p');
        //     newMessage.innerHTML = e.data;
        //     newMessage.classList.add(
        //         'bg-white',
        //         'col-6',
        //         'rounded-pill',
        //         'p-1',
        //         'ps-3',
        //         'shadow',
        //         'border-0',
        //         'm-1'
        //     );
        //     chatWindow.appendChild(newMessage);

        // };

        let timeoutHandle = window.setTimeout(function(){ 
            document.getElementById('comment-typing-$PostId').innerHTML = '';
        }, 2000);
        
        function typing(){
            conn.send(JSON.stringify({
                'typing': 'y',
                'name': '<?= $user ?>'
            }));
        }


        conn.onmessage = function (e) {
            let data = JSON.parse(e.data);
            console.log(data);
            if (typeof data.msg !== 'undefined') {

                // document.getElementById('typing').innerHTML = '';
                // let commentElem = document.createElement('div');
                // commentElem.classList.add('col-11');
                // commentElem.classList.add('fill-container');
                // commentElem.innerHTML = \"<div class='row  no-gap padding-3 bg-white shadow-small border-rounded'><div class='col-12 fill-container left small bold'>\" + data.name + \"</div><div class='col-12 wordwrap fill-container left padding-bottom-2 '>\" + data.msg + \"</div><div class='col-12 fill-container right small grey '>\" +data.date + \"</div></div>\";

                var chatWindow = document.getElementById('chat-window');

                var newMessage = document.createElement('p');
                newMessage.innerHTML = data.name + " : " + data.msg + " " + data.date;
                newMessage.classList.add(
                    'bg-white',
                    'col-6',
                    'rounded-pill',
                    'p-1',
                    'ps-3',
                    'shadow',
                    'border-0',
                    'm-1'
                );
                chatWindow.appendChild(newMessage);
                document.getElementById('chat-window').appendChild(commentElem);
            }
            else if (typeof data.typing !== 'undefined') {
                document.getElementById('typing').innerHTML = data.name + " is typing...";
                window.clearTimeout(timeoutHandle);
                timeoutHandle = window.setTimeout(function () {
                    document.getElementById('typing').innerHTML = '';
                }, 2000);
            }
        };
        var input = document.getElementById('comment-input');
        input.addEventListener("keypress", function (event) {
            if (event.key === "Enter") {
                event.preventDefault();
                document.getElementById("send-button").click();
            }
        });

        function send() {
            <?php
            $datesent = date('M d, Y h.i A');
            $commentor = $_SESSION['Name'];
            ?>
            conn.send(JSON.stringify({
                'msg': input.value,
                'name': '<?= $commentor ?>',
                'date': '<?= $datesent ?>'
            }));

            sendMessage(input.value, '<?= $roomid ?>');

            var chatWindow = document.getElementById('chat-window');
            var newMessage = document.createElement('p');
            newMessage.classList.add(
                'bg-white',
                'ms-auto',
                'col-6',
                'rounded-pill',
                'p-1',
                'ps-3',
                'shadow',
                'border-0',
                'm-1'
            );
            newMessage.innerHTML = '<?= $commentor ?>' + " : " + input.value + " " + '<?= $datesent ?>';
            chatWindow.appendChild(newMessage);
            input.value = '';
        }

        function sendMessage(comment, room) {
            let data = {
                'message': comment,
                'roomId': room
            };
            fetch('http://localhost/kuppi/Ratchet-with-chat-room/Main/SendPrivate.php', {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        }).then(response => response.json())
            .then(json => { 
                console.log(json);
            });
        }

    </script>

</body>

</html>



