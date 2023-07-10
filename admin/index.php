<?php
session_start();

// Array asumsi pengguna
$users = [
    'admin' => 'admin',
];

// Fungsi untuk memeriksa kecocokan username dan password
function authenticate($username, $password) {
    global $users;
    return isset($users[$username]) && $users[$username] === $password;
}

// Proses login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (authenticate($username, $password)) {
        // Login berhasil, simpan informasi pengguna dalam sesi
        $_SESSION['username'] = $username;
        header('Location: dashboard.php'); // Ganti dengan halaman yang sesuai
        exit();
    } else {
        $error = 'Username atau password salah.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
    </style>
</head>
<body>
    <div class="container login-container">
        <div class="col-md-6">
            <h2>Login</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" name="username" id="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <div class="input-group">
                        <input type="password" class="form-control" name="password" id="password" required>
                        <div class="input-group-append">
                            <span class="input-group-text" id="togglePassword">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#togglePassword").click(function() {
                var passwordField = $("#password");
                var fieldType = passwordField.attr("type");
                
                if (fieldType === "password") {
                    passwordField.attr("type", "text");
                    $("#togglePassword i").removeClass("fa-eye").addClass("fa-eye-slash");
                } else {
                    passwordField.attr("type", "password");
                    $("#togglePassword i").removeClass("fa-eye-slash").addClass("fa-eye");
                }
            });
        });
    </script>
</body>
</html>
