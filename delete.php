<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "employeeinformation";

$connection = new mysqli($servername, $username, $password, $database);

if (isset($_GET["Eid"])) {
    $Eid = $_GET["Eid"];
    $connection->query("DELETE FROM Loan WHERE Eid = '$Eid'");
    $connection->query("DELETE FROM EmployeeInfo WHERE Eid = '$Eid'");
}

header("Location: /employeeinformation/index.php?deleted=1");
exit;
?>
