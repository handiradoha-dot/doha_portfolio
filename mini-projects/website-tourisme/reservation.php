<?php
$service_id = $_GET['service_id'] ?? 0;

$errors = [];

// Keep old values if form returns error
$name = $_GET['name'] ?? '';
$email = $_GET['email'] ?? '';
$date = $_GET['date'] ?? '';
$people = $_GET['people'] ?? '';

if (isset($_GET['error'])) {
    $errors = explode("|", $_GET['error']);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Reservation</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

<h2>Reservation Form</h2>

<!-- ERRORS -->
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
            <p class="mb-0"><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form action="review.php" method="POST" class="card p-4">

    <input type="hidden" name="service_id" value="<?= $service_id ?>">

    <!-- NAME -->
     <label for="nom"> NAME:</label>
    <input type="text"
           name="name"
           class="form-control mb-2"
           placeholder="Name"
           value="<?= htmlspecialchars($name) ?>"
           required> <br> <br>

    <!-- EMAIL -->
     <label for="email">EMAIL:</label>
    <input type="text"
           name="email"
           class="form-control mb-2"
           placeholder="Email"
           value="<?= htmlspecialchars($email) ?>"
           required>  <br> <br>

    <!-- DATE -->
     <label for="date">DATE:</label>
    <input type="date"
           name="date"
           class="form-control mb-2"
           value="<?= htmlspecialchars($date) ?>"
           required>  <br> <br>

    <!-- PEOPLE -->
     <label for="people"> NUMBER OF PEOPLE:</label> 
    <input type="number"
           name="people"
           class="form-control mb-2"
           value="<?= htmlspecialchars($people) ?>"
           required>  <br> <br>

    <button class="btn btn-primary">Continue</button>

</form>

</div>

</body>
</html>