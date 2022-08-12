<?php
session_start();
$_SESSION = array();
session_destroy();
echo "Logged out, redirecting....";
echo "<script>window.location.href='../index.php'</script>";