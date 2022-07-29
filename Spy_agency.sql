/* Création de la base de donnes spy_agency */
CREATE DATABASE IF NOT EXISTS spy_agency CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

/**********************************************************************************************/

/* Création de toutes les tables avec les contraintes */
CREATE TABLE IF NOT EXISTS Agent (
    id_agent INTEGER(4) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    birthdate DATE NOT NULL,
    nationality VARCHAR(50) NOT NULL
) engine=INNODB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS Speciality (
    id_speciality INTEGER(4) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL
) engine=INNODB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS AgentSpeciality (
    id_agent INTEGER(4) NOT NULL,
    id_speciality INTEGER(4) NOT NULL,
    PRIMARY KEY(id_agent, id_speciality),
    FOREIGN KEY(id_agent) REFERENCES Agent(id_agent),
    FOREIGN KEY(id_speciality) REFERENCES Speciality(id_speciality)
) engine=INNODB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS Mission (
    id_mission INTEGER(4) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    code_name VARCHAR(50) NOT NULL UNIQUE,
    title VARCHAR(50) NOT NULL,
    description TEXT,
    country VARCHAR(50) NOT NULL,
    type VARCHAR(50) NOT NULL,
    status VARCHAR(50) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    id_speciality INTEGER(4) NOT NULL,
    FOREIGN KEY(id_speciality) REFERENCES Speciality(id_speciality)
) engine=INNODB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS MissionAgent (
    id_mission INTEGER(4) NOT NULL,
    id_agent INTEGER(4) NOT NULL,
    PRIMARY KEY(id_mission, id_agent),
    FOREIGN KEY(id_mission) REFERENCES Mission(id_mission),
    FOREIGN KEY(id_agent) REFERENCES Agent(id_agent)
) engine=INNODB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS Contact (
    id_contact INTEGER(4) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    birthdate DATE NOT NULL,
    nationality VARCHAR(50) NOT NULL
) engine=INNODB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS MissionContact (
    id_mission INTEGER(4) NOT NULL,
    id_contact INTEGER(4) NOT NULL,
    PRIMARY KEY(id_mission, id_contact),
    FOREIGN KEY(id_mission) REFERENCES Mission(id_mission),
    FOREIGN KEY(id_contact) REFERENCES Contact(id_contact)
) engine=INNODB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS Target (
    id_target INTEGER(4) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    birthdate DATE NOT NULL,
    nationality VARCHAR(50) NOT NULL
) engine=INNODB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS MissionTarget (
    id_mission INTEGER(4) NOT NULL,
    id_target INTEGER(4) NOT NULL,
    PRIMARY KEY(id_mission, id_target),
    FOREIGN KEY(id_mission) REFERENCES Mission(id_mission),
    FOREIGN KEY(id_target) REFERENCES Target(id_target)
) engine=INNODB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS Stash (
    id_stash INTEGER(4) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    address TEXT NOT NULL,
    country VARCHAR(50) NOT NULL,
    type VARCHAR(50) NOT NULL
) engine=INNODB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS MissionStash (
    id_mission INTEGER(4) NOT NULL,
    id_stash INTEGER(4) NOT NULL,
    PRIMARY KEY(id_mission, id_stash),
    FOREIGN KEY(id_mission) REFERENCES Mission(id_mission),
    FOREIGN KEY(id_stash) REFERENCES Stash(id_stash)
) engine=INNODB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS Administrator (
    id_admin INTEGER(4) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(254) NOT NULL,
    password VARCHAR (100) NOT NULL,
    created_at DATE NOT NULL
) engine=INNODB DEFAULT CHARSET=utf8mb4;

/**********************************************************************************************/

