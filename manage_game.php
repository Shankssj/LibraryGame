<?php
require_once 'config.php';

if (!empty($_GET['id'])) {
    
    $id = $_GET['id'];
    $sql = "SELECT * FROM games WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $game = $stmt->fetch(PDO::FETCH_ASSOC);
} ?>

<table>
    <tr>
        <th>Titre</th>
        <th>Plateforme</th>
        <th>Genre</th>
        <th>Note</th>
        <th>Statut</th>
        <th>Année de sortie</th>
        <th>Prix</th>
        <th>Date d'achat</th>
        <th>Commentaire</th>
        <th>Créé à</th>
    </tr>
    <tr>
        <td><?php echo $game['title'] ?></td>
        <td><?php echo $game['platform'] ?></td>
        <td><?php echo $game['genre'] ?></td>
        <td><?php echo $game['rating'] ?>/5</td>
        <td><?php echo $game['is_completed'] ? 'Terminé' : 'Non terminé' ?></td>
        <td><?php echo $game['release_year'] ?></td>
        <td><?php echo $game['price'] ?></td>
        <td><?php echo $game['purchase_date'] ?></td>
        <td><?php echo $game['notes'] ?></td>
        <td><?php echo $game['created_at'] ?></td>
    </tr>
</table><br><br>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "UPDATE games SET 
                title = :title,
                platform = :platform,
                genre = :genre,
                release_year = :release_year,
                price = :price,
                is_completed = :is_completed,
                rating = :rating,
                purchase_date = :purchase_date,
                notes = :notes
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id' => $_POST['id'],
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

    echo "Jeu mis à jour<br>";
}
                              
$platforms = ['PC', 'PlayStation', 'Xbox', 'Nintendo Switch', 'SteamDeck', 'Mobile'];
?>
<!-- formulaire de la modif -->
<form method="POST">
    <input type="hidden" name="id" value="<?php echo $game['id']; ?>">

    <label>Titre :</label><br>
    <input type="text" name="title" value="<?php echo $game['title']; ?>" required><br><br>

    <label>Plateforme :</label><br>
    <select name="platform" require>
        <option value="">-- Toutes --</option>
        <?php foreach ($platforms as $p): ?>
            <option value="<?php echo $p ?>"><?php echo $p ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Genre :</label><br>
    <input type="text" name="genre" value="<?php echo $game['genre']; ?>" required><br><br>

    <label>Note (1-5) :</label><br>
    <input type="number" name="rating" min="1" max="5" value="<?php echo $game['rating']; ?>" required><br><br>

    <label>Terminé :</label><br>
    <input type="checkbox" name="is_completed"><br><br>

    <label>Année de sortie :</label><br>
    <input type="number" name="release_year" value="<?php echo $game['release_year']; ?>" required><br><br>

    <label>Prix (€) :</label><br>
    <input type="text" name="price" value="<?php echo $game['price']; ?>" required><br><br>

    <label>Date d'achat :</label><br>
    <input type="date" name="purchase_date" value="<?php echo $game['purchase_date']; ?>" required><br><br>

    <label>Commentaire :</label><br>
    <textarea name="notes" required><?php echo $game['notes']; ?></textarea><br><br>

    <button type="submit">Mettre à jour</button>
</form>

<form method="POST" action="delete.php" onsubmit="return confirmeDelete();">
    <input type="hidden" name="id" value="<?php echo $game['id']; ?>">
    <button type="submit">Supprimer ce jeu</button>
</form>
<script>
function confirmeDelete(){
    return confirm("Voulez vous supprimer le jeu ?");
}
</script>