
-- compte le total dépensé par client
SELECT
    panier.IdClient,
    SUM(produit.prixHT*contenir.quantite)
FROM panier
JOIN contenir ON contenir.IdPanier = panier.IdPanier
JOIN commande ON commande.IdPanier = panier.IdPanier
JOIN produit on produit.IdProduit = contenir.IdProduit
GROUP BY panier.IdClient


-- compte de prix total ht de chaque commande
SELECT
    panier.IdClient,
    commande.IdPanier,
    SUM(produit.prixHT*contenir.quantite)
FROM panier
JOIN contenir ON contenir.IdPanier = panier.IdPanier
JOIN commande ON commande.IdPanier = panier.IdPanier
JOIN produit on produit.IdProduit = contenir.IdProduit
GROUP BY panier.IdClient, commande.IdPanier

-- compte le prix total ttc de chaque commande
SELECT
    panier.IdClient,
    commande.IdPanier,
    SUM(produit.prixHT*contenir.quantite)*1.2
FROM panier
JOIN contenir ON contenir.IdPanier = panier.IdPanier
JOIN commande ON commande.IdPanier = panier.IdPanier
JOIN produit on produit.IdProduit = contenir.IdProduit
GROUP BY panier.IdClient, commande.IdPanier



-- trouve le montant de la derniere commande d'unclient x
SELECT
    panier.IdClient,
    commande.IdPanier,
    SUM(produit.prixHT*contenir.quantite),
    commande.dateCommande
FROM panier
JOIN contenir ON contenir.IdPanier = panier.IdPanier
JOIN commande ON commande.IdPanier = panier.IdPanier
JOIN produit on produit.IdProduit = contenir.IdProduit
WHERE panier.IdClient = 3
GROUP BY panier.IdClient, commande.IdPanier
ORDER BY commande.dateCommande desc LIMIT 1

-- Montant Total des ventes ht

SELECT
    SUM(produit.prixHT*contenir.quantite) 'Total des ventes ht'
FROM panier
JOIN contenir ON contenir.IdPanier = panier.IdPanier
JOIN commande ON commande.IdPanier = panier.IdPanier
JOIN produit on produit.IdProduit = contenir.IdProduit


-- Montant Total des ventes TTC

SELECT
    SUM(produit.prixHT*contenir.quantite)*1.2 'Total des ventes TTC'
FROM panier
JOIN contenir ON contenir.IdPanier = panier.IdPanier
JOIN commande ON commande.IdPanier = panier.IdPanier
JOIN produit on produit.IdProduit = contenir.IdProduit



-- Montant Total des ventes choix par année/mois/journée

SELECT
	commande.dateCommande,
    SUM(produit.prixHT*contenir.quantite)*1.2
FROM panier
JOIN contenir ON contenir.IdPanier = panier.IdPanier
JOIN commande ON commande.IdPanier = panier.IdPanier
JOIN produit on produit.IdProduit = contenir.IdProduit
WHERE commande.dateCommande LIKE '%'
ORDER BY commande.dateCommande