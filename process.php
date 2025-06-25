<?php
session_start();

/* ----------  DATABASE SETTINGS  ---------- */
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "aqi";
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_error) {
    die("Database connection failed → " . $conn->connect_error);
}

/* ----------  FINAL CONFIRMATION STEP ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    if (empty($_SESSION['reg'])) {
        die("⚠️ No pending registration found.");
    }

    $d = $_SESSION['reg'];
    $name = $conn->real_escape_string($d['name']);
    $email = $conn->real_escape_string($d['email']);
    $password = $conn->real_escape_string($d['password']); // plain password
    $dob = $conn->real_escape_string($d['dob']);
    $country = $conn->real_escape_string($d['country']);
    $gender = $conn->real_escape_string($d['gender']);
    $opinion = $conn->real_escape_string($d['opinion']);

    $sql = "INSERT INTO users (name, email, password, dob, country, gender, opinion)
            VALUES ('$name', '$email', '$password', '$dob', '$country', '$gender', '$opinion')";

    if ($conn->query($sql)) {
        unset($_SESSION['reg']);
        header("Location: login.php?registered=1");
        exit;
    } else {
        echo "❌ Database error → " . $conn->error;
    }
    $conn->close();
    exit;
}

/* ----------  STORE REG DATA TO SESSION ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['reg'] = [
        'name'     => $_POST['name']     ?? '',
        'email'    => $_POST['email']    ?? '',
        'password' => $_POST['password'] ?? '',
        'dob'      => $_POST['dob']      ?? '',
        'country'  => $_POST['country']  ?? '',
        'gender'   => $_POST['gender']   ?? '',
        'opinion'  => $_POST['opinion']  ?? '',
        'color'    => $_POST['color']    ?? ''
    ];
    $d = $_SESSION['reg'];

    // Cookie for remember me
    if (isset($_POST['remember']) && $_POST['remember'] == '1') {
        setcookie('email', $d['email'], time() + (86400 * 30), "/"); // 30 days
    } else {
        setcookie('email', '', time() - 3600, "/");
    }

} else {
    if (!isset($_SESSION['reg'])) {
        die("Please submit the registration form first.");
    }
    $d = $_SESSION['reg'];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirm your registration</title>
    <style>
        body      { font-family: Arial, sans-serif; background: #f4f4f4; padding: 40px; }
        .box      { background: white; max-width: 600px; margin: auto; padding: 30px;
                    border-radius: 10px; box-shadow: 0 0 8px rgba(0,0,0,.15); }
        h2        { text-align: center; margin-top: 0; }
        .row      { margin-bottom: 12px; }
        .label    { font-weight: bold; display: inline-block; width: 140px; }
        .buttons  { text-align: center; margin-top: 25px; }
        button    { padding: 10px 24px; font-size: 15px; margin: 0 10px; cursor: pointer; }
    </style>
</head>
<body>
<div class="box">
    <h2>Are you sure you want to Confirm?</h2>

    <div class="row"><span class="label">Name:</span> <?= htmlspecialchars($d['name']) ?></div>
    <div class="row"><span class="label">Email:</span> <?= htmlspecialchars($d['email']) ?></div>
    <div class="row"><span class="label">Date of Birth:</span> <?= htmlspecialchars($d['dob']) ?></div>
    <div class="row"><span class="label">Country:</span> <?= htmlspecialchars($d['country']) ?></div>
    <div class="row"><span class="label">Gender:</span> <?= htmlspecialchars($d['gender']) ?></div>
    <div class="row">
        <span class="label">Favorite Color:</span>
        <span style="display: inline-block; width: 20px; height: 20px; background-color: <?= htmlspecialchars($d['color']) ?>; border: 1px solid #000;"></span>
        (<?= htmlspecialchars($d['color']) ?>)
    </div>
    <div class="row"><span class="label">Opinion:</span> <?= nl2br(htmlspecialchars($d['opinion'])) ?></div>

    <form method="post" class="buttons">
        <input type="hidden" name="confirm" value="1">
        <button type="submit">Confirm</button>
        <button type="button" onclick="history.back()">Back</button>
    </form>
</div>
</body>
</html>
