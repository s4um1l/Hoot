<?php
    unset($_SESSION['userId']);
    unset($_SESSION['userName']);
    session_destroy();
?>