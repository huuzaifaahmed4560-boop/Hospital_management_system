<?php
// ===============================
// Enable error reporting
// ===============================
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ===============================
// Include database connection
// ===============================
include '../config/db.php';  // db.php is in config folder

// ===============================
// ADD PATIENT
// ===============================
if (isset($_POST['add_patient'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $age = (int)$_POST['age'];
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    mysqli_query($conn, "INSERT INTO patients (name, age, gender, phone) VALUES ('$name','$age','$gender','$phone')");
}

// ===============================
// ADD DOCTOR
// ===============================
if (isset($_POST['add_doctor'])) {
    $doctor_name = mysqli_real_escape_string($conn, $_POST['doctor_name']);
    $specialization = mysqli_real_escape_string($conn, $_POST['specialization']);
    $doctor_phone = mysqli_real_escape_string($conn, $_POST['doctor_phone']);
    mysqli_query($conn, "INSERT INTO doctors (name, specialization, phone) VALUES ('$doctor_name','$specialization','$doctor_phone')");
}

// ===============================
// ADD MEDICINE
// ===============================
if (isset($_POST['add_medicine'])) {
    $medicine_name = mysqli_real_escape_string($conn, $_POST['medicine_name']);
    $price = (float)$_POST['price'];
    mysqli_query($conn, "INSERT INTO medicines (name, price) VALUES ('$medicine_name','$price')");
}

// ===============================
// ADD APPOINTMENT
// ===============================
if (isset($_POST['add_appointment'])) {
    $patient_id = (int)$_POST['patient_id'];
    $doctor_id = (int)$_POST['doctor_id'];
    $appointment_date = mysqli_real_escape_string($conn, $_POST['appointment_date']);
    $appointment_time = mysqli_real_escape_string($conn, $_POST['appointment_time']);
    mysqli_query($conn, "INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time) VALUES ('$patient_id','$doctor_id','$appointment_date','$appointment_time')");
}

// ===============================
// ADD PRESCRIPTION
// ===============================
if (isset($_POST['add_prescription'])) {
    $patient_id = (int)$_POST['patient_id'];
    $doctor_id = (int)$_POST['doctor_id'];
    $medicine_id = (int)$_POST['medicine_id'];
    mysqli_query($conn, "INSERT INTO prescriptions (patient_id, doctor_id, medicine_id) VALUES ('$patient_id','$doctor_id','$medicine_id')");
}

// ===============================
// ADD BILL
// ===============================
if (isset($_POST['add_bill'])) {
    $patient_id = (int)$_POST['patient_id'];
    $bill_date = mysqli_real_escape_string($conn, $_POST['bill_date']);
    $amount = (float)$_POST['amount'];
    mysqli_query($conn, "INSERT INTO bills (patient_id, bill_date, amount) VALUES ('$patient_id','$bill_date','$amount')");
}

// ===============================
// FETCH DATA
// ===============================
$patients_array = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM patients"), MYSQLI_ASSOC);
$doctors_array = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM doctors"), MYSQLI_ASSOC);
$medicines_array = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM medicines"), MYSQLI_ASSOC);
$appointments_array = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM appointments"), MYSQLI_ASSOC);
$prescriptions_array = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM prescriptions"), MYSQLI_ASSOC);
$bills_array = mysqli_fetch_all(mysqli_query($conn, "SELECT * FROM bills"), MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<title>Hospital Management System</title>
<style>
body { font-family: Arial; margin: 20px; }
h2 { margin-top: 40px; }
input, select { padding: 5px; margin: 4px; }
table { border-collapse: collapse; width: 100%; margin-top: 10px; }
table, th, td { border: 1px solid #000; }
th, td { padding: 6px; text-align: left; }
</style>
</head>
<body>

<h1>Hospital Management System</h1>

<!-- ================= PATIENTS ================= -->
<h2>Add Patient</h2>
<form method="POST">
    <input type="text" name="name" placeholder="Name" required>
    <input type="number" name="age" placeholder="Age" required>
    <select name="gender" required>
        <option>Male</option>
        <option>Female</option>
    </select>
    <input type="text" name="phone" placeholder="Phone" required>
    <input type="submit" name="add_patient" value="Add Patient">
</form>

<h3>All Patients</h3>
<table>
<tr><th>ID</th><th>Name</th><th>Age</th><th>Gender</th><th>Phone</th></tr>
<?php foreach($patients_array as $p) { ?>
<tr>
<td><?= $p['patient_id'] ?></td>
<td><?= $p['name'] ?></td>
<td><?= $p['age'] ?></td>
<td><?= $p['gender'] ?></td>
<td><?= $p['phone'] ?></td>
</tr>
<?php } ?>
</table>

<!-- ================= DOCTORS ================= -->
<h2>Add Doctor</h2>
<form method="POST">
    <input type="text" name="doctor_name" placeholder="Doctor Name" required>
    <input type="text" name="specialization" placeholder="Specialization" required>
    <input type="text" name="doctor_phone" placeholder="Phone" required>
    <input type="submit" name="add_doctor" value="Add Doctor">
</form>

<h3>All Doctors</h3>
<table>
<tr><th>ID</th><th>Name</th><th>Specialization</th><th>Phone</th></tr>
<?php foreach($doctors_array as $d) { ?>
<tr>
<td><?= $d['doctor_id'] ?></td>
<td><?= $d['name'] ?></td>
<td><?= $d['specialization'] ?></td>
<td><?= $d['phone'] ?></td>
</tr>
<?php } ?>
</table>

<!-- ================= MEDICINES ================= -->
<h2>Add Medicine</h2>
<form method="POST">
    <input type="text" name="medicine_name" placeholder="Medicine Name" required>
    <input type="number" name="price" placeholder="Price" required>
    <input type="submit" name="add_medicine" value="Add Medicine">
</form>

<h3>All Medicines</h3>
<table>
<tr><th>ID</th><th>Name</th><th>Price</th></tr>
<?php foreach($medicines_array as $m) { ?>
<tr>
<td><?= $m['medicine_id'] ?></td>
<td><?= $m['name'] ?></td>
<td><?= $m['price'] ?></td>
</tr>
<?php } ?>
</table>

<!-- ================= APPOINTMENTS ================= -->
<h2>Add Appointment</h2>
<form method="POST">
    <select name="patient_id" required>
        <option value="">Select Patient</option>
        <?php foreach($patients_array as $p) { ?>
        <option value="<?= $p['patient_id'] ?>"><?= $p['name'] ?></option>
        <?php } ?>
    </select>

    <select name="doctor_id" required>
        <option value="">Select Doctor</option>
        <?php foreach($doctors_array as $d) { ?>
        <option value="<?= $d['doctor_id'] ?>"><?= $d['name'] ?></option>
        <?php } ?>
    </select>

    <input type="date" name="appointment_date" required>
    <input type="time" name="appointment_time" required>
    <input type="submit" name="add_appointment" value="Add Appointment">
</form>

<h3>All Appointments</h3>
<table>
<tr><th>ID</th><th>Patient ID</th><th>Doctor ID</th><th>Date</th><th>Time</th></tr>
<?php foreach($appointments_array as $a) { ?>
<tr>
<td><?= $a['appointment_id'] ?></td>
<td><?= $a['patient_id'] ?></td>
<td><?= $a['doctor_id'] ?></td>
<td><?= $a['appointment_date'] ?></td>
<td><?= $a['appointment_time'] ?></td>
</tr>
<?php } ?>
</table>

<!-- ================= PRESCRIPTIONS ================= -->
<h2>Add Prescription</h2>
<form method="POST">
    <select name="patient_id" required>
        <option value="">Select Patient</option>
        <?php foreach($patients_array as $p) { ?>
        <option value="<?= $p['patient_id'] ?>"><?= $p['name'] ?></option>
        <?php } ?>
    </select>

    <select name="doctor_id" required>
        <option value="">Select Doctor</option>
        <?php foreach($doctors_array as $d) { ?>
        <option value="<?= $d['doctor_id'] ?>"><?= $d['name'] ?></option>
        <?php } ?>
    </select>

    <select name="medicine_id" required>
        <option value="">Select Medicine</option>
        <?php foreach($medicines_array as $m) { ?>
        <option value="<?= $m['medicine_id'] ?>"><?= $m['name'] ?></option>
        <?php } ?>
    </select>

    <input type="submit" name="add_prescription" value="Add Prescription">
</form>

<h3>All Prescriptions</h3>
<table>
<tr><th>ID</th><th>Patient ID</th><th>Doctor ID</th><th>Medicine ID</th></tr>
<?php foreach($prescriptions_array as $p) { ?>
<tr>
<td><?= $p['prescription_id'] ?></td>
<td><?= $p['patient_id'] ?></td>
<td><?= $p['doctor_id'] ?></td>
<td><?= $p['medicine_id'] ?></td>
</tr>
<?php } ?>
</table>

<!-- ================= BILLS ================= -->
<h2>Add Bill</h2>
<form method="POST">
    <select name="patient_id" required>
        <option value="">Select Patient</option>
        <?php foreach($patients_array as $p) { ?>
        <option value="<?= $p['patient_id'] ?>"><?= $p['name'] ?></option>
        <?php } ?>
    </select>
    <input type="date" name="bill_date" required>
    <input type="number" name="amount" placeholder="Amount" required>
    <input type="submit" name="add_bill" value="Add Bill">
</form>

<h3>All Bills</h3>
<table>
<tr><th>ID</th><th>Patient ID</th><th>Date</th><th>Amount</th></tr>
<?php foreach($bills_array as $b) { ?>
<tr>
<td><?= $b['bill_id'] ?></td>
<td><?= $b['patient_id'] ?></td>
<td><?= $b['bill_date'] ?></td>
<td><?= $b['amount'] ?></td>
</tr>
<?php } ?>
</table>

</body>
</html>
