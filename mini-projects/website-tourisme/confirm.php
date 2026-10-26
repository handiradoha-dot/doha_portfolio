<?php
require_once("config/connexion.php");

$stmt = $pdo->prepare("
INSERT INTO reservations
(service_id, name, email, date_reservation, people)
VALUES (?,?,?,?,?)
");

$stmt->execute([
    $_POST['service_id'],
    $_POST['name'],
    $_POST['email'],
    $_POST['date'],
    $_POST['people']
]);
?>

<h2>Reservation confirmed ✔</h2>
<a href="index.php">Back home</a>