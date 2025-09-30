<?php
require_once 'config.php';

$platforms = ['PC', 'PlayStation', 'Xbox', 'Nintendo Switch', 'SteamDeck', 'Mobile'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "INSERT INTO games (title, platform, genre, release_year, price, is_completed, rating, purchase_date, notes) 
            VALUES (:title, :platform, :genre, :release_year, :price, :is_completed, :rating, :purchase_date, :notes)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':title' => $_POST['title'],
        ':platform' => $_POST['platform'],
        ':genre' => $_POST['genre'],
        ':release_year' => $_POST['release_year'],
        ':price' => $_POST['price'],
        ':is_completed' => isset($_POST['is_completed']) ? 1 : 0,
        ':rating' => $_POST['rating'],
        ':purchase_date' => $_POST['purchase_date'],
        ':notes' => $_POST['notes']
    ]);
    echo "jeu enregistré <br>";
}
else{
    echo "Jeu non enregistré";
}
?>

<h2>Ajouter un jeu</h2>
<form method="POST">
    Titre : <input type="text" name="title" require><br> 
    Plateforme :
    <select name="platform" require>
        <option value="">-- Toutes --</option>
        <?php foreach ($platforms as $p): ?>
            <option value="<?php echo $p ?>"><?php echo $p ?></option>
        <?php endforeach; ?>
    </select><br>
    Genre : <input type="text" name="genre"><br>
    Année de sortie : <input type="number" name="release_year" require><br>
    Prix : <input type="number" name="price" require><br>
    Note (1-5) : <input type="number" name="rating" min="1" max="5" require><br>
    Date d'achat : <input type="date" name="purchase_date"><br>
    Commentaire : <textarea name="notes"></textarea><br>
    Jeu terminé : <input type="checkbox" name="is_completed">
    <button type="submit">Ajouter</button>
</form>