/* Insertion de valeurs exemples dans l'ensemble des tables */
INSERT INTO Agent (id_agent, firstname, lastname, birthdate, nationality) VALUES (1, 'Devin', 'Dale', '1993-03-17', 'Chine');
INSERT INTO Agent (id_agent, firstname, lastname, birthdate, nationality) VALUES (2, 'Quinlan', 'Dawidman', '1993-10-15', 'Japon');
INSERT INTO Agent (id_agent, firstname, lastname, birthdate, nationality) VALUES (3, 'Addi', 'Gourdon', '1988-02-07', 'Chine');
INSERT INTO Agent (id_agent, firstname, lastname, birthdate, nationality) VALUES (4, 'Delly', 'Dorre', '1989-06-27', 'Laos');
INSERT INTO Agent (id_agent, firstname, lastname, birthdate, nationality) VALUES (5, 'Alix', 'Wright', '1982-08-01', 'Pologne');
INSERT INTO Agent (id_agent, firstname, lastname, birthdate, nationality) VALUES (6, 'Claudetta', 'Jeanin', '1991-05-20', 'Jordanie');
INSERT INTO Agent (id_agent, firstname, lastname, birthdate, nationality) VALUES (7, 'Annora', 'Landsman', '1986-05-19', 'Suede');
INSERT INTO Agent (id_agent, firstname, lastname, birthdate, nationality) VALUES (8, 'Darb', 'Stagg', '1995-02-15', 'Iran');
INSERT INTO Agent (id_agent, firstname, lastname, birthdate, nationality) VALUES (9, 'Daniela', 'Logie', '1990-02-03', 'Chine');
INSERT INTO Agent (id_agent, firstname, lastname, birthdate, nationality) VALUES (10, 'Alain', 'Jesper', '1999-03-31', 'Indonesie');
INSERT INTO Agent (id_agent, firstname, lastname, birthdate, nationality) VALUES (11, 'Bendite', 'Bosche', '1985-03-26', 'Vietnam');
INSERT INTO Agent (id_agent, firstname, lastname, birthdate, nationality) VALUES (12, 'Ikey', 'Bruggen', '1982-10-30', 'Afghanistan');
INSERT INTO Agent (id_agent, firstname, lastname, birthdate, nationality) VALUES (13, 'Rudie', 'Bogaert', '1997-05-19', 'Russie');
INSERT INTO Agent (id_agent, firstname, lastname, birthdate, nationality) VALUES (14, 'Isobel', 'Burgh', '1991-12-23', 'Afrique du Sud');
INSERT INTO Agent (id_agent, firstname, lastname, birthdate, nationality) VALUES (15, 'Jena', 'Deehan', '1998-08-18', 'Indonesie');
INSERT INTO Agent (id_agent, firstname, lastname, birthdate, nationality) VALUES (16, 'Madella', 'Widdicombe', '1999-01-16', 'Portugal');
INSERT INTO Agent (id_agent, firstname, lastname, birthdate, nationality) VALUES (17, 'Ansel', 'Thornthwaite', '1983-04-14', 'Portugal');
INSERT INTO Agent (id_agent, firstname, lastname, birthdate, nationality) VALUES (18, 'Muriel', 'Minney', '1982-12-18', 'Pologne');
INSERT INTO Agent (id_agent, firstname, lastname, birthdate, nationality) VALUES (19, 'Corrine', 'Leeson', '1990-12-19', 'Etats-Unis');
INSERT INTO Agent (id_agent, firstname, lastname, birthdate, nationality) VALUES (20, 'Ethan', 'Fellgate', '1997-10-02', 'Philippines');

INSERT INTO Speciality (id_speciality, name) VALUES (1, 'Art Martiaux');
INSERT INTO Speciality (id_speciality, name) VALUES (2, 'Cryptologie');
INSERT INTO Speciality (id_speciality, name) VALUES (3, 'Hack informatique');
INSERT INTO Speciality (id_speciality, name) VALUES (4, 'Caméléon');
INSERT INTO Speciality (id_speciality, name) VALUES (5, 'Expert Armes');
INSERT INTO Speciality (id_speciality, name) VALUES (6, 'Pilote de chasse');
INSERT INTO Speciality (id_speciality, name) VALUES (7, 'Course voiture');
INSERT INTO Speciality (id_speciality, name) VALUES (8, 'Séduction');
INSERT INTO Speciality (id_speciality, name) VALUES (9, 'Passe-partout');
INSERT INTO Speciality (id_speciality, name) VALUES (10, 'Sports extrême');

INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (2, 3);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (1, 1);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (3, 5);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (4, 2);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (4, 3);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (5, 6);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (6, 7);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (7, 4);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (7, 8);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (7, 9);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (8, 10);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (9, 5);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (10, 5);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (11, 10);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (12, 1);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (13, 1);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (13, 2);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (14, 8);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (15, 9);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (16, 8);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (16, 7);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (16, 10);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (17, 4);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (18, 4);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (19, 3);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (20, 6);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (20, 7);
INSERT INTO AgentSpeciality (id_agent, id_speciality) VALUES (20, 10);

