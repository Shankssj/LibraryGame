<?php
require_once 'config.php';

if (isset($_POST['wish_id'])) {
    $wish_id = $_POST['wish_id'];

    $stmt = $pdo->prepare("SELECT title, platform, expected_price, notes FROM wishlist WHERE id = ?");
    $stmt->execute([$wish_id]);
    $wish = $stmt->fetch();

    if ($wish) {

        $stmt2 = $pdo->prepare("SELECT * FROM games WHERE title = ? AND platform = ?");
        $stmt2->execute([$wish['title'], $wish['platform']]);

        if ($stmt2->fetch() == false) {
              
            $stmt3 = $pdo->prepare("INSERT INTO games (title, platform, genre, price, notes) VALUES (?, ?, NULL, ?, ?)");
            $stmt3->execute([$wish['title'], $wish['platform'], $wish['expected_price'], $wish['notes']]);
            echo "Jeu ajouté à la liste des jeux";
        } else {
            echo "Ce jeu est déjà dans la liste des jeux";
        }
    }         
}

$stmt = $pdo->query("SELECT * FROM wishlist");
$wishs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Ma wishlist</h1>
<table>
    <tr>
        <th>Titre</th>
        <th>Plateforme</th>
        <th>prix</th>
        <th>Commentaire</th>
    </tr>
    <?php foreach ($wishs as $wish): ?>
        <tr>
            <td><?php echo $wish['title'] ?></td>
            <td><?php echo $wish['platform'] ?></td>
            <td><?php echo $wish['expected_price'] ?></td>
            <td><?php echo $wish['notes'] ?>/5</td>
            <td>
                <form method="post">
                    <input type="hidden" name="wish_id" value="<?= $wish['id'] ?>">
                    <button type="submit">Ajouter à la liste des jeux</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>