<?php
session_start();

/* ----------  DATABASE SETTINGS  ---------- */
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "aqi";
/* ----------------------------------------- */

/* ----------  CONNECT TO MYSQL  ----------- */
$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_error) {
    die("Database connection failed → " . $conn->connect_error);
}
/* ----------------------------------------- */

/* ----------  STEP 2: CONFIRM CLICKED  ----- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    if (empty($_SESSION['reg'])) {
        die("⚠️ No pending registration found.");
    }

    $d = $_SESSION['reg'];
    $stmt = $conn->prepare(
        "INSERT INTO user (name, email, password, dob, country, gender, opinion)
         VALUES (?, ?, ?, ?, ?, ?, ?)"
    );
    if (!$stmt) {
        die("Prepare failed → " . $conn->error);
    }

    $hashed = password_hash($d['password'], PASSWORD_DEFAULT);

    $stmt->bind_param(
        "sssssss",
        $d['name'], $d['email'], $hashed,
        $d['dob'], $d['country'], $d['gender'], $d['opinion']
    );

    if ($stmt->execute()) {
        unset($_SESSION['reg']);
        header("Location: lo
        gin.php?registered=1");
        exit;
    } else {
        echo "❌ Database error → " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['reg'] = [
        'name'     => $_POST['name']     ?? '',
        'email'    => $_POST['email']    ?? '',
        'password' => $_POST['password'] ?? '',
        'dob'      => $_POST['dob']      ?? '',
        'country'  => $_POST['country']  ?? '',
        'gender'   => $_POST['gender']   ?? '',
        'opinion'  => $_POST['opinion']  ?? '',
        'color'    => $_POST['color']    ?? '' // not stored in DB, only for display
    ];
    $d = $_SESSION['reg'];
        // Set cookie if 'Remember Me' is checked
    if (isset($_POST['remember']) && $_POST['remember'] == '1') {
        setcookie('email', $email, time() + (86400 * 30), "/"); // 30 days
    } else {
        // Delete cookie if not checked
        setcookie('email', '', time() - 3600, "/");
    }

} else {
    if (!isset($_SESSION['reg'])) {
        die("Please submit the registration form first.");
    }
    $d = $_SESSION['reg'];
}
/* ----------  END STEP 1  ----------------- */
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