INSERT INTO Mission (id_mission, code_name, title, description, country, type, status, start_date, end_date, id_speciality) VALUES (1, 'Aphrodite', 'Mission 1', 'Pariatur sint duis Lorem dolore amet commodo tempor velit quis consectetur adipisicing exercitation.', 'France', 'Infiltration', 'En cours', '2022-02-01', '2023-03-01', 1);
INSERT INTO Mission (id_mission, code_name, title, description, country, type, status, start_date, end_date, id_speciality) VALUES (2, 'Apollon', 'Mission 2', 'Ipsum nisi et duis veniam duis occaecat ullamco id proident magna velit.', 'Perou', 'Assassinat', 'Terminé', '2022-04-15', '2022-05-12', 5);
INSERT INTO Mission (id_mission, code_name, title, description, country, type, status, start_date, end_date, id_speciality) VALUES (3, 'Ares', 'Mission 3', 'Nulla excepteur ullamco voluptate in deserunt.', 'Angleterre', 'Assassinat', 'Terminé', '2022-04-17', '2022-05-19', 6);
INSERT INTO Mission (id_mission, code_name, title, description, country, type, status, start_date, end_date, id_speciality) VALUES (4, 'Artemis', 'Mission 4', 'Commodo laborum duis quis Lorem quis qui aliqua.', 'Russie', 'Infiltration', 'Terminé', '2022-05-02', '2022-06-06', 9);
INSERT INTO Mission (id_mission, code_name, title, description, country, type, status, start_date, end_date, id_speciality) VALUES (5, 'Athena', 'Mission 5', 'Ut aliquip magna est quis minim aute sint duis aute.', 'Chine', 'Surveillance', 'En préparation', '2022-05-08', '2022-12-15', 3);
INSERT INTO Mission (id_mission, code_name, title, description, country, type, status, start_date, end_date, id_speciality) VALUES (6, 'Demeter', 'Mission 6', 'Ullamco laboris aliqua est nulla officia eiusmod do elit officia dolore tempor ullamco do amet.', 'Japon', 'Surveillance', 'En cours', '2022-06-08', '2023-05-06', 2);
INSERT INTO Mission (id_mission, code_name, title, description, country, type, status, start_date, end_date, id_speciality) VALUES (7, 'Dionysos', 'Mission 7', 'Commodo voluptate non reprehenderit ex sunt minim cillum labore amet elit anim sint officia.', 'Thailande', 'Liberation', 'En cours', '2022-06-09', '2022-09-09', 4);
INSERT INTO Mission (id_mission, code_name, title, description, country, type, status, start_date, end_date, id_speciality) VALUES (8, 'Hades', 'Mission 8', 'Sit aliquip ea laboris duis laboris do labore excepteur dolor elit amet.', 'Italie', 'Liberation', 'Terminé', '2022-06-15', '2022-06-20', 7);
INSERT INTO Mission (id_mission, code_name, title, description, country, type, status, start_date, end_date, id_speciality) VALUES (9, 'Hephaistos', 'Mission 9', 'Esse eiusmod occaecat amet aliquip exercitation veniam officia enim amet occaecat dolore.', 'Canada', 'Infiltration', 'Terminé', '2022-06-16', '2022-06-21', 8);
INSERT INTO Mission (id_mission, code_name, title, description, country, type, status, start_date, end_date, id_speciality) VALUES (10, 'Hera', 'Mission 10', 'Ea ut ad deserunt velit.', 'Espagne', 'Infiltration', 'Echec', '2022-06-16', '2022-07-15', 10);
INSERT INTO Mission (id_mission, code_name, title, description, country, type, status, start_date, end_date, id_speciality) VALUES (11, 'Hermes', 'Mission 11', 'Dolor nisi irure nisi sit officia exercitation veniam ullamco do deserunt nostrud cupidatat.', 'Inde', 'Liberation', 'En préparation', '2022-06-20', '2024-09-25', 5);
INSERT INTO Mission (id_mission, code_name, title, description, country, type, status, start_date, end_date, id_speciality) VALUES (12, 'Hestia', 'Mission 12', 'Veniam est irure elit commodo laboris sint laborum est do.', 'Nepal', 'Liberation', 'Echec', '2022-07-01', '2022-07-10', 4);
INSERT INTO Mission (id_mission, code_name, title, description, country, type, status, start_date, end_date, id_speciality) VALUES (13, 'Poseidon', 'Mission 13', 'Est ut ullamco veniam esse nulla duis aliqua culpa fugiat cillum aute esse.', 'France', 'Assassinat', 'En cours', '2022-07-05', '2022-07-08', 5);
INSERT INTO Mission (id_mission, code_name, title, description, country, type, status, start_date, end_date, id_speciality) VALUES (14, 'Zeus', 'Mission 14', 'Veniam duis consequat adipisicing incididunt.', 'Etats-Unis', 'Surveillance', 'Echec', '2022-07-06', '2022-07-10', 3);
INSERT INTO Mission (id_mission, code_name, title, description, country, type, status, start_date, end_date, id_speciality) VALUES (15, 'Ananke', 'Mission 15', 'Non proident veniam mollit labore velit laborum eu consequat velit laboris ut aliquip.', 'Bresil', 'Liberation', 'En cours', '2022-07-06', '2022-07-11', 1);

