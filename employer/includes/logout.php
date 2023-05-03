<?php
session_start();
unset($_SESSION["login"]);
unset($_SESSION["company_id"]);
unset($_SESSION["cname"]);
unset($_SESSION["logo"]);
header("Location:http://localhost/naukri/");
?>