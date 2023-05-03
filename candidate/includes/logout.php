<?php
session_start();
unset($_SESSION["candidate_login"]);
unset($_SESSION["candidate_id"]);
unset($_SESSION["candidate_name"]);
unset($_SESSION["photo"]);
header("Location:http://localhost/naukri/");
?>