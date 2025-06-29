<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>

    <style>
       
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            font-family: Arial, sans-serif;
        }
        .profile {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #ccc;
            background-color: lightgray;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
    
        .container {
            display: flex;
            width: 50%;
            height: 700px;
            margin-top: 20px;
            border: 2px solid black;
        }
    
        .left {
            flex: 1;
            border-right: 2px solid black;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: #a5eee9ad;
        }
    
        .right {
          flex: 1;
          display: flex;
          flex-direction: column;
       }

        .top {
          flex: 1.5;
          border-bottom: 2px solid black;
          display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
          background-color: #0099b733;
       }

       .bottom {
          flex: 2.5;
          background-color: #009dff52;
       }

    
       .registration {
            display: flex;
            flex-direction: column;
            width: 80%;
            margin-bottom: 10px;
        }
        .login{
            display: flex;
            flex-direction: column;
            width: 80%;
        }
        .registration button {
            padding: 8px;
            background-color: black;
            color: white;
            border: none;
            cursor: pointer;
        }
        
    </style>
        <?php
     session_start();
if (isset($_POST["login"])) {
    $conn = mysqli_connect("localhost", "root", "", "aqi");
    $email = $_POST['login_email'];
    $password = $_POST['login_password'];
    $res = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' and password='$password'");

    if (mysqli_num_rows($res) == 1) {
        $info = mysqli_fetch_assoc($res);
        if ($info) {
           
             $_SESSION['login_email'] = $email;
            $_SESSION['login_password'] = $password;
            header("Location: request.php"); // Uncomment when needed
            echo "<p style='color:green; text-align:center;'>Login successful.</p>";
            exit();
        }
    }

    echo "<p style='color:red; text-align:center;'>Invalid credentials.</p>";
}

?>
</head>
<body>
     
    <img class="profile" src="1.png" alt="Profile">
   <br>
    <h1>Air Quality Index</h1>
    <div class="container">
        <div class="left">
            <form class="registration" id="registrationForm" action="process.php" method="post">
                <h3>Registration</h3> <br>
                Name: <input type="text" id="name" name="name" placeholder="Full Name" required>
                Email: <input type="email" id="email" name="email" placeholder="User Email" required>
                Password: <input type="password" id="password" name="password" placeholder="Password" required>
                Confirm Password: <input type="password" id="confirmPassword" name="cpassword" placeholder="Confirm Password" required>
                Date of Birth: <input type="date" id="dob"name="dob" required>
                Country:
                <select id="country"name="country" required>
                    <option value="">Select Country</option>
                    <option value="USA">United States</option>
                    <option value="Canada">Canada</option>
                    <option value="UK">United Kingdom</option>
                    <option value="Bangladesh">Bangladesh</option>
                    <option value="Germany">Germany</option>
                    <option value="Australia">Australia</option>
                    <option value="France">France</option>
                    <option value="Japan">Japan</option>
                    <option value="China">China</option>
                    <option value="Brazil">Brazil</option>
                    <option value="South Africa">South Africa</option>
                    <option value="Mexico">Mexico</option>
                    <option value="Russia">Russia</option>
                    <option value="Italy">Italy</option>
                    <option value="Spain">Spain</option>
                    <option value="Netherlands">Netherlands</option>
                    <option value="South Korea">South Korea</option>
                    <option value="Saudi Arabia">Saudi Arabia</option>
                    <option value="Turkey">Turkey</option>
                    <option value="Argentina">Argentina</option>
                    <option value="Switzerland">Switzerland</option>
                </select>

                Gender:
                <label><input type="radio" name="gender" value="Male" name="gender"required> Male</label>
                <label><input type="radio" name="gender" value="Female"> Female </label>
                <label><input type="radio" name="gender" value="Other"> Other </label><br>

                Favorite Color: <input type="color" id="color"name="color"><br>

                Opinion: 
                <textarea rows="4" id="opinion"name="opinion" placeholder="Share your thoughts..."></textarea><br>

                <label>
                    <input type="checkbox" id="terms" required> I agree to the 
                    <a href="terms.html" target="_blank">Terms and Conditions</a>
                </label>
                <br>
                <button type="submit">Submit</button>
            
            </form>
            <script>
            const color = document.getElementById('color');
        color.addEventListener('change', function () {
            const selectedColor = this.value;
            document.querySelector('.background').style.background = selectedColor;
            document.cookie = `bg_color=${selectedColor}; path=/; max-age=${60 * 60 * 24 * 30}`;
        });
 
            </script>

        </div>
        <div class="right">
            <div class="top">
                <form class="login" id="loginForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

                    <h3>Login</h3>
                   Email: <input type="email" name="login_email" placeholder="User Email" required>
                   Password: <input type="password" name="login_password" placeholder="Password" required> <br>
                    <button type="submit"name="login">Login </button>
            </div>


        
            <div class="bottom" style="position: relative; overflow: hidden;">
                <!-- Overlay box -->
                <div style="
                    position: absolute;
                    top: 5%;
                    left: 10%;
                    width: 80%;
                    height: 60%;
                    align-items: center;
                    background-color: rgba(0, 0, 0, 0.5);
                    z-index: 1;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: rgb(255, 0, 0);
                    font-size: 24px;
                    font-weight: bold;
                ">
                    Login Required!!!
                </div>
            
                <!-- Table (beneath overlay) -->
                <h3 style="text-align: center; position: relative; z-index: 0;">City-wise Air Quality Index (AQI)</h3>
                <table style="width: 90%; margin: 0 auto; border-collapse: collapse; text-align: center; position: relative; z-index: 0;">
                    <thead>
                        <tr style="background-color: #ddd;">
                            <th style="border: 1px solid black; padding: 8px;">City</th>
                            <th style="border: 1px solid black; padding: 8px;">AQI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td style="border: 1px solid black; padding: 8px;"></td><td style="border: 1px solid black; padding: 8px;"></td></tr>
                        <tr><td style="border: 1px solid black; padding: 8px;"></td><td style="border: 1px solid black; padding: 8px;"></td></tr>
                        <tr><td style="border: 1px solid black; padding: 8px;"></td><td style="border: 1px solid black; padding: 8px;"></td></tr>
                        <tr><td style="border: 1px solid black; padding: 8px;"></td><td style="border: 1px solid black; padding: 8px;"></td></tr>
                        <tr><td style="border: 1px solid black; padding: 8px;"></td><td style="border: 1px solid black; padding: 8px;"></td></tr>
                        <tr><td style="border: 1px solid black; padding: 8px;"></td><td style="border: 1px solid black; padding: 8px;"></td></tr>
                        <tr><td style="border: 1px solid black; padding: 8px;"></td><td style="border: 1px solid black; padding: 8px;"></td></tr>
                        <tr><td style="border: 1px solid black; padding: 8px;"></td><td style="border: 1px solid black; padding: 8px;"></td></tr>
                        <tr><td style="border: 1px solid black; padding: 8px;"></td><td style="border: 1px solid black; padding: 8px;"></td></tr>
                        <tr><td style="border: 1px solid black; padding: 8px;"></td><td style="border: 1px solid black; padding: 8px;"></td></tr>
                    </tbody>
                </table>
            </div>
                    
        </div>
    </div>
    <script>
        document.getElementById('registrationForm').addEventListener('submit', function (e) {
            e.preventDefault();
    
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const dob = document.getElementById('dob').value;
            const country = document.getElementById('country').value;
            const gender = document.querySelector('input[name="gender"]:checked');
            const terms = document.getElementById('terms').checked;
    
            const namePattern = /^[A-Za-z.\-\s]+$/;
            const aiubEmailPattern = /^\d{2}-\d{5}-\d@student\.aiub\.edu$/;
            const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/;
    
            if (!name || !email || !password || !confirmPassword || !dob || !country || !gender || !terms) {
                alert("Please fill out all required fields.");
                return;
            }
    
            if (!namePattern.test(name)) {
                alert("Name can only contain letters, dots (.), dashes (-), and spaces.");
                return;
            }
    
            if (!aiubEmailPattern.test(email)) {
                alert("Email must be in the format: XX-XXXXX-X@student.aiub.edu");
                return;
            }
    
            if (password.length < 6) {
                alert("Password must be at least 6 characters long.");
                return;
            }
    
            if (!passwordPattern.test(password)) {
                alert("Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.");
                return;
            }
    
            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return;
            }
    
            const birthDate = new Date(dob);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
    
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
    
            if (age < 18) {
                alert("You must be at least 18 years old to register.");
                return;
            }
    
            alert("Submitted!");
            this.submit();
        });
    </script>
</body>
</html>