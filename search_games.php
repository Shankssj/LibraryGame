<?php
require_once 'config.php';

$platforms = ['PC', 'PlayStation', 'Xbox', 'Nintendo Switch', 'SteamDeck', 'Mobile'];

$sql = "SELECT * FROM games";
$conditions = [];
$params = [];

if (!empty($_GET['title'])) {
    $conditions[] = "title LIKE :title";
    $params[':title'] = '%' . $_GET['title'] . '%';
}

if (!empty($_GET['platform'])) {
    $conditions[] = "platform = :platform";
    $params[':platform'] = $_GET['platform'];
}

if (!empty($_GET['genre'])) {
    $conditions[] = "genre LIKE :genre";
    $params[':genre'] = '%' . $_GET['genre'] . '%';
}

if (!empty($_GET['finis'])) {
    $conditions[] = "is_completed = 1";
}

if (!empty($_GET['min_rating'])) {
    $conditions[] = "rating >= :rating";
    $params[':rating'] = (int)$_GET['min_rating'];
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$games = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Recherche de jeux</h2>
<form method="GET">
    Titre : <input type="text" name="title"><br>

    Plateforme :
    <select name="platform">
        <option value="">-- Toutes --</option>
        <?php foreach ($platforms as $p): ?>
            <option value="<?php echo $p ?>"><?php echo $p ?></option>
        <?php endforeach; ?>
    </select><br>

    Genre : <input type="text" name="genre"><br>

    <label><input type="checkbox" name="finis" value="1"> Jeux terminés uniquement</label><br>

    Note minimale :
    <select name="min_rating">
        <option value="">-- Aucune --</option>
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <option value="<?php echo $i ?>"><?= $i ?></option>
        <?php endfor; ?>
    </select><br><br>

    <button type="submit">Rechercher</button>
</form>

<h2>Liste des jeux</h2>
<ul>
    <?php foreach ($games as $game): ?>
        <li>
            <?php echo $game['title'] . " - " . $game['platform'] . " - " . $game['genre'] . " - " .  "Note : " . $game['rating'] . "/5" . " - " . "Terminé : " . ($game['is_completed'] ? 'Oui' : 'Non') ?>
        </li>
    <?php endforeach; ?>
</ul>