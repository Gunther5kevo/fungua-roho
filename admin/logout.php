<?php
include 'functions.php';
session_start();  

if (isset($_SESSION['auth'])) {
    logoutSession();  
    redirect('../front/login.php', 'Logged Out Successfully');  
}

