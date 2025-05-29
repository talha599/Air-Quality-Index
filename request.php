<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['cities']) || count($_POST['cities']) !== 10) {
        echo "<p style='color:red;'>You must select exactly 10 cities.</p>";
    } else {
        echo "<h3>You selected the following 10 cities:</h3><ul>";
        foreach ($_POST['cities'] as $city) {
            echo "<li>" . htmlspecialchars($city) . "</li>";
        }
        echo "</ul>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Select 10 Cities</title>
    <script>
        function validateForm() {
            const checkboxes = document.querySelectorAll('input[name="cities[]"]:checked');
            if (checkboxes.length !== 10) {
                alert("Please select exactly 10 cities.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <h2>Select 10 Cities</h2>
    <form method="POST" action="showaqi.php" onsubmit="return validateForm();">
        <?php
        $cities = [
            "Tokyo, Japan",
            "Paris, France",
            "New York, USA",
            "London, UK",
            "Berlin, Germany",
            "Rome, Italy",
            "Cairo, Egypt",
            "Moscow, Russia",
            "Beijing, China",
            "Sydney, Australia",
            "Toronto, Canada",
            "Seoul, South Korea",
            "São Paulo, Brazil",
            "Istanbul, Turkey",
            "Bangkok, Thailand",
            "Nairobi, Kenya",
            "Dubai, UAE",
            "Mexico City, Mexico",
            "Mumbai, India",
            "Buenos Aires, Argentina"
        ];

        foreach ($cities as $city) {
            echo "<label><input type='checkbox' name='cities[]' value=\"$city\"> $city</label><br>";
        }
        ?>
        <br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>