INSERT INTO MissionAgent (id_mission, id_agent) VALUES (1, 1);
INSERT INTO MissionAgent (id_mission, id_agent) VALUES (1, 2);
INSERT INTO MissionAgent (id_mission, id_agent) VALUES (2, 3);
INSERT INTO MissionAgent (id_mission, id_agent) VALUES (3, 5);
INSERT INTO MissionAgent (id_mission, id_agent) VALUES (4, 7);
INSERT INTO MissionAgent (id_mission, id_agent) VALUES (5, 2);
INSERT INTO MissionAgent (id_mission, id_agent) VALUES (6, 4);
INSERT INTO MissionAgent (id_mission, id_agent) VALUES (7, 17);
INSERT INTO MissionAgent (id_mission, id_agent) VALUES (7, 14);
INSERT INTO MissionAgent (id_mission, id_agent) VALUES (7, 13);
INSERT INTO MissionAgent (id_mission, id_agent) VALUES (7, 20);
INSERT INTO MissionAgent (id_mission, id_agent) VALUES (8, 6);
INSERT INTO MissionAgent (id_mission, id_agent) VALUES (9, 16);
INSERT INTO MissionAgent (id_mission, id_agent) VALUES (10, 8);
INSERT INTO MissionAgent (id_mission, id_agent) VALUES (11, 10);
INSERT INTO MissionAgent (id_mission, id_agent) VALUES (11, 11);
INSERT INTO MissionAgent (id_mission, id_agent) VALUES (12, 18);
INSERT INTO MissionAgent (id_mission, id_agent) VALUES (13, 9);
INSERT INTO MissionAgent (id_mission, id_agent) VALUES (13, 15);
INSERT INTO MissionAgent (id_mission, id_agent) VALUES (13, 17);
INSERT INTO MissionAgent (id_mission, id_agent) VALUES (14, 19);
INSERT INTO MissionAgent (id_mission, id_agent) VALUES (15, 12);

