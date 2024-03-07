<?php
session_start();
include('../../database/db_connection.php');


// remove all the session data
session_destroy();

echo "<script>alert('logout success !!!');
    window.location.href= 'login.html';</script>";



?>