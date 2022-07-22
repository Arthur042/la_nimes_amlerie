-- compte le nombre de commande par client
SELECT panier.IdClient, COUNT(*) FROM panier JOIN commande ON commande.IdPanier = panier.IdPanier GROUP BY panier.IdClient

-- nombre de panier, panier  expiré et nombre de commande
SELECT 
COUNT(*) 'nb total de panier',
(SELECT COUNT(*) FROM panier WHERE panier.estExpire = 1)'nb total de panier expiré',
(SELECT COUNT(*) FROM commande) 'nb total de commande'
FROM panier

-- Valeur d’une commande moyenne

SELECT
	(SELECT COUNT(*) FROM commande) 'nb total de commande',
    SUM(produit.prixHT*contenir.quantite) 'Total des ventes ht',
    SUM(produit.prixHT*contenir.quantite)/(SELECT COUNT(*) FROM commande) 'montant moyen d\'unecommande'
FROM panier
JOIN contenir ON contenir.IdPanier = panier.IdPanier
JOIN commande ON commande.IdPanier = panier.IdPanier
JOIN produit on produit.IdProduit = contenir.IdProduit;
'

-- Valeur d’un panier moyen

SELECT
	(SELECT COUNT(*) FROM panier) 'nb total de panier',
    SUM(produit.prixHT*contenir.quantite) 'Montant total des paniers',
    SUM(produit.prixHT*contenir.quantite)/(SELECT COUNT(*) FROM panier) 'montant moyen d\'un panier ht'
FROM panier
JOIN contenir ON contenir.IdPanier = panier.IdPanier
JOIN produit on produit.IdProduit = contenir.IdProduit;
'


-- liste des nouveaux clients choix du mois

SET @choixDate = '2022-04%';
SELECT 
	CONCAT(client.nom, ' ',client.prenom),
	client.mail,
    client.dateInscription,
    commande.dateCommande
FROM client
JOIN panier ON panier.IdClient = client.IdClient
JOIN commande ON commande.IdPanier = panier.IdPanier
WHERE commande.dateCommande LIKE @choixDate  
AND panier.idClient NOT IN (SELECT clientnbcommande.IdClient FROM clientnbcommande WHERE clientnbcommande.nbCommande > 1)

-- nb de commande parnouveau client sur mois x
SELECT 
	COUNT(*)
FROM client
JOIN panier ON panier.IdClient = client.IdClient
JOIN commande ON commande.IdPanier = panier.IdPanier
WHERE commande.dateCommande LIKE @choixDate  
AND panier.idClient NOT IN (SELECT clientnbcommande.IdClient FROM clientnbcommande WHERE clientnbcommande.nbCommande > 1)

-- OR plus performante

SET @choixDate = '2022-03%';
SELECT COUNT(IF((panier.idClient IN (SELECT clientnbcommande.IdClient FROM clientnbcommande WHERE clientnbcommande.nbCommande = 1)),1,NULL)) 'nb de recommande' 
FROM commande 
JOIN panier ON panier.IdPanier = commande.IdPanier 
WHERE commande.dateCommande LIKE @choixDate

-- nb de commande sur le mois x
SET @choixDate = '2022-04%';
SELECT COUNT(*) 
FROM commande 
JOIN panier ON panier.IdPanier = commande.IdPanier 
JOIN client ON client.IdClient = panier.IdClient 
WHERE commande.dateCommande LIKE @choixDate


-- nb de commande par un client ayant déja commandé

SET @choixDate = '2022-04%';
SELECT COUNT(IF((panier.idClient IN (SELECT panier.IdClient FROM panier JOIN commande ON commande.IdPanier = panier.IdPanier WHERE clientnbcommande.nbCommande > 1)),1,NULL)) 'nb de recommande' 
FROM commande 
JOIN panier ON panier.IdPanier = commande.IdPanier 
WHERE commande.dateCommande LIKE @choixDate

-- total commande + newCommande + Recommande sur mois x
SET @choixDate = '2022-04%';
SELECT 
	YEAR(commande.dateCommande) année,
	MONTH(commande.dateCommande) mois,
	COUNT(*) 'TotalCommande',
    COUNT(IF((panier.idClient IN (SELECT clientnbcommande.IdClient FROM clientnbcommande WHERE clientnbcommande.nbCommande = 1)),1,NULL)) 'nouvelleCommande',
    COUNT(IF((panier.idClient IN (SELECT clientnbcommande.IdClient FROM clientnbcommande WHERE clientnbcommande.nbCommande > 1)),1,NULL)) 'Recommande',
    ROUND((COUNT(IF((panier.idClient IN (SELECT clientnbcommande.IdClient FROM clientnbcommande WHERE clientnbcommande.nbCommande > 1)),1,NULL)) / COUNT(*))*100,2) 'Pourcentage récurence comande'
FROM commande 
JOIN panier ON panier.IdPanier = commande.IdPanier 
JOIN client ON client.IdClient = panier.IdClient 
WHERE commande.dateCommande LIKE @choixDate



-- total commande + newCommande + Recommande sur mois  sur tous les mois
SELECT YEAR(T.dateCommande) Année, MONTH(T.dateCommande) Mois,
	100 - COUNT(IF(CommandesPassees = 0, 'Choucroute', NULL)) / COUNT(*) * 100 AS PourcentageFidelite
FROM (
    SELECT paniparent.IdClient, comparent.dateCommande,
        (SELECT COUNT(*)
         FROM panier
         JOIN commande ON panier.IdPanier = commande.IdPanier
         WHERE idClient = paniparent.IdClient
         AND commande.dateCommande < comparent.dateCommande) AS CommandesPassees
    FROM panier paniparent
    JOIN commande comparent ON paniparent.IdPanier = comparent.IdPanier
    ORDER BY comparent.dateCommande DESC
    ) T
GROUP BY YEAR(T.dateCommande), MONTH(T.dateCommande)
ORDER BY YEAR(T.dateCommande), MONTH(T.dateCommande)


-- pourcentage abandonpaniertotal
SELECT 
COUNT(*) 'nb total de panier',
(SELECT COUNT(*) FROM panier WHERE panier.estExpire = 1)'nb total de panier expiré',
ROUND(((SELECT COUNT(*) FROM panier WHERE panier.estExpire = 1)/COUNT(*))*100,2) 'pourcentage d\'abandonpanier'
FROM panier
'
--  Pourcentage de conversion de commande
SELECT 
	COUNT(*) 'nb de panier',
    (SELECT COUNT(*) FROM commande) 'nb de commande',
    ROUND(((SELECT COUNT(*) FROM commande)/COUNT(*))*100,2) 'Pourcentage de conversion de commande'
FROM panier

-- total de produit vendu triés du plus vendu oau moins vendu

SELECT
	produit.titre nomProduit,
    produit.prixHT,
    SUM(contenir.quantite) NbVendu,
    SUM(contenir.quantite)*produit.prixHT totalHTVendu,
    ROUND(SUM(contenir.quantite)*produit.prixHT*1.2,2) totalTTCVendu
FROM contenir
JOIN produit ON produit.IdProduit = contenir.IdProduit
JOIN panier ON panier.IdPanier = contenir.IdPanier
JOIN commande ON commande.IdPanier = panier.IdPanier
GROUP BY contenir.IdProduit
ORDER BY SUM(contenir.quantite) DESC