INSERT INTO Contact (id_contact, firstname, lastname, birthdate, nationality) VALUES (1, 'Gilly', 'Juggings', '1982-09-08', 'France');
INSERT INTO Contact (id_contact, firstname, lastname, birthdate, nationality) VALUES (2, 'Karel', 'Edensor', '1991-08-27', 'Perou');
INSERT INTO Contact (id_contact, firstname, lastname, birthdate, nationality) VALUES (3, 'Bartel', 'Swalwell', '2002-04-03', 'Angleterre');
INSERT INTO Contact (id_contact, firstname, lastname, birthdate, nationality) VALUES (4, 'Derril', 'Grent', '1996-10-09', 'Russie');
INSERT INTO Contact (id_contact, firstname, lastname, birthdate, nationality) VALUES (5, 'Suzie', 'McMakin', '2001-04-20', 'Chine');
INSERT INTO Contact (id_contact, firstname, lastname, birthdate, nationality) VALUES (6, 'Bess', 'Willey', '1999-06-29', 'Japon');
INSERT INTO Contact (id_contact, firstname, lastname, birthdate, nationality) VALUES (7, 'Isabelle', 'Feron', '1985-05-28', 'Thailande');
INSERT INTO Contact (id_contact, firstname, lastname, birthdate, nationality) VALUES (8, 'Emelyne', 'Humbert', '1988-08-25', 'Italie');
INSERT INTO Contact (id_contact, firstname, lastname, birthdate, nationality) VALUES (9, 'Elden', 'Cawthery', '1982-02-24', 'Canada');
INSERT INTO Contact (id_contact, firstname, lastname, birthdate, nationality) VALUES (10, 'Rosco', 'Cliffe', '1989-05-16', 'Espagne');
INSERT INTO Contact (id_contact, firstname, lastname, birthdate, nationality) VALUES (11, 'Cammi', 'Crossby', '1992-11-12', 'Inde');
INSERT INTO Contact (id_contact, firstname, lastname, birthdate, nationality) VALUES (12, 'Laina', 'MacGettigen', '1983-04-11', 'Nepal');
INSERT INTO Contact (id_contact, firstname, lastname, birthdate, nationality) VALUES (13, 'Mord', 'Carstairs', '1992-12-29', 'France');
INSERT INTO Contact (id_contact, firstname, lastname, birthdate, nationality) VALUES (14, 'Noellyn', 'Outright', '1999-08-07', 'Etats-Unis');
INSERT INTO Contact (id_contact, firstname, lastname, birthdate, nationality) VALUES (15, 'Conchita', 'Ballham', '1996-11-10', 'Bresil');
INSERT INTO Contact (id_contact, firstname, lastname, birthdate, nationality) VALUES (16, 'Scotti', 'Waddam', '1994-01-21', 'Russie');
INSERT INTO Contact (id_contact, firstname, lastname, birthdate, nationality) VALUES (17, 'Davidde', 'Curragh', '1982-03-16', 'Chine');
INSERT INTO Contact (id_contact, firstname, lastname, birthdate, nationality) VALUES (18, 'Rikki', 'MacPadene', '1997-05-25', 'Inde');
INSERT INTO Contact (id_contact, firstname, lastname, birthdate, nationality) VALUES (19, 'Celia', 'Collings', '2000-07-16', 'Bresil');
INSERT INTO Contact (id_contact, firstname, lastname, birthdate, nationality) VALUES (20, 'Rutger', 'Messager', '1987-12-17', 'France');

INSERT INTO MissionContact (id_mission, id_contact) VALUES (1, 1);
INSERT INTO MissionContact (id_mission, id_contact) VALUES (1, 20);
INSERT INTO MissionContact (id_mission, id_contact) VALUES (2, 2);
INSERT INTO MissionContact (id_mission, id_contact) VALUES (3, 3);
INSERT INTO MissionContact (id_mission, id_contact) VALUES (4, 4);
INSERT INTO MissionContact (id_mission, id_contact) VALUES (4, 16);
INSERT INTO MissionContact (id_mission, id_contact) VALUES (5, 5);
INSERT INTO MissionContact (id_mission, id_contact) VALUES (5, 17);
INSERT INTO MissionContact (id_mission, id_contact) VALUES (6, 6);
INSERT INTO MissionContact (id_mission, id_contact) VALUES (7, 7);
INSERT INTO MissionContact (id_mission, id_contact) VALUES (8, 8);
INSERT INTO MissionContact (id_mission, id_contact) VALUES (9, 9);
INSERT INTO MissionContact (id_mission, id_contact) VALUES (10, 10);
INSERT INTO MissionContact (id_mission, id_contact) VALUES (11, 11);
INSERT INTO MissionContact (id_mission, id_contact) VALUES (11, 18);
INSERT INTO MissionContact (id_mission, id_contact) VALUES (12, 12);
INSERT INTO MissionContact (id_mission, id_contact) VALUES (13, 13);
INSERT INTO MissionContact (id_mission, id_contact) VALUES (14, 14);
INSERT INTO MissionContact (id_mission, id_contact) VALUES (15, 15);
INSERT INTO MissionContact (id_mission, id_contact) VALUES (15, 19);

