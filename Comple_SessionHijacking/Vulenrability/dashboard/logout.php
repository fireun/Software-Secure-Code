<?php
session_start();
include('../../database/db_connection.php');

echo "<script>alert('logout success !!!');
    window.location.href= 'login.html';</script>";



?>