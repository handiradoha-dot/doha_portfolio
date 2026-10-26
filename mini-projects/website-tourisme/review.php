<?php
 //delete
if (isset($_POST['cancel'])) {
    header("Location: index.php"); // or reservation.php
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$data = $_POST;

$errors = [];





// NAME
if (!isset($data['name']) || !preg_match("/^[a-zA-ZÀ-ÿ\s]{3,50}$/", $data['name'])) {
    $errors[] = "Invalid name";
}

// EMAIL
if (!isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email";
}

// DATE
if (!isset($data['date'])) {
    $errors[] = "Date required";
} else {
    $d = DateTime::createFromFormat('Y-m-d', $data['date']);
    if (!$d || $d->format('Y-m-d') !== $data['date']) {
        $errors[] = "Invalid date";
    }
}

// PEOPLE
if (!isset($data['people']) || !is_numeric($data['people'])) {
    $errors[] = "Invalid number of people";
} else {
    $people = (int)$data['people'];
    if ($people < 1 || $people > 20) {
        $errors[] = "People must be between 1 and 20";
    }
}

/*
   IF ERRORS → GO BACK
 */

if (!empty($errors)) {

    $query = http_build_query([ 
        
    
    /*converts an array into a url query string like ,
    ex: reservation.php?name=Ali&email=test@mail.com */


        "service_id" => $data['service_id'] ?? '',
        "name" => $data['name'] ?? '',
        "email" => $data['email'] ?? '',
        "date" => $data['date'] ?? '',
        "people" => $data['people'] ?? '',
        "error" => implode("|", $errors)
    ]);

    header("Location: reservation.php?$query");
    exit;
}

 
//   SAFE OUTPUT FUNCTION


function e($v) {
    return htmlspecialchars($v);
}

?>

<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

<h2>Review Your Reservation</h2>

<div class="card p-3 mb-3">

<p><strong>Name:</strong> <?= e($data['name']) ?></p>
<p><strong>Email:</strong> <?= e($data['email']) ?></p>
<p><strong>Date:</strong> <?= e($data['date']) ?></p>
<p><strong>People:</strong> <?= e($data['people']) ?></p>

</div>

<!-- EDIT -->
<form action="reservation.php" method="GET" class="d-inline">
    <input type="hidden" name="service_id" value="<?= e($data['service_id']) ?>">
    <input type="hidden" name="name" value="<?= e($data['name']) ?>">
    <input type="hidden" name="email" value="<?= e($data['email']) ?>">
    <input type="hidden" name="date" value="<?= e($data['date']) ?>">
    <input type="hidden" name="people" value="<?= e($data['people']) ?>">

    <button class="btn btn-warning">Edit</button>
</form>

<!-- CONFIRM -->
<form action="confirm.php" method="POST" class="d-inline">

<?php foreach($data as $k => $v): ?>
    <input type="hidden" name="<?= e($k) ?>" value="<?= e($v) ?>">
<?php endforeach; ?>

<button class="btn btn-success">Confirm</button>

</form>



<!--DELETE!-->

<form method="POST" class="d-inline">
    <input type="hidden" name="cancel" value="1">
    <button class="btn btn-danger">Cancel</button>
</form>
</div>

</body>
</html>