INSERT INTO Target (id_target, firstname, lastname, birthdate, nationality) VALUES (1, 'Kirstin', 'De La Coste', '1987-11-22', 'Slovenie');
INSERT INTO Target (id_target, firstname, lastname, birthdate, nationality) VALUES (2, 'Chrissie', 'Milbank', '2000-07-18', 'Chine');
INSERT INTO Target (id_target, firstname, lastname, birthdate, nationality) VALUES (3, 'Mead', 'Lamberth', '1981-04-19', 'Portugal');
INSERT INTO Target (id_target, firstname, lastname, birthdate, nationality) VALUES (4, 'Maurise', 'Kyston', '1989-10-07', 'Chine');
INSERT INTO Target (id_target, firstname, lastname, birthdate, nationality) VALUES (5, 'Rosalinde', 'Kener', '1992-06-03', 'Afghanistan');
INSERT INTO Target (id_target, firstname, lastname, birthdate, nationality) VALUES (6, 'Jorie', 'Lonsdale', '1988-02-21', 'Indonesie');
INSERT INTO Target (id_target, firstname, lastname, birthdate, nationality) VALUES (7, 'Felic', 'De Vaux', '1992-10-08', 'Libye');
INSERT INTO Target (id_target, firstname, lastname, birthdate, nationality) VALUES (8, 'Petey', 'Scarman', '1999-09-22', 'Indonesie');
INSERT INTO Target (id_target, firstname, lastname, birthdate, nationality) VALUES (9, 'Reeva', 'Winham', '1993-10-24', 'Indonesie');
INSERT INTO Target (id_target, firstname, lastname, birthdate, nationality) VALUES (10, 'Sarina', 'Pillifant', '1982-04-14', 'Argentine');
INSERT INTO Target (id_target, firstname, lastname, birthdate, nationality) VALUES (11, 'Toddy', 'Matteini', '1989-12-11', 'Chine');
INSERT INTO Target (id_target, firstname, lastname, birthdate, nationality) VALUES (12, 'Antonella', 'Pendred', '1996-02-10', 'Philippines');
INSERT INTO Target (id_target, firstname, lastname, birthdate, nationality) VALUES (13, 'Linnea', 'Ames', '1999-04-17', 'Indonesie');
INSERT INTO Target (id_target, firstname, lastname, birthdate, nationality) VALUES (14, 'Stevy', 'Dell ''Orto', '1986-04-27', 'Burundi');
INSERT INTO Target (id_target, firstname, lastname, birthdate, nationality) VALUES (15, 'Ennis', 'Gower', '1995-06-19', 'France');
INSERT INTO Target (id_target, firstname, lastname, birthdate, nationality) VALUES (16, 'Lowell', 'Youngman', '1986-06-28', 'Russie');
INSERT INTO Target (id_target, firstname, lastname, birthdate, nationality) VALUES (17, 'Lewes', 'Taylot', '1998-04-02', 'Chine');
INSERT INTO Target (id_target, firstname, lastname, birthdate, nationality) VALUES (18, 'Trudi', 'Burk', '1999-10-04', 'Portugal');
INSERT INTO Target (id_target, firstname, lastname, birthdate, nationality) VALUES (19, 'Walther', 'Fowells', '1984-10-16', 'Suede');
INSERT INTO Target (id_target, firstname, lastname, birthdate, nationality) VALUES (20, 'Raviv', 'Oleszkiewicz', '2001-09-10', 'Philippines');

INSERT INTO MissionTarget (id_mission, id_target) VALUES (1, 1);
INSERT INTO MissionTarget (id_mission, id_target) VALUES (2, 3);
INSERT INTO MissionTarget (id_mission, id_target) VALUES (3, 2);
INSERT INTO MissionTarget (id_mission, id_target) VALUES (4, 4);
INSERT INTO MissionTarget (id_mission, id_target) VALUES (5, 5);
INSERT INTO MissionTarget (id_mission, id_target) VALUES (6, 6);
INSERT INTO MissionTarget (id_mission, id_target) VALUES (7, 7);
INSERT INTO MissionTarget (id_mission, id_target) VALUES (7, 19);
INSERT INTO MissionTarget (id_mission, id_target) VALUES (7, 17);
INSERT INTO MissionTarget (id_mission, id_target) VALUES (8, 8);
INSERT INTO MissionTarget (id_mission, id_target) VALUES (8, 16);
INSERT INTO MissionTarget (id_mission, id_target) VALUES (9, 9);
INSERT INTO MissionTarget (id_mission, id_target) VALUES (10, 10);
INSERT INTO MissionTarget (id_mission, id_target) VALUES (11, 11);
INSERT INTO MissionTarget (id_mission, id_target) VALUES (12, 12);
INSERT INTO MissionTarget (id_mission, id_target) VALUES (13, 14);
INSERT INTO MissionTarget (id_mission, id_target) VALUES (14, 13);
INSERT INTO MissionTarget (id_mission, id_target) VALUES (14, 20);
INSERT INTO MissionTarget (id_mission, id_target) VALUES (15, 15);
INSERT INTO MissionTarget (id_mission, id_target) VALUES (15, 18);

