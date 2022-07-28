# install all depedency
    ```php
    symfony composer install
    ```
- execute the command for yarn
    ```php
    yarn install
    ```
- or for npm
    ```php
    npm install
    ```
# Add data in database
- add fixture data
    ```php
    symfony console hautelook:fixtures:load --purge-with-truncate
    ```
- After this, execute this request sql on the database
    ```sql
    DELIMITER $$
    CREATE DEFINER=`root`@`localhost` PROCEDURE `ajoutCommandePanier`()
    BEGIN
    SET @maxi = 500 + RAND()*2500;
    SET @i = 0;

    WHILE @i < @maxi DO
        SET @datePanier = '2020-04-14' + INTERVAL (RAND()*TIMESTAMPDIFF(DAY, '2020-04-14', CURDATE())) DAY;
        SET @idClient = (SELECT user.id FROM user ORDER BY RAND() LIMIT 1);
        INSERT INTO bag(bag.creation_at, bag.user_id, bag.status)
        VALUES (@datePanier, @idClient, 100);

        IF RAND()*100 > 60
        THEN
            SET @IdPanier = (SELECT LAST_INSERT_ID() FROM bag LIMIT 1);
            SET @dateCommande = @datePanier + INTERVAL RAND()*7 DAY;
            SET @IdPayement = (SELECT payment.id FROM payment ORDER BY RAND() LIMIT 1);
            SET @IdStatut = (SELECT status.id FROM status ORDER BY RAND() LIMIT 1);
            
                IF RAND()*100 < 90
                THEN
                    SET @IdAdresseFacture = (SELECT user.adress_id FROM user  WHERE user.id = @IdClient);

                ELSE
                    SET @IdAdresseFacture = (SELECT adress.id FROM adress ORDER BY RAND() LIMIT 1);
                END IF;

            INSERT INTO ordered(ordered.bag_id, ordered.creation_at, ordered.payment_id, ordered.status_id,ordered.billing_adress_id)
            VALUES (@IdPanier, @dateCommande, @IdPayement, @IdStatut, @IdAdresseFacture);       
        END IF;

        SET @i = @i + 1;
    END WHILE;

    INSERT INTO contain(contain.products_id, contain.bag_id, contain.quantity, contain.unit_price, contain.tva)
    SELECT
        (SELECT product.id FROM product ORDER by rand() limit 1),
        bag.id,
        1 + RAND()*3,
        (SELECT product.price_ht FROM product ORDER by rand() limit 1),
        (SELECT product.tva FROM product ORDER by rand() limit 1)
    FROM bag;

    INSERT INTO contain(contain.products_id, contain.bag_id, contain.quantity, contain.unit_price, contain.tva)
    SELECT
        (SELECT product.id FROM product ORDER by rand() limit 1),
        bag.id,
        1 + RAND()*3,
        (SELECT product.price_ht FROM product ORDER by rand() limit 1),
        (SELECT product.tva FROM product ORDER by rand() limit 1)
    FROM bag
    Order by rand()
    limit 1500;

    INSERT INTO contain(contain.products_id, contain.bag_id, contain.quantity, contain.unit_price, contain.tva)
    SELECT
        (SELECT product.id FROM product ORDER by rand() limit 1),
        contain.bag_id,
        1 + RAND()*3,
        (SELECT product.price_ht FROM product ORDER by rand() limit 1),
        (SELECT product.tva FROM product ORDER by rand() limit 1)
    FROM contain
    GROUP BY contain.bag_id
    HAVING COUNT(*) = 2
    Order by rand()
    limit 1000;

    INSERT INTO contain(contain.products_id, contain.bag_id, contain.quantity, contain.unit_price, contain.tva)
    SELECT
        (SELECT product.id FROM product ORDER by rand() limit 1),
        contain.bag_id,
        1 + RAND()*3,
        (SELECT product.price_ht FROM product ORDER by rand() limit 1),
        (SELECT product.tva FROM product ORDER by rand() limit 1)
    FROM contain
    GROUP BY contain.bag_id
    HAVING COUNT(*) = 3
    Order by rand()
    limit 500;
    END$$
    DELIMITER ;
    ```
