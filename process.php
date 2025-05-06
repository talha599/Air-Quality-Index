<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background-color: #f9f9f9;
        }
        .receipt {
            width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 2px solid #333;
            background-color: white;
            border-radius: 10px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .field {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
        }
        .confirm {
            text-align: center;
            margin-top: 30px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            margin: 0 10px;
        }
        @media print {
            button {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="receipt">
    <h2>Are you Sure to Confirm your Registration?</h2>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name     = htmlspecialchars($_POST["uname"] ?? '');
        $email    = htmlspecialchars($_POST["email"] ?? '');
        $dob      = htmlspecialchars($_POST["dob"] ?? '');
        $country  = htmlspecialchars($_POST["country"] ?? '');
        $gender   = htmlspecialchars($_POST["gender"] ?? '');
        $color    = htmlspecialchars($_POST["color"] ?? '');
        $opinion  = htmlspecialchars($_POST["opinion"] ?? '');

        echo "<div class='field'><span class='label'>Name:</span> $name</div>";
        echo "<div class='field'><span class='label'>Email:</span> $email</div>";
        echo "<div class='field'><span class='label'>Date of Birth:</span> $dob</div>";
        echo "<div class='field'><span class='label'>Country:</span> $country</div>";
        echo "<div class='field'><span class='label'>Gender:</span> $gender</div>";
        echo "<div class='field'><span class='label'>Favorite Color:</span> <span style='display: inline-block; width: 20px; height: 20px; background-color: $color; border: 1px solid #000;'></span> ($color)</div>";
        echo "<div class='field'><span class='label'>Opinion:</span> <p>$opinion</p></div>";
    } else {
        echo "<p>No data received.</p>";
    }
    ?>

    <div class="confirm">
        <button onclick="alert('Your Registration Confirmed Successfully!')">Confirm</button>
        <button onclick="window.history.back()">Back</button>
    </div>
</div>

</body>
</html>
