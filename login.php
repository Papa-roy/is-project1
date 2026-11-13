<?php
session_start();
require 'db.php';
$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $u = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($u && password_verify($_POST['password'], $u['password'])) {
        $_SESSION['user'] = $u['username'];
        echo "<h2 style='font-family:Arial;color:green'>Welcome, " . htmlspecialchars($u['fullname']) . " (" . htmlspecialchars($u['username']) . ")! Login successful.</h2>";
        echo "<a href='feedback.php'>Go to feedback form</a>";
        exit;
    }
    $msg = "Invalid username or password.";
}
?>
<!DOCTYPE html>
<html><head><title>Login</title>
<style>
body{font-family:Arial;background:#eef2f7;display:flex;justify-content:center;padding-top:60px}
form{background:#fff;padding:30px;border-radius:8px;width:300px;box-shadow:0 2px 8px #0003}
input{width:100%;padding:8px;margin:6px 0 14px;box-sizing:border-box}
button{width:100%;padding:10px;background:#16a34a;color:#fff;border:0;border-radius:4px}
</style></head><body>
<form method="POST">
  <h2>Login</h2>
  <p style="color:red"><?= htmlspecialchars($msg) ?></p>
  <label>Username</label><input name="username" required>
  <label>Password</label><input type="password" name="password" required>
  <button type="submit">Login</button>
  <p><a href="signup.php">Create an account</a></p>
</form></body></html>
