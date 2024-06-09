CREATE TABLE session (
    id int PRIMARY KEY AUTO_INCREMENT,
    joueur1id int,
    joueur2id int,
    carreau1 int,
    carreau2 int,
    carreau3 int,
    carreau4 int,
    carreau5 int,
    carreau6 int,
    carreau7 int,
    carreau8 int,
    carreau9 int,
    roomid int
    );
create TABLE room (
    createurid int,
    motpasse int,
    id int PRIMARY KEY AUTO_INCREMENT
    );
CREATE TABLE utilisateur (
    id int PRIMARY KEY AUTO_INCREMENT,
    nomutilisateur text,
    motpasse text
    );
