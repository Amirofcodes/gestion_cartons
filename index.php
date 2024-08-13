<?php
require_once 'config.php';
require_once 'models/Produit.php';
require_once 'models/Carton.php';
require_once 'calculateur.php';

// Initialiser les modèles
$produitModel = new Produit();
$cartonModel = new Carton();

// Récupérer les produits et les cartons de la base de données
$produits = $produitModel->getAll();
$cartons = $cartonModel->getAll();

// Formater les données pour le calcul
$produitsFormatted = [];
foreach ($produits as $produit) {
    $produitsFormatted[$produit['nom']] = ['dimension' => $produit['dimension'], 'poids' => $produit['poids']];
}

$cartonsFormatted = [];
foreach ($cartons as $carton) {
    $capacites = [];
    foreach (explode(';', $carton['capacites']) as $capacite) {
        list($produit, $quantite) = explode(':', $capacite);
        $capacites[$produit] = (int)$quantite;
    }
    $cartonsFormatted[$carton['nom']] = ['capacités' => $capacites, 'poids_max' => $carton['poids_max']];
}

// Cas de test
$casTests = [
    ['Verre a pieds', 314],
    ['Assiette', 51],
    ['Carafe', 30],
    ['Tasse', 200],
];

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Cartons</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Gestion des Cartons</h1>

    <h2>Produits</h2>
    <table>
        <tr>
            <th>Nom</th>
            <th>Dimension</th>
            <th>Poids</th>
        </tr>
        <?php foreach ($produits as $produit): ?>
            <tr>
                <td><?php echo htmlspecialchars($produit['nom']); ?></td>
                <td><?php echo htmlspecialchars($produit['dimension']); ?></td>
                <td><?php echo htmlspecialchars($produit['poids']); ?> kg</td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Cartons</h2>
    <table>
        <tr>
            <th>Nom</th>
            <th>Poids Max</th>
            <th>Capacités</th>
        </tr>
        <?php foreach ($cartons as $carton): ?>
            <tr>
                <td><?php echo htmlspecialchars($carton['nom']); ?></td>
                <td><?php echo htmlspecialchars($carton['poids_max']); ?> kg</td>
                <td><?php echo htmlspecialchars($carton['capacites']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Résultats des Tests</h2>
    <?php foreach ($casTests as [$produit, $quantite]): ?>
        <div class="result">
            <h3>Test pour <?php echo $quantite; ?> <?php echo htmlspecialchars($produit); ?></h3>
            <?php
            $resultat = calculerCartonsOptimaux($produit, $quantite, $produitsFormatted, $cartonsFormatted);
            if (!empty($resultat)):
            ?>
                <ul>
                    <?php foreach ($resultat as $nomCarton => $nombreCartons): ?>
                        <li><?php echo htmlspecialchars($nomCarton); ?>: <?php echo $nombreCartons; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucun carton trouvé pour cette configuration.</p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

</body>

</html>