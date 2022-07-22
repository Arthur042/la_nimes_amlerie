-- ajout des categories
INSERT INTO categorie(IdCategorieParent, nom)
VALUES 
	(NULL,'Chien'),
	(NULL,'Chat'),
    (NULL,'Rongeur'),
    (NULL,'Aquariophilie'),
    (NULL,'Terrariophilie'),
    (NULL,'Oiseau'),
    (NULL,'Espace');
    
INSERT INTO categorie(IdCategorieParent, nom)
VALUES 
    (1,'Alimentation pour chiens'),
    (1,'Compléments Alimentaires'),
    (1,'Hygiène et soins'),
    (1,'Gamelles et distributeurs'),
    (1,'Colliers et Laisses'),
    (1,'Jouets'),
    (2,'Alimentation pour Chats'),
    (2,'Litières pour chats'),
    (2,'Hygiène et soins'),
    (2,'Gamelles et distributeurs'),
    (2,'Arbre à Chat'),
    (2,'Jouets'),
    (2,'Voyage et Transport'),
    (3,'Alimentation pour Rongeurs'),
    (3,'Hygiène et soins'),
    (3,'Cages et accéssoires'),
    (4,'Alimentation pour Reptiles'),
    (4,'Eclairage'),
    (4,'Chauffage'),
    (4,'Substrat'),
    (4,'Décoration'),
    (4,'Accessoire pour Terrarium'),
    (5,'Alimentation pour Oiseaux'),
    (5,'Habitat'),
    (5,'Hygiène et soins'),
    (5,'Mangeoire'),
    (5,'Nichoire'),
    (6,'Alimentation pour poisson'),
    (6,'Aquarium'),
    (6,'Filtration'),
    (6,'Traitement et soins');


-- ajout des genres
INSERT INTO genre(libelle)
VALUES ('Homme'),('Femme'),('Autre')
