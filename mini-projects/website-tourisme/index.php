<?php
require_once("config/connexion.php");

// Get search value
$search = $_GET['search'] ?? '';

// Prepare query
if (!empty($search)) {
    $stmt = $pdo->prepare("
        SELECT *
        FROM destination
        WHERE nom LIKE :search
        ORDER BY nom
    ");
    $stmt->execute([
        'search' => '%' . $search . '%'
    ]);
} else {
    $stmt = $pdo->query("
        SELECT *
        FROM destination
        ORDER BY nom
    ");
}

$destinations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Morocco Tourism</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f8f9fa;
}

.hero{
    background:#212529;
    color:white;
    padding:60px 20px;
    text-align:center;
}

.search-box{
    max-width:600px;
    margin:auto;
}

.city-card{
    transition:0.3s;
    cursor:pointer;
    height:100%;
}

.city-card:hover{
    transform:translateY(-5px);
}

.city-img{
    height:220px;
    object-fit:cover;
}

.city-name{
    font-weight:bold;
    font-size:1.4rem;
}

.theme-line{
    height:6px;
    border-radius:5px;
}

a{
    text-decoration:none;
    color:inherit;
}
</style>
</head>

<body>

<div class="hero">
    <h1>Discover Morocco</h1>
    <p>Explore cities, gastronomy and unique experiences</p>

    <div class="search-box mt-4">
        <form method="GET">
            <input
                type="text"
                name="search"
                class="form-control form-control-lg"
                placeholder="Search a city..."
                value="<?= htmlspecialchars($search) ?>"
                onkeyup="this.form.submit()"
            >
        </form>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">

        <?php if (count($destinations) > 0): ?>
            <?php foreach($destinations as $city): ?>

            <div class="col-md-6 col-lg-3">

                <a href="destination.php?id=<?= $city['id'] ?>">

                    <div class="card city-card shadow-sm">

                        <img
                            src="<?= $city['image_principale'] ?>"
                            class="card-img-top city-img"
                            alt="<?= $city['nom'] ?>"
                        >

                        <div
                            class="theme-line"
                            style="background:<?= $city['couleur_theme'] ?>"
                        ></div>

                        <div class="card-body">

                            <h5 class="city-name">
                                <?= $city['nom'] ?>
                            </h5>

                            <p class="card-text">
                                <?= substr($city['description'],0,100) ?>...
                            </p>

                        </div>

                    </div>

                </a>

            </div>

            <?php endforeach; ?>
        <?php else: ?>

            <div class="text-center">
                <p>No cities found.</p>
            </div>

        <?php endif; ?>

    </div>
</div>

</body>
</html>