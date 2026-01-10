<?php
include "../config/db.php";

$patients = mysqli_query($conn,"SELECT * FROM patients");
$doctors  = mysqli_query($conn,"SELECT * FROM doctors");

if(isset($_POST['submit'])){
    $patient_id = $_POST['patient_id'];
    $doctor_id  = $_POST['doctor_id'];
    $date       = $_POST['date'];
    $time       = $_POST['time'];

    mysqli_query($conn,"
    INSERT INTO appointments
    (patient_id, doctor_id, appointment_date, appointment_time)
    VALUES
    ('$patient_id','$doctor_id','$date','$time')
    ");

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Appointment</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<header>Hospital Management System</header>

<div class="container">
<h2>Add Appointment</h2>

<form method="post">

<label>Patient</label>
<select name="patient_id" required>
<?php while($p=mysqli_fetch_assoc($patients)){ ?>
<option value="<?= $p['patient_id'] ?>"><?= $p['name'] ?></option>
<?php } ?>
</select>

<label>Doctor</label>
<select name="doctor_id" required>
<?php while($d=mysqli_fetch_assoc($doctors)){ ?>
<option value="<?= $d['doctor_id'] ?>"><?= $d['name'] ?></option>
<?php } ?>
</select>

<label>Date</label>
<input type="date" name="date" required>

<label>Time</label>
<input type="time" name="time" required>

<button type="submit" name="submit">Save Appointment</button>

</form>
</div>

</body>
</html>