INSERT INTO Stash (id_stash, address, country, type) VALUES (1, '8 Vahlen Pass', 'France', 'Maison');
INSERT INTO Stash (id_stash, address, country, type) VALUES (2, '36 Myrtle Park', 'Perou', 'Cave');
INSERT INTO Stash (id_stash, address, country, type) VALUES (3, '231 Butternut Street', 'Angleterre', 'Cave');
INSERT INTO Stash (id_stash, address, country, type) VALUES (4, '4 Rowland Center', 'Russie', 'Camion');
INSERT INTO Stash (id_stash, address, country, type) VALUES (5, '23 Amoth Point', 'Chine', 'Cave');
INSERT INTO Stash (id_stash, address, country, type) VALUES (6, '441 Bellgrove Place', 'Japon', 'Appartement');
INSERT INTO Stash (id_stash, address, country, type) VALUES (7, '75059 Brown Point', 'Thailande', 'Appartement');
INSERT INTO Stash (id_stash, address, country, type) VALUES (8, '230 Independence Place', 'Italie', 'Bureau');
INSERT INTO Stash (id_stash, address, country, type) VALUES (9, '809 Ohio Pass', 'Canada', 'Appartement');
INSERT INTO Stash (id_stash, address, country, type) VALUES (10, '97 Hollow Ridge Lane', 'Espagne', 'Maison');
INSERT INTO Stash (id_stash, address, country, type) VALUES (11, '7058 Banding Parkway', 'Indie', 'Cave');
INSERT INTO Stash (id_stash, address, country, type) VALUES (12, '84 Service Street', 'Nepal', 'Appartement');
INSERT INTO Stash (id_stash, address, country, type) VALUES (13, '64265 Sommers Drive', 'France', 'Bureau');
INSERT INTO Stash (id_stash, address, country, type) VALUES (14, '2 Westerfield Way', 'Etats-Unis', 'Appartement');
INSERT INTO Stash (id_stash, address, country, type) VALUES (15, '8357 Bayside Drive', 'Bresil', 'Maison');
INSERT INTO Stash (id_stash, address, country, type) VALUES (16, '755 Luster Hill', 'Italie', 'Maison');
INSERT INTO Stash (id_stash, address, country, type) VALUES (17, '0057 Ramsey Point', 'Chine', 'Bureau');
INSERT INTO Stash (id_stash, address, country, type) VALUES (18, '3 Blue Bill Park Plaza', 'Inde', 'Camion');
INSERT INTO Stash (id_stash, address, country, type) VALUES (19, '361 Eliot Road', 'Nepal', 'Cave');
INSERT INTO Stash (id_stash, address, country, type) VALUES (20, '30110 Brentwood Way', 'Perou', 'Bureau');

INSERT INTO MissionStash (id_mission, id_stash) VALUES (1, 1);
INSERT INTO MissionStash (id_mission, id_stash) VALUES (2, 2);
INSERT INTO MissionStash (id_mission, id_stash) VALUES (2, 20);
INSERT INTO MissionStash (id_mission, id_stash) VALUES (3, 3);
INSERT INTO MissionStash (id_mission, id_stash) VALUES (4, 4);
INSERT INTO MissionStash (id_mission, id_stash) VALUES (5, 5);
INSERT INTO MissionStash (id_mission, id_stash) VALUES (5, 17);
INSERT INTO MissionStash (id_mission, id_stash) VALUES (6, 6);
INSERT INTO MissionStash (id_mission, id_stash) VALUES (7, 7);
INSERT INTO MissionStash (id_mission, id_stash) VALUES (8, 8);
INSERT INTO MissionStash (id_mission, id_stash) VALUES (8, 16);
INSERT INTO MissionStash (id_mission, id_stash) VALUES (9, 9);
INSERT INTO MissionStash (id_mission, id_stash) VALUES (10, 10);
INSERT INTO MissionStash (id_mission, id_stash) VALUES (11, 11);
INSERT INTO MissionStash (id_mission, id_stash) VALUES (11, 18);
INSERT INTO MissionStash (id_mission, id_stash) VALUES (12, 12);
INSERT INTO MissionStash (id_mission, id_stash) VALUES (12, 19);
INSERT INTO MissionStash (id_mission, id_stash) VALUES (13, 13);
INSERT INTO MissionStash (id_mission, id_stash) VALUES (13, 1);
INSERT INTO MissionStash (id_mission, id_stash) VALUES (14, 14);
INSERT INTO MissionStash (id_mission, id_stash) VALUES (15, 15);

