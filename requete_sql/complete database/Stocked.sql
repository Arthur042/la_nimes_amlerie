BEGIN
DELETE FROM ordered;
DELETE FROM bag;
ALTER TABLE ordered AUTO_INCREMENT = 1 ;
ALTER TABLE bag AUTO_INCREMENT = 1 ;
SET @maxi = 500 + RAND()*2500;
SET @i = 0;

WHILE @i < @maxi DO
    SET @datePanier = '2020-04-14' + INTERVAL (RAND()*TIMESTAMPDIFF(DAY, '2020-04-14', CURDATE())) DAY;
    SET @idClient = (SELECT user.id FROM user ORDER BY RAND() LIMIT 1);
    INSERT INTO bag(creation_at, user_id)
    VALUES (@datePanier, @idClient);

    IF RAND()*100 > 60
    THEN
        SET @IdPanier = (SELECT LAST_INSERT_ID() FROM bag LIMIT 1);
        SET @dateCommande = @datePanier + INTERVAL RAND()*7 DAY;
        SET @IdPayement = (SELECT payment.id FROM payment ORDER BY RAND() LIMIT 1);
        SET @IdStatut = (SELECT status.id FROM status ORDER BY RAND() LIMIT 1);
        
            IF RAND()*100 < 90
            THEN
           		SET @IdAdresseFacture = (SELECT user.id FROM user  WHERE user.id = @IdClient);

            ELSE
            	SET @IdAdresseFacture = (SELECT adress.id FROM adress ORDER BY RAND() LIMIT 1);
            END IF;

        INSERT INTO ordered(bag_id, creation_at, payment_id, status_id,billing_adress_id)
    	VALUES (@IdPanier, @dateCommande, @IdPayement, @IdStatut, @IdAdresseFacture);       
    END IF;

    SET @i = @i + 1;
END WHILE;
END