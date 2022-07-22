-- ajout 1 article dans chaque panier
INSERT INTO contain(contain.products_id, contain.bag_id, contain.quantity)
SELECT
	(SELECT product.id FROM product ORDER by rand() limit 1),
    bag.id,
    1 + RAND()*3
FROM bag

-- ajout deuxieme article dans 75% panier
INSERT INTO contain(contain.products_id, contain.bag_id, contain.quantity)
SELECT
	(SELECT product.id FROM product ORDER by rand() limit 1),
    bag.id,
    1 + RAND()*3
FROM bag
Order by rand()
limit 1433

-- ajout troisieme article dans 50% panier
INSERT INTO contain(contain.products_id, contain.bag_id, contain.quantity)
SELECT
	(SELECT product.id FROM product ORDER by rand() limit 1),
    contain.bag_id,
    1 + RAND()*3
FROM contain
GROUP BY contain.bag_id
HAVING COUNT(*) = 2
Order by rand()
limit 955


-- ajout quatrième article dans 25% panier
INSERT INTO contain(contain.products_id, contain.bag_id, contain.quantity)
SELECT
	(SELECT product.id FROM product ORDER by rand() limit 1),
    contain.bag_id,
    1 + RAND()*3
FROM contain
GROUP BY contain.bag_id
HAVING COUNT(*) = 3
Order by rand()
limit 477