# If the request don't work :

- First, execute the first request part to add bag and ordered
    ```sql
    SET @maxi = 500 + RAND()*2500;
    SET @i = 0;

    WHILE @i < @maxi DO
        SET @datePanier = '2020-04-14' + INTERVAL (RAND()*TIMESTAMPDIFF(DAY, '2020-04-14', CURDATE())) DAY;
        SET @idClient = (SELECT user.id FROM user ORDER BY RAND() LIMIT 1);
        INSERT INTO bag(bag.creation_at, bag.user_id, bag.status)
        VALUES (@datePanier, @idClient, 100);

        IF RAND()*100 > 60
        THEN
            SET @IdPanier = (SELECT LAST_INSERT_ID() FROM bag LIMIT 1);
            SET @dateCommande = @datePanier + INTERVAL RAND()*7 DAY;
            SET @IdPayement = (SELECT payment.id FROM payment ORDER BY RAND() LIMIT 1);
            SET @IdStatut = (SELECT status.id FROM status ORDER BY RAND() LIMIT 1);
            
                IF RAND()*100 < 90
                THEN
                    SET @IdAdresseFacture = (SELECT user.adress_id FROM user  WHERE user.id = @IdClient);

                ELSE
                    SET @IdAdresseFacture = (SELECT adress.id FROM adress ORDER BY RAND() LIMIT 1);
                END IF;

            INSERT INTO ordered(ordered.bag_id, ordered.creation_at, ordered.payment_id, ordered.status_id,ordered.billing_adress_id)
            VALUES (@IdPanier, @dateCommande, @IdPayement, @IdStatut, @IdAdresseFacture);       
        END IF;

        SET @i = @i + 1;
    END WHILE;
    ```

- Then execute all Contain insert request separately
    ```sql
    INSERT INTO contain(contain.products_id, contain.bag_id, contain.quantity, contain.unit_price, contain.tva)
    SELECT
        (SELECT product.id FROM product ORDER by rand() limit 1),
        bag.id,
        1 + RAND()*3,
        (SELECT product.price_ht FROM product ORDER by rand() limit 1),
        (SELECT product.tva FROM product ORDER by rand() limit 1)
    FROM bag;
    ```
    ---
    ```sql
    INSERT INTO contain(contain.products_id, contain.bag_id, contain.quantity, contain.unit_price, contain.tva)
    SELECT
        (SELECT product.id FROM product ORDER by rand() limit 1),
        bag.id,
        1 + RAND()*3,
        (SELECT product.price_ht FROM product ORDER by rand() limit 1),
        (SELECT product.tva FROM product ORDER by rand() limit 1)
    FROM bag
    Order by rand()
    limit 1500;
    ```
    ---
    ```sql
    INSERT INTO contain(contain.products_id, contain.bag_id, contain.quantity, contain.unit_price, contain.tva)
    SELECT
        (SELECT product.id FROM product ORDER by rand() limit 1),
        contain.bag_id,
        1 + RAND()*3,
        (SELECT product.price_ht FROM product ORDER by rand() limit 1),
        (SELECT product.tva FROM product ORDER by rand() limit 1)
    FROM contain
    GROUP BY contain.bag_id
    HAVING COUNT(*) = 2
    Order by rand()
    limit 1000;
    ```
    ---
    ```sql
    INSERT INTO contain(contain.products_id, contain.bag_id, contain.quantity, contain.unit_price, contain.tva)
    SELECT
        (SELECT product.id FROM product ORDER by rand() limit 1),
        contain.bag_id,
        1 + RAND()*3,
        (SELECT product.price_ht FROM product ORDER by rand() limit 1),
        (SELECT product.tva FROM product ORDER by rand() limit 1)
    FROM contain
    GROUP BY contain.bag_id
    HAVING COUNT(*) = 3
    Order by rand()
    limit 500;
    ```
    ---