# Explication de l'algorithme de tri et de calcul des cartons

## Introduction

Dans notre application de gestion des cartons, nous avons besoin de trier les cartons par efficacité pour choisir les plus adaptés à emballer une quantité donnée d'un produit spécifique. Ensuite, nous devons calculer le nombre de cartons nécessaires pour emballer tous les produits.

## L'algorithme de tri

L'algorithme de tri est implémenté dans la fonction `calculerCartonsOptimaux` du fichier `calculateur.php`. Voici la partie pertinente du code :

```php
uasort($cartons, function($a, $b) use ($produit, $poidsUnitaire) {
    $effA = min($a['capacités'][$produit], floor($a['poids_max'] / $poidsUnitaire));
    $effB = min($b['capacités'][$produit], floor($b['poids_max'] / $poidsUnitaire));
    return $effB <=> $effA;
});
```

### Explication étape par étape du tri

1. Nous utilisons la fonction `uasort` de PHP pour trier le tableau associatif `$cartons`. Cette fonction permet de définir une fonction de comparaison personnalisée tout en préservant les clés du tableau.

2. La fonction de comparaison prend deux paramètres, `$a` et `$b`, qui représentent deux cartons à comparer.

3. Nous utilisons la clause `use ($produit, $poidsUnitaire)` pour avoir accès à ces variables dans la fonction de comparaison.

4. Pour chaque carton, nous calculons son efficacité :
   - `$a['capacités'][$produit]` représente la capacité du carton pour le produit spécifique.
   - `floor($a['poids_max'] / $poidsUnitaire)` calcule combien d'unités du produit peuvent être placées dans le carton en respectant la contrainte de poids.
   - Nous prenons le minimum de ces deux valeurs avec la fonction `min()`. Cela nous donne le nombre réel d'unités que le carton peut contenir.

5. Nous calculons cette efficacité pour les deux cartons à comparer (`$effA` et `$effB`).

6. Nous utilisons l'opérateur de comparaison `<=>` (spaceship operator) pour comparer les efficacités. L'ordre est inversé (`$effB <=> $effA`) pour avoir un tri décroissant.

## L'algorithme de calcul des cartons nécessaires

Après avoir trié les cartons par efficacité, nous calculons le nombre de cartons nécessaires pour emballer tous les produits. Voici le code correspondant :

```php
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
```

### Explication étape par étape du calcul

1. Nous parcourons chaque carton dans l'ordre d'efficacité décroissante.

2. Pour chaque carton, nous calculons :
   - `$capaciteCarton` : la capacité du carton pour le produit spécifique.
   - `$poidsMaxCarton` : le poids maximum que peut supporter le carton.
   - `$unitesPossibles` : le nombre réel d'unités que le carton peut contenir, en prenant le minimum entre la capacité nominale et la capacité basée sur le poids.

3. Nous calculons ensuite `$cartonsNecessaires` :
   - `floor($quantite / $unitesPossibles)` : nombre de cartons nécessaires basé sur la quantité restante.
   - `floor($poidsTotal / $poidsMaxCarton)` : nombre de cartons nécessaires basé sur le poids total restant.
   - Nous prenons le minimum de ces deux valeurs pour respecter à la fois les contraintes de quantité et de poids.

4. Si des cartons sont nécessaires (`$cartonsNecessaires > 0`) :
   - Nous ajoutons ce nombre de cartons au résultat.
   - Nous mettons à jour la quantité restante et le poids total restant.

5. Si toute la quantité a été emballée (`$quantite <= 0`), nous sortons de la boucle.

6. Après la boucle principale, s'il reste encore des produits à emballer (`$quantite > 0`) :
   - Nous parcourons à nouveau les cartons pour trouver le premier qui peut contenir la quantité restante.
   - Nous ajoutons un carton de ce type au résultat.

7. Enfin, nous retournons le résultat, qui contient le nombre de cartons de chaque type nécessaires pour emballer tous les produits.

## Conclusion

Cet algorithme en deux étapes (tri puis calcul) nous permet de :
1. Prioriser les cartons les plus efficaces pour le produit donné.
2. Utiliser le minimum de cartons possible tout en respectant les contraintes de capacité et de poids.
3. Gérer les cas où un petit nombre de produits reste à emballer à la fin.

Cette approche assure une utilisation optimale des cartons disponibles pour l'emballage des produits.
