<?php

// logout
session_start();
session_destroy();
header("Location: http://localhost/kuppi/Ratchet-with-chat-room/Main/Index.php");
