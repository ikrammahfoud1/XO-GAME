<?php
session_start();
include 'connection.php';
session_unset();
header("Location: index.php"); /* Redirect browser */
exit();
session_destroy();