INSERT INTO Administrator (id_admin, firstname, lastname, email, password, created_at) VALUES (1, 'Mathieu', 'Bouthors', 'mathieubouthors@hotmail.com', '$2y$10$G.3vcLJlpKgXL/.ro0BvKuCR.Hcix6nAewHoaeNCPwd8ACxKcIn.2', '2022-07-15');
INSERT INTO Administrator (id_admin, firstname, lastname, email, password, created_at) VALUES (2, 'studi', 'studi', 'studi@gmail.com', '$2y$10$RpJhW99yYHXAsVLzsxooa.J8UIgQgHQmMRGy35sztlkqSpIWCo9Ha', '2022-07-16');
INSERT INTO Administrator (id_admin, firstname, lastname, email, password, created_at) VALUES (3, 'Leena', 'Aylwin', 'laylwin2@google.cn', '$2y$10$9USMqYMT9VgyBXHXn9SomesuYUqlx/jArgcy4w0om.bLbXJmA1uOG', '2022-07-17');
INSERT INTO Administrator (id_admin, firstname, lastname, email, password, created_at) VALUES (4, 'Hermione', 'Millard', 'hmillard3@psu.edu', '$2y$10$BGNk9getX/oJCUQodG/YuO84K.8URl/GCVwMPaJHrL3gRCI7HVTFW', '2022-07-18');
INSERT INTO Administrator (id_admin, firstname, lastname, email, password, created_at) VALUES (5, 'Stanislaus', 'Leaburn', 'sleaburn4@fema.gov', '$2y$10$8mFSP4NkKcyWh7A8czKEJOkYnFe.qOWRFqg//vMsC60lzh5NZv/3S', '2022-07-19');

/**********************************************************************************************/

/* Affiche toutes les missions et le détails */
SELECT title AS Mission, id_mission AS CodeName, country AS Pays, type AS Type, status AS Statut, start_date AS Date_de_début, end_date AS Date_de_fin FROM Mission ORDER BY;


SELECT Mission.id_mission, code_name, title, description, Mission.country, Mission.type, status, start_date, end_date, 
Speciality.name AS speciality, 
Agent.firstname AS firstnameAgent, Agent.lastname AS lastnameAgent,
Contact.firstname AS firstnameContact, Contact.lastname AS lastnameContact,
Target.firstname AS firstnameTarget, Target.lastname AS lastnameTarget,
Stash.type AS stashType
FROM Mission
INNER JOIN Speciality ON Mission.id_speciality = Speciality.id_speciality
INNER JOIN MissionAgent ON Mission.id_mission = MissionAgent.id_mission
INNER JOIN Agent ON MissionAgent.id_agent = Agent.id_agent
INNER JOIN MissionContact ON Mission.id_mission = MissionContact.id_mission
INNER JOIN Contact ON MissionContact.id_contact = Contact.id_contact
INNER JOIN MissionTarget ON Mission.id_mission = MissionTarget.id_mission
INNER JOIN Target ON MissionTarget.id_target = Target.id_target
INNER JOIN MissionStash ON Mission.id_mission = MissionStash.id_mission
INNER JOIN Stash ON MissionStash.id_stash = stash.id_stash
ORDER BY start_date, title;

<iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5661869.639753694!2d-2.4333266947231347!3d46.13910021019738!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd54a02933785731%3A0x6bfd3f96c747d9f7!2sFrance!5e0!3m2!1sfr!2sfr!4v1658739781428!5m2!1sfr!2sfr"
                        width="350" height="200" style="border:0;" allowfullscreen="" loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>