<?php
include "../config/db.php";

$sql = "
SELECT 
appointments.appointment_id,
patients.name AS patient_name,
doctors.name AS doctor_name,
appointments.appointment_date,
appointments.appointment_time
FROM appointments
JOIN patients ON appointments.patient_id = patients.patient_id
JOIN doctors ON appointments.doctor_id = doctors.doctor_id
";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Appointments</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<header>Hospital Management System</header>

<div class="container">
<h2>Appointments List</h2>

<a href="create.php" class="btn">+ Add Appointment</a>

<table>
<tr>
<th>ID</th>
<th>Patient</th>
<th>Doctor</th>
<th>Date</th>
<th>Time</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
<td><?= $row['appointment_id'] ?></td>
<td><?= $row['patient_name'] ?></td>
<td><?= $row['doctor_name'] ?></td>
<td><?= $row['appointment_date'] ?></td>
<td><?= $row['appointment_time'] ?></td>
<td class="action">
<a href="update.php?id=<?= $row['appointment_id'] ?>" class="edit">Edit</a>
<a href="delete.php?id=<?= $row['appointment_id'] ?>" class="delete">Delete</a>
</td>
</tr>
<?php } ?>
</table>
</div>

</body>
</html>
