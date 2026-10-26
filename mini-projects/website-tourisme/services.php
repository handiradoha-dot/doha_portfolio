
<style>
/* PAGE BACKGROUND */
body {
    background: #f5f7fb;
}

/* FORM STYLE */
form {
    background: #ffffff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

/* SELECT INPUT */
form select {
    border-radius: 8px;
    padding: 8px;
}

/* CARD CUSTOMIZATION (override Bootstrap) */
.card {
    border: none;
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s ease;
}

/* HOVER EFFECT */
.card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.15) !important;
}

/* IMAGE FIX */
.card-img-top {
    transition: transform 0.3s ease;
}

.card:hover .card-img-top {
    transform: scale(1.05);
}

/* CARD TITLE */
.card-body h5 {
    font-weight: 600;
    margin-bottom: 10px;
}

/* TEXT STYLE */
.card-body p {
    font-size: 14px;
    color: #555;
    margin-bottom: 6px;
}

/* PRICE STYLE */
.card-body p strong {
    color: #222;
}

/* FOOTER BUTTON */
.card-footer {
    background: white;
    border-top: none;
    padding: 15px;
}

.card-footer .btn {
    border-radius: 10px;
    font-weight: 500;
}

/* GRID SPACING IMPROVEMENT */
.row {
    margin-top: 20px;
}
</style>

<?php
require_once("config/connexion.php");
$city_id = $_GET['city_id'] ?? 0;
$type = $_GET['type'] ?? 'both';
$food_type = $_GET['food_type'] ?? '';
?>


<?php if($type == 'restaurant' || $type == 'both'): ?>

<form method="GET" class="mb-4">

    <input type="hidden" name="city_id" value="<?= $city_id ?>">
    <input type="hidden" name="type" value="<?= $type ?>">

    <label class="form-label">Food Preference</label>

    <select name="food_type" class="form-select">

        <option value="">All</option>
        <option value="seafood">Seafood</option>
        <option value="traditional">Traditional Moroccan</option>
        <option value="international">International</option>
        <option value="cafe">Cafe</option>

    </select>

    <button class="btn btn-primary mt-3">
        Search
    </button>

</form>

<?php endif; ?>



<?php

$sql = "
SELECT *
FROM services
WHERE destination_id = ?
";

$params = [$city_id];

if($type != 'both')
{
    $sql .= " AND type = ?";
    $params[] = $type;
}

if($food_type != '')
{
    $sql .= " AND food_type = ?";
    $params[] = $food_type;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>




<div class="row">

<?php foreach($services as $service): ?>

<div class="col-md-4 mb-4">

    <div class="card h-100 shadow">

        <img
            src="<?= $service['image'] ?>"
            class="card-img-top"
            style="height:220px;object-fit:cover;"
        >

        <div class="card-body">

            <h5><?= $service['nom'] ?></h5>

            <p><?= $service['description'] ?></p>

            <p>
                <strong>Type:</strong>
                <?= ucfirst($service['type']) ?>
            </p>

            <p>
                <strong>Price:</strong>
                <?= $service['prix'] ?> DH
            </p>

            <?php if($service['type'] == 'restaurant'): ?>

            <p>
                <strong>Food:</strong>
                <?= ucfirst($service['food_type']) ?>
            </p>

            <?php endif; ?>

        </div>

        <div class="card-footer">

            <a
                href="reservation.php?service_id=<?= $service['id'] ?>"
                class="btn btn-success w-100"
            >
                Reserve
            </a>

        </div>

    </div>

</div>

<?php endforeach; ?>

</div>