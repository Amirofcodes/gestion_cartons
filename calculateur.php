<?php
require_once 'config.php';
require_once 'models/Produit.php';
require_once 'models/Carton.php';

function calculerCartonsOptimaux($produit, $quantite, $produits, $cartons)
{
    $resultat = [];
    $poidsUnitaire = $produits[$produit]['poids'];
    $poidsTotal = $quantite * $poidsUnitaire;

    // Trier les cartons par efficacité (rapport capacité/poids_max) décroissante pour le produit spécifié
    uasort($cartons, function ($a, $b) use ($produit, $poidsUnitaire) {
        $effA = min($a['capacités'][$produit], floor($a['poids_max'] / $poidsUnitaire));
        $effB = min($b['capacités'][$produit], floor($b['poids_max'] / $poidsUnitaire));
        return $effB <=> $effA;
    });

    foreach ($cartons as $nomCarton => $infoCarton) {
        $capaciteCarton = $infoCarton['capacités'][$produit];
        $poidsMaxCarton = $infoCarton['poids_max'];
        $unitesPossibles = min($capaciteCarton, floor($poidsMaxCarton / $poidsUnitaire));

        $cartonsNecessaires = min(floor($quantite / $unitesPossibles), floor($poidsTotal / $poidsMaxCarton));

        if ($cartonsNecessaires > 0) {
            $resultat[$nomCarton] = $cartonsNecessaires;
            $quantite -= $cartonsNecessaires * $unitesPossibles;
            $poidsTotal -= $cartonsNecessaires * $poidsMaxCarton;
        }

        if ($quantite <= 0) {
            break;
        }
    }

    if ($quantite > 0) {
        foreach ($cartons as $nomCarton => $infoCarton) {
            if ($infoCarton['capacités'][$produit] >= $quantite && $infoCarton['poids_max'] >= $quantite * $poidsUnitaire) {
                $resultat[$nomCarton] = ($resultat[$nomCarton] ?? 0) + 1;
                break;
            }
        }
    }

    return $resultat;
}
