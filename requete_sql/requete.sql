-- hachage des mdp

UPDATE user
SET user.mdp = SHA2(user.mdp, 512);


-- DECLENCHEUR VERIF MAIL
BEGIN 
IF (new.email NOT LIKE '%_@_%._%' OR new.email LIKE '% %' OR new.email LIKE '%@%@%')
THEN 
SIGNAL SQLSTATE '45000' 
SET MESSAGE_TEXT = 'une adresse mail doit être du format aaa@aaa.aaa'; 
END IF; 
END


-- evenementabandon de panier

BEGIN
IF(bag.id NOT IN (SELECT ordered.bag_id FROM ordered) AND bag.creation_at + INTERVAL 7 DAY < CURDATE())
THEN
UPDATE bag
SET bag.is_expired = 1;
END IF;
END


-- update des panier qui sont expiré
UPDATE panier
SET panier.estExpire = 1
WHERE panier.IdPanier NOT IN (SELECT commande.IdPanier FROM commande) AND panier.datePanier + INTERVAL 7 DAY < CURDATE()

-- update produit

UPDATE product
SET product.is_available = 1
WHERE product.quantity > 0


-- procedure stocké ajout commande
BEGIN
DELETE FROM commande;
DELETE FROM panier;
ALTER TABLE commande AUTO_INCREMENT = 1 ;
ALTER TABLE panier AUTO_INCREMENT = 1 ;
SET @maxi = 500 + RAND()*2500;
SET @i = 0;

WHILE @i < @maxi DO
    SET @datePanier = '2020-04-14' + INTERVAL (RAND()*TIMESTAMPDIFF(DAY, '2020-04-14', CURDATE())) DAY;
    SET @idClient = (SELECT client.IdClient FROM client ORDER BY RAND() LIMIT 1);
    INSERT INTO panier(datePanier, IdClient)
    VALUES (@datePanier, @idClient);

    IF RAND()*100 > 60
    THEN
        SET @IdPanier = (SELECT LAST_INSERT_ID() FROM panier LIMIT 1);
        SET @dateCommande = @datePanier + INTERVAL RAND()*7 DAY;
        SET @IdPayement = (SELECT paiement.IdPaiement FROM paiement ORDER BY RAND() LIMIT 1);
        SET @IdStatut = (SELECT statut.IdStatut FROM statut ORDER BY RAND() LIMIT 1);
        
            IF RAND()*100 < 90
            THEN
           		SET @IdAdresseFacture = (SELECT client.IdAdresse FROM client  WHERE client.IdClient = @IdClient);

            ELSE
            	SET @IdAdresseFacture = (SELECT adresse.IdAdresse FROM adresse ORDER BY RAND() LIMIT 1);
            END IF;

        INSERT INTO commande(IdPanier, dateCommande, IdPayement, IdStatut,IdAdresseFacture)
    	VALUES (@IdPanier, @dateCommande, @IdPayement, @IdStatut, @IdAdresseFacture);       
    END IF;

    SET @i = @i + 1;
END WHILE;
END





-- compte les panier en fct du nb de panier 
SELECT nb, COUNT(*) FROM (
	SELECT COUNT(*) nb
    FROM contenir
    GROUP BY contenir.IdPanier  
) T
group by nb


-- déclencheur commentaire


BEGIN

IF(new.IdClient NOT IN (SELECT panier.IdClient 
                        	FROM panier
                            JOIN commande ON commande.IdPanier = panier.IdPanier
                            JOIN contenir ON contenir.IdPanier = panier.IdPanier
                            JOIN produit ON produit.IdProduit = contenir.IdProduit
                            WHERE produit.IdProduit = new.IdProduit))
THEN
SIGNAL SQLSTATE '45000' 
SET MESSAGE_TEXT = 'Vous ne pouvez pas commentez un produit que vous n\'avez pas acheté'; 

END IF;
END
'



-- listedesclients et de leur produit commandé
SELECT
    client.IdClient
FROM client
JOIN panier ON panier.IdClient = client.IdClient
JOIN contenir ON contenir.IdPanier = panier.IdPanier
JOIN produit ON produit.IdProduit = contenir.IdProduit
WHERE produit.IdProduit = 67


-- ajout des commentaires !!!doitenlever le déclencheur qui bloque si non commande

INSERT INTO commentaire(IdProduit, IdClient, note, description, dateAvis)
SELECT
    contenir.IdProduit,
    panier.IdClient,
    ROUND(RAND()*5),
    SHA2(CONV(FLOOR(RAND() * 99999999999999), 20, 36), 256),
    commande.dateCommande + INTERVAL (RAND() * 30) DAY
FROM panier
JOIN contenir ON contenir.IdPanier = panier.IdPanier
JOIN commande ON commande.IdPanier = panier.IdPanier
ORDER BY rand() limit 400;


-- requete qui récupère toutes les infos nécéssaire pour une commande
SET @idClient = 1; -- choix de l'id du client

SELECT	
	CONCAT(client.nom, ' ', client.prenom) 'Nom du Client',
    client.mail email,
    client.dateInscription `Date d'inscription`,
    COUNT(*) 'Nombre de Commande passée',
    SUM(produit.prixHT*contenir.quantite) 'Total dépensé',
    (SELECT SUM(produit.prixHT*contenir.quantite) FROM panier JOIN contenir ON contenir.IdPanier = panier.IdPanier JOIN commande ON commande.IdPanier = panier.IdPanier JOIN produit on produit.IdProduit = contenir.IdProduit WHERE panier.IdClient = @idClient GROUP BY panier.IdClient, commande.IdPanier ORDER BY commande.dateCommande desc LIMIT 1) 'Total de la commande HT',
    (SELECT SUM(produit.prixHT*contenir.quantite)*1.2 FROM panier JOIN contenir ON contenir.IdPanier = panier.IdPanier JOIN commande ON commande.IdPanier = panier.IdPanier JOIN produit on produit.IdProduit = contenir.IdProduit WHERE panier.IdClient = @idClient GROUP BY panier.IdClient, commande.IdPanier ORDER BY commande.dateCommande desc LIMIT 1) 'Total de la commande TTC',
    statut.etat 'Etat de la commande',
    CURDATE() 'Date dréation de facture'
FROM panier
JOIN client ON client.IdClient = panier.IdClient
JOIN commande ON commande.IdPanier = panier.IdPanier
JOIN contenir ON contenir.IdPanier = panier.IdPanier
JOIN produit ON produit.IdProduit = contenir.IdProduit
JOIN statut ON statut.IdStatut = commande.IdStatut
WHERE panier.IdClient = @idClient
GROUP BY panier.IdClient

