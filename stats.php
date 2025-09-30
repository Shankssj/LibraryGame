<?php
require_once 'config.php';

//nb jeux par plateforme
$nbJeuPlat = $pdo->query("SELECT platform, COUNT(*) as nbJeuPlateforme FROM games GROUP BY platform")->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Nombre de jeux par plateforme</h2>
<ul>
    <?php foreach ($nbJeuPlat as $nombre) { ?>
        <li><?php echo $nombre['platform'] . " : " . $nombre['nbJeuPlateforme']; ?></li>
    <?php } ?>
</ul>

<!-- cout collection -->
<?php
$coutCollection = $pdo->query("SELECT SUM(price) as coutCollection FROM games")->fetch(PDO::FETCH_ASSOC);
?>
<h2>Coût de la collection</h2>
<?php echo "Coût total : " . $coutCollection['coutCollection'] . "€"; ?>

<!-- pourcentage jeux finis -->
<?php
$pourcentageJeuFinis = $pdo->query("SELECT ROUND(COUNT(*) * 100.0 / (SELECT COUNT(*) FROM games)) AS pourcentage_termines FROM games WHERE is_completed = 1;")->fetch(PDO::FETCH_ASSOC);
?>
<h2>Pourcentage de jeux terminés</h2>
<?php echo "Pourcentage : " . $pourcentageJeuFinis['pourcentage_termines'] . "%"; ?>


<!-- top 3 des genres -->
 <?php 
$topGenre = $pdo->query("SELECT genre, COUNT(genre) AS topGenre FROM games GROUP BY genre ORDER BY topGenre DESC LIMIT 3")->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Top 3 des genres les  plus fréquents</h2>
<ul>
    <?php foreach ($topGenre as $top) { ?>
        <li><?php echo $top['genre'] . " : " . $top['topGenre']; ?></li>
    <?php } ?>
</ul>


<!-- Jeu le plus et le moins cher -->
 <?php
$moinsCher = $pdo->query("SELECT title, price FROM games ORDER BY price ASC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$plusCher = $pdo->query("SELECT title, price FROM games ORDER BY price DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
?>
<h2>Le jeu le moins cher</h2>
<?php echo "Titre : " . $moinsCher['title'] . "<br>" . "Prix : " . $moinsCher['price']; ?>


<h2>Le jeu le plus cher</h2>
<?php echo "Titre : " . $plusCher['title'] . "<br>" . "Prix : " . $plusCher['price']; ?>


<!-- Moyenne des notes attribuées -->
 <?php
 $moyenneNote = $pdo->query("SELECT ROUND(AVG(rating),1) AS moyenneNote FROM games;")->fetch(PDO::FETCH_ASSOC);
 ?>

 <h2>Moyenne des notes</h2>
 <?php echo "Moyenne sur 5 : " . $moyenneNote['moyenneNote'] . "/5"; ?>