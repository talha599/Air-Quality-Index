<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['cities']) || count($_POST['cities']) !== 10) {
        echo "<p style='color:red;'>You must select exactly 10 cities.</p>";
        echo "<p><a href='request.php'>Go back</a></p>";
        exit;
    }

    $selectedCities = $_POST['cities'];

    // --- Database Connection ---
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "aqi";

    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Extract city names only (remove country part for matching DB entries)
    $cleanCities = array_map(function($city) {
        return trim(explode(',', $city)[0]);
    }, $selectedCities);

    // Create placeholders for prepared statement
    $placeholders = implode(',', array_fill(0, count($cleanCities), '?'));
    $stmt = $conn->prepare("SELECT City, Country, AQI FROM infos WHERE City IN ($placeholders)");

    // Bind parameters
    $types = str_repeat('s', count($cleanCities));
    $stmt->bind_param($types, ...$cleanCities);

    $stmt->execute();
    $result = $stmt->get_result();

    // Display Results
    echo "<h2>AQI Data for Selected Cities</h2>";
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>City</th><th>Country</th><th>AQI</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . htmlspecialchars($row['City']) . "</td><td>" . htmlspecialchars($row['Country']) . "</td><td>" . htmlspecialchars($row['AQI']) . "</td></tr>";
    }

    echo "</table>";
    echo "<br><a href='request.php'>Go back</a>";

    $stmt->close();
    $conn->close();
} else {
    echo "<p>Invalid access. Please use the form.</p>";
    echo "<a href='request.php'>Go to form</a>";
}
?>