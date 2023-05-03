<?php
session_start();
unset($_SESSION["loggedin"]);
unset($_SESSION["admin_id"]);
unset($_SESSION["name"]);
header("Location:http://localhost/naukri/");
?>