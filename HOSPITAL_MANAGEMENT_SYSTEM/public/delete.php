<?php
include "../config/db.php";

$id = $_GET['id'];
mysqli_query($conn,"DELETE FROM appointments WHERE appointment_id=$id");

header("Location: index.php");
?>
