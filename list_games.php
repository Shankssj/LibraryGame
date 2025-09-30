<?php
require_once 'config.php';

if (isset($_POST['game_id'])) {
    $game_id = $_POST['game_id'];

    $stmt = $pdo->prepare("SELECT title, platform, price, notes FROM games WHERE id = ?");
    $stmt->execute([$game_id]);
    $game = $stmt->fetch();

    if ($game) {

        $stmt2 = $pdo->prepare("SELECT * FROM wishlist WHERE title = ? AND platform = ?");
        $stmt2->execute([$game['title'], $game['platform']]);

        if ($stmt2->fetch() == false) {
            
            $stmt3 = $pdo->prepare("INSERT INTO wishlist (title, platform, expected_price, priority, notes) VALUES (?, ?, ?, NULL, ?)");
            $stmt3->execute([$game['title'], $game['platform'], $game['price'], $game['notes']]);
            echo "Jeu ajouté à la wishlist";
        } else {
            echo "Ce jeu est déjà dans la wishlist";
        }
    }
}

$stmt = $pdo->query("SELECT * FROM games");
$games = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Liste des jeux</h1>

<table>
    <tr>
        <th>Titre</th>
        <th>Plateforme</th>
        <th>Genre</th>
        <th>Note</th>
        <th>Statut</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($games as $game): ?>
        <tr>
            <td><?php echo $game['title'] ?></td>
            <td><?php echo $game['platform'] ?></td>
            <td><?php echo $game['genre'] ?></td>
            <td><?php echo $game['rating'] ?>/5</td>
            <td><?php echo $game['is_completed'] ? 'Terminé' : 'Non terminé' ?></td>
            <td>
                <a href="manage_game.php?id=<?= $game['id'] ?>">Voir</a>
                <form method="post">
                    <input type="hidden" name="game_id" value="<?= $game['id'] ?>">
                    <button type="submit">Ajouter à la wishlist</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>