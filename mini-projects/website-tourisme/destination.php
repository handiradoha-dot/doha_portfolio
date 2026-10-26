<?php
require_once("config/connexion.php");
$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM destination WHERE id = ?");
$stmt->execute([$id]);
$city = $stmt->fetch();

if(!$city){
    die("City not found");
}
?>

<!DOCTYPE html>
<html>
<head>
<title><?= $city['nom'] ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.hero{
    height:50vh;
    background:url('<?= $city['image_principale'] ?>') center/cover;
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    font-size:3rem;
    font-weight:bold;
    position:relative;
}
.overlay{
    position:absolute;
    inset:0;
    background:rgba(0,0,0,0.4);
}
.content{padding:40px;}
</style>
</head>

<body>

<div class="hero">
    <div class="overlay"></div>
    <div style="position:relative;"><?= $city['nom'] ?></div>
</div>

<div class="container content">

    <h3>About <?= $city['nom'] ?></h3>
    <p><?= $city['description'] ?></p>

    <!-- CHOOSE SERVICE TYPE -->
    <h4 class="mt-5">What are you looking for?</h4>

    <form action="services.php" method="GET">

        <input type="hidden" name="city_id" value="<?= $city['id'] ?>">

        <select name="type" class="form-select mt-2" required>
            <option value="restaurant">Restaurants</option>
            <option value="hotel">Hotels</option>
            <option value="both">Both</option>
        </select>

        <button class="btn btn-primary mt-3">Continue</button>






        
    </form>
      
</div>

</body>
</html>