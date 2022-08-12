<?php
include("connect.php");
$username = $_POST["username"];
$password = $_POST["password"];
$username = stripslashes($username);
$password = stripslashes($password);

$sql = "SELECT  * FROM Accounts WHERE username =  '" . $username . "'";
$result = executeQuery($sql);
if ($result->num_rows > 0){
    $row = $result->fetch_assoc();

    if(password_verify($password, $row["password"])) {
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        header("Location: adminArea.php");
    } else
        header("Location: ../login.html#err");
}else
    header("Location: ../login.html#err");

?>