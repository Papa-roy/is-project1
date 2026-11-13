<?php
require 'db.php';
$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username,email,fullname,password) VALUES (?,?,?,?)");
    try {
        $stmt->execute([$_POST['username'], $_POST['email'], $_POST['fullname'], $hash]);
        $msg = "Registration successful! You can now log in.";
    } catch (PDOException $e) {
        $msg = "Error: that username already exists.";
    }
}
?>
<!DOCTYPE html>
<html><head><title>Sign Up</title>
<style>
body{font-family:Arial;background:#eef2f7;display:flex;justify-content:center;padding-top:60px}
form{background:#fff;padding:30px;border-radius:8px;width:300px;box-shadow:0 2px 8px #0003}
input{width:100%;padding:8px;margin:6px 0 14px;box-sizing:border-box}
button{width:100%;padding:10px;background:#2563eb;color:#fff;border:0;border-radius:4px}
</style></head><body>
<form method="POST">
  <h2>Sign Up</h2>
  <p><?= htmlspecialchars($msg) ?></p>
  <label>Username</label><input name="username" required>
  <label>Email</label><input type="email" name="email" required>
  <label>Full name</label><input name="fullname" required>
  <label>Password</label><input type="password" name="password" required>
  <button type="submit">Register</button>
  <p><a href="login.php">Already registered? Log in</a></p>
</form></body></html>
