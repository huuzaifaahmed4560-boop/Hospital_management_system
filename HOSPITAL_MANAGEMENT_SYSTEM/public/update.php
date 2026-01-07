<?php
include "../config/db.php";

$id = $_GET['id'];

$appointment = mysqli_query($conn,"SELECT * FROM appointments WHERE appointment_id=$id");
$data = mysqli_fetch_assoc($appointment);

$patients = mysqli_query($conn,"SELECT * FROM patients");
$doctors  = mysqli_query($conn,"SELECT * FROM doctors");

if(isset($_POST['update'])){
    $patient_id = $_POST['patient_id'];
    $doctor_id  = $_POST['doctor_id'];
    $date       = $_POST['date'];
    $time       = $_POST['time'];

    mysqli_query($conn,"
    UPDATE appointments SET
    patient_id='$patient_id',
    doctor_id='$doctor_id',
    appointment_date='$date',
    appointment_time='$time'
    WHERE appointment_id=$id
    ");

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head><title>Update Appointment</title></head>
<body>

<h2>Update Appointment</h2>

<form method="post">

Patient:
<select name="patient_id">
<?php while($p=mysqli_fetch_assoc($patients)){ ?>
<option value="<?= $p['patient_id'] ?>" 
<?= $p['patient_id']==$data['patient_id']?'selected':'' ?>>
<?= $p['name'] ?>
</option>
<?php } ?>
</select><br><br>

Doctor:
<select name="doctor_id">
<?php while($d=mysqli_fetch_assoc($doctors)){ ?>
<option value="<?= $d['doctor_id'] ?>"
<?= $d['doctor_id']==$data['doctor_id']?'selected':'' ?>>
<?= $d['name'] ?>
</option>
<?php } ?>
</select><br><br>

Date: <input type="date" name="date" value="<?= $data['appointment_date'] ?>"><br><br>
Time: <input type="time" name="time" value="<?= $data['appointment_time'] ?>"><br><br>

<button type="submit" name="update">Update</button>
</form>

</body>
</html>
