<?php include('db.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login/Register - MSOMBA PHONE POINT</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .auth-container { max-width: 400px; margin: 100px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .auth-container h2 { text-align: center; margin-bottom: 20px; color: #ff4757; }
        .form-group { margin-bottom: 15px; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; }
        .auth-btn { width: 100%; padding: 12px; background: #2f3542; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        .auth-btn:hover { background: #ff4757; }
        .toggle-link { text-align: center; margin-top: 15px; }
        .toggle-link a { color: #ff4757; text-decoration: none; font-weight: bold; }
        .error-msg { color: red; font-size: 0.9rem; margin-bottom: 10px; text-align: center; }
        .success-msg { color: green; font-size: 0.9rem; margin-bottom: 10px; text-align: center; }
    </style>
</head>
<body>

<div class="auth-container" id="loginBox">
    <h2>Login</h2>
    <?php
    // Login Logic
    // Replace your existing Login Logic with this:
if(isset($_POST['login_user'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if(password_verify($password, $user['password'])) {
            // Set Sessions
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; // Save the role!

            // Redirect based on role
            if($user['role'] == 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else { echo "<p class='error-msg'>Wrong password!</p>"; }
    } else { echo "<p class='error-msg'>User not found!</p>"; }
}
    ?>
    <form method="POST">
        <div class="form-group"><input type="email" name="email" placeholder="Email Address" required></div>
        <div class="form-group"><input type="password" name="password" placeholder="Password" required></div>
        <button type="submit" name="login_user" class="auth-btn">Login</button>
    </form>
    <div class="toggle-link">Don't have an account? <a href="#" onclick="showRegister()">Register here</a></div>
</div>

<div class="auth-container" id="registerBox" style="display:none;">
    <h2>Register</h2>
    <div id="jsError" class="error-msg"></div>
    <?php
    // Registration Logic
    if(isset($_POST['register_user'])) {
        $user = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $contact = mysqli_real_escape_string($conn, $_POST['contact']);
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // PHP Validation for Phone
        if(!preg_match("/^(06|07)[0-9]{8}$/", $contact)) {
            echo "<p class='error-msg'>Incorrect contact number. Must start with 06/07 and be 10 digits.</p>";
        } else {
            $sql = "INSERT INTO users (username, email, contact, password) VALUES ('$user', '$email', '$contact', '$pass')";
            if(mysqli_query($conn, $sql)) {
                echo "<p class='success-msg'>Registration successful! Please Login.</p>";
            }
        }
    }
    ?>
    <form method="POST" onsubmit="return validateContact()">
        <div class="form-group"><input type="text" name="username" placeholder="Full Name" required></div>
        <div class="form-group"><input type="email" name="email" placeholder="Email Address" required></div>
        <div class="form-group"><input type="text" id="contactField" name="contact" placeholder="Contact (e.g. 0712345678)" required></div>
        <div class="form-group"><input type="password" name="password" placeholder="Create Password" required></div>
        <button type="submit" name="register_user" class="auth-btn">Register</button>
    </form>
    <div class="toggle-link">Already have an account? <a href="#" onclick="showLogin()">Login here</a></div>
</div>

<script>
    function showRegister() {
        document.getElementById('loginBox').style.display = 'none';
        document.getElementById('registerBox').style.display = 'block';
    }
    function showLogin() {
        document.getElementById('registerBox').style.display = 'none';
        document.getElementById('loginBox').style.display = 'block';
    }

    function validateContact() {
        const contact = document.getElementById('contactField').value;
        const pattern = /^(06|07)[0-9]{8}$/;
        if(!pattern.test(contact)) {
            document.getElementById('jsError').innerText = "Incorrect contact number! Must start with 06 or 07 and have 10 digits.";
            return false;
        }
        return true;
    }
</script>
</body>
</html>