<?php
require 'db.php';
$ok = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO feedback (name,email,message) VALUES (?,?,?)");
    $stmt->execute([$_POST['name'], $_POST['email'], $_POST['message']]);
    $ok = true;
}
$rows = $pdo->query("SELECT * FROM feedback ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html><head><title>Feedback</title>
<style>
body{font-family:Arial;margin:40px}
input,textarea{display:block;width:320px;padding:8px;margin:6px 0}
button{padding:10px 20px;background:#7c3aed;color:#fff;border:0;border-radius:4px}
table{border-collapse:collapse;margin-top:20px}
td,th{border:1px solid #999;padding:6px 10px}
</style></head><body>
<h2>Feedback Form</h2>
<?php if ($ok) echo "<p style='color:green'>Thanks, your feedback was saved!</p>"; ?>
<form method="POST">
  <input name="name" placeholder="Your name" required>
  <input type="email" name="email" placeholder="Email" required>
  <textarea name="message" placeholder="Message" required></textarea>
  <button type="submit">Submit</button>
</form>
<h3>Submitted feedback</h3>
<table>
<tr><th>ID</th><th>Name</th><th>Email</th><th>Message</th><th>Time</th></tr>
<?php foreach ($rows as $r): ?>
<tr><td><?= $r['id'] ?></td><td><?= htmlspecialchars($r['name']) ?></td>
<td><?= htmlspecialchars($r['email']) ?></td><td><?= htmlspecialchars($r['message']) ?></td>
<td><?= $r['submitted_at'] ?></td></tr>
<?php endforeach; ?>
</table></body></html>
