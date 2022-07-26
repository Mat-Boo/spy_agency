/* Création de la base de donnes spy_agency */
CREATE DATABASE IF NOT EXISTS spy_agency CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

/**********************************************************************************************/

/* Création de toutes les tables avec les contraintes */
CREATE TABLE IF NOT EXISTS Agent (
    id_code_agent INTEGER(4) PRIMARY KEY NOT NULL AUTO_INCREMENT,
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
    id_code_agent INTEGER(4) NOT NULL,
    id_speciality INTEGER(4) NOT NULL,
    PRIMARY KEY(id_code_agent, id_speciality),
    FOREIGN KEY(id_code_agent) REFERENCES Agent(id_code_agent),
    FOREIGN KEY(id_speciality) REFERENCES Speciality(id_speciality)
) engine=INNODB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS Mission (
    id_code_mission VARCHAR(50) PRIMARY KEY NOT NULL,
    title VARCHAR(50) NOT NULL,
    description TEXT,
    country VARCHAR(50) NOT NULL,
    type VARCHAR(50) NOT NULL,
    status VARCHAR(50) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    id_speciality INTEGER(4) NOT NULL AUTO_INCREMENT,
    FOREIGN KEY(id_speciality) REFERENCES Speciality(id_speciality)
) engine=INNODB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS MissionAgent (
    id_code_mission VARCHAR(50) NOT NULL,
    id_code_agent INTEGER(4) NOT NULL AUTO_INCREMENT,
    PRIMARY KEY(id_code_mission, id_code_agent),
    FOREIGN KEY(id_code_mission) REFERENCES Mission(id_code_mission),
    FOREIGN KEY(id_code_agent) REFERENCES Agent(id_code_agent)
) engine=INNODB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS Contact (
    code_name_contact INTEGER(4) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    birthdate DATE NOT NULL,
    nationality VARCHAR(50) NOT NULL
) engine=INNODB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS MissionContact (
    id_code_mission VARCHAR(50) NOT NULL,
    code_name_contact INTEGER(4) NOT NULL AUTO_INCREMENT,
    PRIMARY KEY(id_code_mission, code_name_contact),
    FOREIGN KEY(id_code_mission) REFERENCES Mission(id_code_mission),
    FOREIGN KEY(code_name_contact) REFERENCES Contact(code_name_contact)
) engine=INNODB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS Target (
    code_name_target INTEGER(4) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    birthdate DATE NOT NULL,
    nationality VARCHAR(50) NOT NULL
) engine=INNODB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS MissionTarget (
    id_code_mission VARCHAR(50) NOT NULL,
    code_name_target INTEGER(4) NOT NULL AUTO_INCREMENT,
    PRIMARY KEY(id_code_mission, code_name_target),
    FOREIGN KEY(id_code_mission) REFERENCES Mission(id_code_mission),
    FOREIGN KEY(code_name_target) REFERENCES Target(code_name_target)
) engine=INNODB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS Stash (
    id_code_stash INTEGER(4) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    address TEXT NOT NULL,
    country VARCHAR(50) NOT NULL,
    type VARCHAR(50) NOT NULL
) engine=INNODB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS MissionStash (
    id_code_mission VARCHAR(50) NOT NULL,
    id_code_stash INTEGER(4) NOT NULL AUTO_INCREMENT,
    PRIMARY KEY(id_code_mission, id_code_stash),
    FOREIGN KEY(id_code_mission) REFERENCES Mission(id_code_mission),
    FOREIGN KEY(id_code_stash) REFERENCES Stash(id_code_stash)
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
INSERT INTO Agent (id_code_agent, firstname, lastname, birthdate, nationality) VALUES (1, 'Devin', 'Dale', '1993-03-17', 'China');
INSERT INTO Agent (id_code_agent, firstname, lastname, birthdate, nationality) VALUES (2, 'Quinlan', 'Dawidman', '1993-10-15', 'Japan');
INSERT INTO Agent (id_code_agent, firstname, lastname, birthdate, nationality) VALUES (3, 'Addi', 'Gourdon', '1988-02-07', 'China');
INSERT INTO Agent (id_code_agent, firstname, lastname, birthdate, nationality) VALUES (4, 'Delly', 'Dorre', '1989-06-27', 'Belarus');
INSERT INTO Agent (id_code_agent, firstname, lastname, birthdate, nationality) VALUES (5, 'Alix', 'Wright', '1982-08-01', 'Poland');
INSERT INTO Agent (id_code_agent, firstname, lastname, birthdate, nationality) VALUES (6, 'Claudetta', 'Jeanin', '1991-05-20', 'Palestinian Territory');
INSERT INTO Agent (id_code_agent, firstname, lastname, birthdate, nationality) VALUES (7, 'Annora', 'Landsman', '1986-05-19', 'Sweden');
INSERT INTO Agent (id_code_agent, firstname, lastname, birthdate, nationality) VALUES (8, 'Darb', 'Stagg', '1995-02-15', 'Iran');
INSERT INTO Agent (id_code_agent, firstname, lastname, birthdate, nationality) VALUES (9, 'Daniela', 'Logie', '1990-02-03', 'China');
INSERT INTO Agent (id_code_agent, firstname, lastname, birthdate, nationality) VALUES (10, 'Alain', 'Jesper', '1999-03-31', 'Indonesia');
INSERT INTO Agent (id_code_agent, firstname, lastname, birthdate, nationality) VALUES (11, 'Bendite', 'Bosche', '1985-03-26', 'Vietnam');
INSERT INTO Agent (id_code_agent, firstname, lastname, birthdate, nationality) VALUES (12, 'Ikey', 'Bruggen', '1982-10-30', 'Afghanistan');
INSERT INTO Agent (id_code_agent, firstname, lastname, birthdate, nationality) VALUES (13, 'Rudie', 'Bogaert', '1997-05-19', 'Russia');
INSERT INTO Agent (id_code_agent, firstname, lastname, birthdate, nationality) VALUES (14, 'Isobel', 'Burgh', '1991-12-23', 'South Africa');
INSERT INTO Agent (id_code_agent, firstname, lastname, birthdate, nationality) VALUES (15, 'Jena', 'Deehan', '1998-08-18', 'Indonesia');
INSERT INTO Agent (id_code_agent, firstname, lastname, birthdate, nationality) VALUES (16, 'Madella', 'Widdicombe', '1999-01-16', 'Portugal');
INSERT INTO Agent (id_code_agent, firstname, lastname, birthdate, nationality) VALUES (17, 'Ansel', 'Thornthwaite', '1983-04-14', 'Portugal');
INSERT INTO Agent (id_code_agent, firstname, lastname, birthdate, nationality) VALUES (18, 'Muriel', 'Minney', '1982-12-18', 'Poland');
INSERT INTO Agent (id_code_agent, firstname, lastname, birthdate, nationality) VALUES (19, 'Corrine', 'Leeson', '1990-12-19', 'United-States');
INSERT INTO Agent (id_code_agent, firstname, lastname, birthdate, nationality) VALUES (20, 'Ethan', 'Fellgate', '1997-10-02', 'Philippines');

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

INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (1, 1);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (2, 3);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (3, 5);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (4, 2);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (4, 3);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (5, 6);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (6, 7);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (7, 4);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (7, 8);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (7, 9);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (8, 10);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (9, 5);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (10, 5);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (11, 10);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (12, 1);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (13, 1);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (13, 2);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (14, 8);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (15, 9);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (16, 8);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (16, 7);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (16, 10);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (17, 4);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (18, 4);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (19, 3);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (20, 6);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (20, 7);
INSERT INTO AgentSpeciality (id_code_agent, id_speciality) VALUES (20, 10);

INSERT INTO Mission (id_code_mission, title, description, country, type, status, start_date, end_date, id_speciality) VALUES ('Aphrodite', 'Mission 1', 'Pariatur sint duis Lorem dolore amet commodo tempor velit quis consectetur adipisicing exercitation.', 'France', 'Infiltration', 'En cours', '2022-02-01', '2023-03-01', 1);
INSERT INTO Mission (id_code_mission, title, description, country, type, status, start_date, end_date, id_speciality) VALUES ('Apollon', 'Mission 2', 'Ipsum nisi et duis veniam duis occaecat ullamco id proident magna velit.', 'Peru', 'Assassinat', 'Terminé', '2022-04-15', '2022-05-12', 5);
INSERT INTO Mission (id_code_mission, title, description, country, type, status, start_date, end_date, id_speciality) VALUES ('Ares', 'Mission 3', 'Nulla excepteur ullamco voluptate in deserunt.', 'England', 'Assassinat', 'Terminé', '2022-04-17', '2022-05-19', 6);
INSERT INTO Mission (id_code_mission, title, description, country, type, status, start_date, end_date, id_speciality) VALUES ('Artemis', 'Mission 4', 'Commodo laborum duis quis Lorem quis qui aliqua.', 'Russia', 'Infiltration', 'Terminé', '2022-05-02', '2022-06-06', 9);
INSERT INTO Mission (id_code_mission, title, description, country, type, status, start_date, end_date, id_speciality) VALUES ('Athena', 'Mission 5', 'Ut aliquip magna est quis minim aute sint duis aute.', 'China', 'Surveillance', 'En préparation', '2022-05-08', '2022-12-15', 3);
INSERT INTO Mission (id_code_mission, title, description, country, type, status, start_date, end_date, id_speciality) VALUES ('Demeter', 'Mission 6', 'Ullamco laboris aliqua est nulla officia eiusmod do elit officia dolore tempor ullamco do amet.', 'Japan', 'Surveillance', 'En cours', '2022-06-08', '2023-05-06', 2);
INSERT INTO Mission (id_code_mission, title, description, country, type, status, start_date, end_date, id_speciality) VALUES ('Dionysos', 'Mission 7', 'Commodo voluptate non reprehenderit ex sunt minim cillum labore amet elit anim sint officia.', 'Thailand', 'Liberation', 'En cours', '2022-06-09', '2022-09-09', 4);
INSERT INTO Mission (id_code_mission, title, description, country, type, status, start_date, end_date, id_speciality) VALUES ('Hades', 'Mission 8', 'Sit aliquip ea laboris duis laboris do labore excepteur dolor elit amet.', 'Italia', 'Liberation', 'Terminé', '2022-06-15', '2022-06-20', 7);
INSERT INTO Mission (id_code_mission, title, description, country, type, status, start_date, end_date, id_speciality) VALUES ('Hephaistos', 'Mission 9', 'Esse eiusmod occaecat amet aliquip exercitation veniam officia enim amet occaecat dolore.', 'Canada', 'Infiltration', 'Terminé', '2022-06-16', '2022-06-21', 8);
INSERT INTO Mission (id_code_mission, title, description, country, type, status, start_date, end_date, id_speciality) VALUES ('Hera', 'Mission 10', 'Ea ut ad deserunt velit.', 'Spain', 'Infiltration', 'Echec', '2022-06-16', '2022-07-15', 10);
INSERT INTO Mission (id_code_mission, title, description, country, type, status, start_date, end_date, id_speciality) VALUES ('Hermes', 'Mission 11', 'Dolor nisi irure nisi sit officia exercitation veniam ullamco do deserunt nostrud cupidatat.', 'India', 'Liberation', 'En préparation', '2022-06-20', '2024-09-25', 5);
INSERT INTO Mission (id_code_mission, title, description, country, type, status, start_date, end_date, id_speciality) VALUES ('Hestia', 'Mission 12', 'Veniam est irure elit commodo laboris sint laborum est do.', 'Nepal', 'Liberation', 'Echec', '2022-07-01', '2022-07-10', 4);
INSERT INTO Mission (id_code_mission, title, description, country, type, status, start_date, end_date, id_speciality) VALUES ('Poseidon', 'Mission 13', 'Est ut ullamco veniam esse nulla duis aliqua culpa fugiat cillum aute esse.', 'France', 'Assassinat', 'En cours', '2022-07-05', '2022-07-08', 5);
INSERT INTO Mission (id_code_mission, title, description, country, type, status, start_date, end_date, id_speciality) VALUES ('Zeus', 'Mission 14', 'Veniam duis consequat adipisicing incididunt.', 'United-States', 'Surveillance', 'Echec', '2022-07-06', '2022-07-10', 3);
INSERT INTO Mission (id_code_mission, title, description, country, type, status, start_date, end_date, id_speciality) VALUES ('Ananke', 'Mission 15', 'Non proident veniam mollit labore velit laborum eu consequat velit laboris ut aliquip.', 'Brazil', 'Liberation', 'En cours', '2022-07-06', '2022-07-11', 1);

INSERT INTO MissionAgent (id_code_mission, id_code_agent) VALUES ('Aphrodite', 1);
INSERT INTO MissionAgent (id_code_mission, id_code_agent) VALUES ('Aphrodite', 2);
INSERT INTO MissionAgent (id_code_mission, id_code_agent) VALUES ('Apollon', 3);
INSERT INTO MissionAgent (id_code_mission, id_code_agent) VALUES ('Ares', 5);
INSERT INTO MissionAgent (id_code_mission, id_code_agent) VALUES ('Artemis', 7);
INSERT INTO MissionAgent (id_code_mission, id_code_agent) VALUES ('Athena', 2);
INSERT INTO MissionAgent (id_code_mission, id_code_agent) VALUES ('Demeter', 4);
INSERT INTO MissionAgent (id_code_mission, id_code_agent) VALUES ('Dionysos', 17);
INSERT INTO MissionAgent (id_code_mission, id_code_agent) VALUES ('Dionysos', 14);
INSERT INTO MissionAgent (id_code_mission, id_code_agent) VALUES ('Dionysos', 13);
INSERT INTO MissionAgent (id_code_mission, id_code_agent) VALUES ('Dionysos', 20);
INSERT INTO MissionAgent (id_code_mission, id_code_agent) VALUES ('Hades', 6);
INSERT INTO MissionAgent (id_code_mission, id_code_agent) VALUES ('Hephaistos', 16);
INSERT INTO MissionAgent (id_code_mission, id_code_agent) VALUES ('Hera', 8);
INSERT INTO MissionAgent (id_code_mission, id_code_agent) VALUES ('Hermes', 10);
INSERT INTO MissionAgent (id_code_mission, id_code_agent) VALUES ('Hermes', 11);
INSERT INTO MissionAgent (id_code_mission, id_code_agent) VALUES ('Hestia', 18);
INSERT INTO MissionAgent (id_code_mission, id_code_agent) VALUES ('Poseidon', 9);
INSERT INTO MissionAgent (id_code_mission, id_code_agent) VALUES ('Poseidon', 15);
INSERT INTO MissionAgent (id_code_mission, id_code_agent) VALUES ('Poseidon', 17);
INSERT INTO MissionAgent (id_code_mission, id_code_agent) VALUES ('Zeus', 19);
INSERT INTO MissionAgent (id_code_mission, id_code_agent) VALUES ('Ananke', 12);

INSERT INTO Contact (code_name_contact, firstname, lastname, birthdate, nationality) VALUES (1, 'Gilly', 'Juggings', '1982-09-08', 'France');
INSERT INTO Contact (code_name_contact, firstname, lastname, birthdate, nationality) VALUES (2, 'Karel', 'Edensor', '1991-08-27', 'Peru');
INSERT INTO Contact (code_name_contact, firstname, lastname, birthdate, nationality) VALUES (3, 'Bartel', 'Swalwell', '2002-04-03', 'England');
INSERT INTO Contact (code_name_contact, firstname, lastname, birthdate, nationality) VALUES (4, 'Derril', 'Grent', '1996-10-09', 'Russia');
INSERT INTO Contact (code_name_contact, firstname, lastname, birthdate, nationality) VALUES (5, 'Suzie', 'McMakin', '2001-04-20', 'China');
INSERT INTO Contact (code_name_contact, firstname, lastname, birthdate, nationality) VALUES (6, 'Bess', 'Willey', '1999-06-29', 'Japan');
INSERT INTO Contact (code_name_contact, firstname, lastname, birthdate, nationality) VALUES (7, 'Isabelle', 'Feron', '1985-05-28', 'Thailand');
INSERT INTO Contact (code_name_contact, firstname, lastname, birthdate, nationality) VALUES (8, 'Emelyne', 'Humbert', '1988-08-25', 'Italia');
INSERT INTO Contact (code_name_contact, firstname, lastname, birthdate, nationality) VALUES (9, 'Elden', 'Cawthery', '1982-02-24', 'Canada');
INSERT INTO Contact (code_name_contact, firstname, lastname, birthdate, nationality) VALUES (10, 'Rosco', 'Cliffe', '1989-05-16', 'Spain');
INSERT INTO Contact (code_name_contact, firstname, lastname, birthdate, nationality) VALUES (11, 'Cammi', 'Crossby', '1992-11-12', 'India');
INSERT INTO Contact (code_name_contact, firstname, lastname, birthdate, nationality) VALUES (12, 'Laina', 'MacGettigen', '1983-04-11', 'Nepal');
INSERT INTO Contact (code_name_contact, firstname, lastname, birthdate, nationality) VALUES (13, 'Mord', 'Carstairs', '1992-12-29', 'France');
INSERT INTO Contact (code_name_contact, firstname, lastname, birthdate, nationality) VALUES (14, 'Noellyn', 'Outright', '1999-08-07', 'United-States');
INSERT INTO Contact (code_name_contact, firstname, lastname, birthdate, nationality) VALUES (15, 'Conchita', 'Ballham', '1996-11-10', 'Brazil');
INSERT INTO Contact (code_name_contact, firstname, lastname, birthdate, nationality) VALUES (16, 'Scotti', 'Waddam', '1994-01-21', 'Russia');
INSERT INTO Contact (code_name_contact, firstname, lastname, birthdate, nationality) VALUES (17, 'Davidde', 'Curragh', '1982-03-16', 'China');
INSERT INTO Contact (code_name_contact, firstname, lastname, birthdate, nationality) VALUES (18, 'Rikki', 'MacPadene', '1997-05-25', 'India');
INSERT INTO Contact (code_name_contact, firstname, lastname, birthdate, nationality) VALUES (19, 'Celia', 'Collings', '2000-07-16', 'Brazil');
INSERT INTO Contact (code_name_contact, firstname, lastname, birthdate, nationality) VALUES (20, 'Rutger', 'Messager', '1987-12-17', 'France');

INSERT INTO MissionContact (id_code_mission, code_name_contact) VALUES ('Aphrodite', 1);
INSERT INTO MissionContact (id_code_mission, code_name_contact) VALUES ('Aphrodite', 20);
INSERT INTO MissionContact (id_code_mission, code_name_contact) VALUES ('Apollon', 2);
INSERT INTO MissionContact (id_code_mission, code_name_contact) VALUES ('Ares', 3);
INSERT INTO MissionContact (id_code_mission, code_name_contact) VALUES ('Artemis', 4);
INSERT INTO MissionContact (id_code_mission, code_name_contact) VALUES ('Artemis', 16);
INSERT INTO MissionContact (id_code_mission, code_name_contact) VALUES ('Athena', 5);
INSERT INTO MissionContact (id_code_mission, code_name_contact) VALUES ('Athena', 17);
INSERT INTO MissionContact (id_code_mission, code_name_contact) VALUES ('Demeter', 6);
INSERT INTO MissionContact (id_code_mission, code_name_contact) VALUES ('Dionysos', 7);
INSERT INTO MissionContact (id_code_mission, code_name_contact) VALUES ('Hades', 8);
INSERT INTO MissionContact (id_code_mission, code_name_contact) VALUES ('Hephaistos', 9);
INSERT INTO MissionContact (id_code_mission, code_name_contact) VALUES ('Hera', 10);
INSERT INTO MissionContact (id_code_mission, code_name_contact) VALUES ('Hermes', 11);
INSERT INTO MissionContact (id_code_mission, code_name_contact) VALUES ('Hermes', 18);
INSERT INTO MissionContact (id_code_mission, code_name_contact) VALUES ('Hestia', 12);
INSERT INTO MissionContact (id_code_mission, code_name_contact) VALUES ('Poseidon', 13);
INSERT INTO MissionContact (id_code_mission, code_name_contact) VALUES ('Zeus', 14);
INSERT INTO MissionContact (id_code_mission, code_name_contact) VALUES ('Ananke', 15);
INSERT INTO MissionContact (id_code_mission, code_name_contact) VALUES ('Ananke', 19);

INSERT INTO Target (code_name_target, firstname, lastname, birthdate, nationality) VALUES (1, 'Kirstin', 'De La Coste', '1987-11-22', 'Slovenia');
INSERT INTO Target (code_name_target, firstname, lastname, birthdate, nationality) VALUES (2, 'Chrissie', 'Milbank', '2000-07-18', 'China');
INSERT INTO Target (code_name_target, firstname, lastname, birthdate, nationality) VALUES (3, 'Mead', 'Lamberth', '1981-04-19', 'Portugal');
INSERT INTO Target (code_name_target, firstname, lastname, birthdate, nationality) VALUES (4, 'Maurise', 'Kyston', '1989-10-07', 'China');
INSERT INTO Target (code_name_target, firstname, lastname, birthdate, nationality) VALUES (5, 'Rosalinde', 'Kener', '1992-06-03', 'Afghanistan');
INSERT INTO Target (code_name_target, firstname, lastname, birthdate, nationality) VALUES (6, 'Jorie', 'Lonsdale', '1988-02-21', 'Indonesia');
INSERT INTO Target (code_name_target, firstname, lastname, birthdate, nationality) VALUES (7, 'Felic', 'De Vaux', '1992-10-08', 'Libya');
INSERT INTO Target (code_name_target, firstname, lastname, birthdate, nationality) VALUES (8, 'Petey', 'Scarman', '1999-09-22', 'Indonesia');
INSERT INTO Target (code_name_target, firstname, lastname, birthdate, nationality) VALUES (9, 'Reeva', 'Winham', '1993-10-24', 'Indonesia');
INSERT INTO Target (code_name_target, firstname, lastname, birthdate, nationality) VALUES (10, 'Sarina', 'Pillifant', '1982-04-14', 'Argentina');
INSERT INTO Target (code_name_target, firstname, lastname, birthdate, nationality) VALUES (11, 'Toddy', 'Matteini', '1989-12-11', 'China');
INSERT INTO Target (code_name_target, firstname, lastname, birthdate, nationality) VALUES (12, 'Antonella', 'Pendred', '1996-02-10', 'Philippines');
INSERT INTO Target (code_name_target, firstname, lastname, birthdate, nationality) VALUES (13, 'Linnea', 'Ames', '1999-04-17', 'Indonesia');
INSERT INTO Target (code_name_target, firstname, lastname, birthdate, nationality) VALUES (14, 'Stevy', 'Dell ''Orto', '1986-04-27', 'Burundi');
INSERT INTO Target (code_name_target, firstname, lastname, birthdate, nationality) VALUES (15, 'Ennis', 'Gower', '1995-06-19', 'France');
INSERT INTO Target (code_name_target, firstname, lastname, birthdate, nationality) VALUES (16, 'Lowell', 'Youngman', '1986-06-28', 'Russia');
INSERT INTO Target (code_name_target, firstname, lastname, birthdate, nationality) VALUES (17, 'Lewes', 'Taylot', '1998-04-02', 'China');
INSERT INTO Target (code_name_target, firstname, lastname, birthdate, nationality) VALUES (18, 'Trudi', 'Burk', '1999-10-04', 'Portugal');
INSERT INTO Target (code_name_target, firstname, lastname, birthdate, nationality) VALUES (19, 'Walther', 'Fowells', '1984-10-16', 'Sweden');
INSERT INTO Target (code_name_target, firstname, lastname, birthdate, nationality) VALUES (20, 'Raviv', 'Oleszkiewicz', '2001-09-10', 'Philippines');

INSERT INTO MissionTarget (id_code_mission, code_name_target) VALUES ('Aphrodite', 1);
INSERT INTO MissionTarget (id_code_mission, code_name_target) VALUES ('Apollon', 3);
INSERT INTO MissionTarget (id_code_mission, code_name_target) VALUES ('Ares', 2);
INSERT INTO MissionTarget (id_code_mission, code_name_target) VALUES ('Artemis', 4);
INSERT INTO MissionTarget (id_code_mission, code_name_target) VALUES ('Athena', 5);
INSERT INTO MissionTarget (id_code_mission, code_name_target) VALUES ('Demeter', 6);
INSERT INTO MissionTarget (id_code_mission, code_name_target) VALUES ('Dionysos', 7);
INSERT INTO MissionTarget (id_code_mission, code_name_target) VALUES ('Dionysos', 19);
INSERT INTO MissionTarget (id_code_mission, code_name_target) VALUES ('Dionysos', 17);
INSERT INTO MissionTarget (id_code_mission, code_name_target) VALUES ('Hades', 8);
INSERT INTO MissionTarget (id_code_mission, code_name_target) VALUES ('Hades', 16);
INSERT INTO MissionTarget (id_code_mission, code_name_target) VALUES ('Hephaistos', 9);
INSERT INTO MissionTarget (id_code_mission, code_name_target) VALUES ('Hera', 10);
INSERT INTO MissionTarget (id_code_mission, code_name_target) VALUES ('Hermes', 11);
INSERT INTO MissionTarget (id_code_mission, code_name_target) VALUES ('Hestia', 12);
INSERT INTO MissionTarget (id_code_mission, code_name_target) VALUES ('Poseidon', 14);
INSERT INTO MissionTarget (id_code_mission, code_name_target) VALUES ('Zeus', 13);
INSERT INTO MissionTarget (id_code_mission, code_name_target) VALUES ('Zeus', 20);
INSERT INTO MissionTarget (id_code_mission, code_name_target) VALUES ('Ananke', 15);
INSERT INTO MissionTarget (id_code_mission, code_name_target) VALUES ('Ananke', 18);

INSERT INTO Stash (id_code_stash, address, country, type) VALUES (1, '8 Vahlen Pass', 'France', 'Maison');
INSERT INTO Stash (id_code_stash, address, country, type) VALUES (2, '36 Myrtle Park', 'Peru', 'Cave');
INSERT INTO Stash (id_code_stash, address, country, type) VALUES (3, '231 Butternut Street', 'England', 'Cave');
INSERT INTO Stash (id_code_stash, address, country, type) VALUES (4, '4 Rowland Center', 'Russia', 'Camion');
INSERT INTO Stash (id_code_stash, address, country, type) VALUES (5, '23 Amoth Point', 'China', 'Cave');
INSERT INTO Stash (id_code_stash, address, country, type) VALUES (6, '441 Bellgrove Place', 'Japan', 'Appartement');
INSERT INTO Stash (id_code_stash, address, country, type) VALUES (7, '75059 Brown Point', 'Thailand', 'Appartement');
INSERT INTO Stash (id_code_stash, address, country, type) VALUES (8, '230 Independence Place', 'Italia', 'Bureau');
INSERT INTO Stash (id_code_stash, address, country, type) VALUES (9, '809 Ohio Pass', 'Canada', 'Appartement');
INSERT INTO Stash (id_code_stash, address, country, type) VALUES (10, '97 Hollow Ridge Lane', 'Spain', 'Maison');
INSERT INTO Stash (id_code_stash, address, country, type) VALUES (11, '7058 Banding Parkway', 'India', 'Cave');
INSERT INTO Stash (id_code_stash, address, country, type) VALUES (12, '84 Service Street', 'Nepal', 'Appartement');
INSERT INTO Stash (id_code_stash, address, country, type) VALUES (13, '64265 Sommers Drive', 'France', 'Bureau');
INSERT INTO Stash (id_code_stash, address, country, type) VALUES (14, '2 Westerfield Way', 'United-States', 'Appartement');
INSERT INTO Stash (id_code_stash, address, country, type) VALUES (15, '8357 Bayside Drive', 'Brazil', 'Maison');
INSERT INTO Stash (id_code_stash, address, country, type) VALUES (16, '755 Luster Hill', 'Italia', 'Maison');
INSERT INTO Stash (id_code_stash, address, country, type) VALUES (17, '0057 Ramsey Point', 'China', 'Bureau');
INSERT INTO Stash (id_code_stash, address, country, type) VALUES (18, '3 Blue Bill Park Plaza', 'India', 'Camion');
INSERT INTO Stash (id_code_stash, address, country, type) VALUES (19, '361 Eliot Road', 'Nepal', 'Cave');
INSERT INTO Stash (id_code_stash, address, country, type) VALUES (20, '30110 Brentwood Way', 'Peru', 'Bureau');

INSERT INTO MissionStash (id_code_mission, id_code_stash) VALUES ('Aphrodite', 1);
INSERT INTO MissionStash (id_code_mission, id_code_stash) VALUES ('Apollon', 2);
INSERT INTO MissionStash (id_code_mission, id_code_stash) VALUES ('Apollon', 20);
INSERT INTO MissionStash (id_code_mission, id_code_stash) VALUES ('Ares', 3);
INSERT INTO MissionStash (id_code_mission, id_code_stash) VALUES ('Artemis', 4);
INSERT INTO MissionStash (id_code_mission, id_code_stash) VALUES ('Athena', 5);
INSERT INTO MissionStash (id_code_mission, id_code_stash) VALUES ('Athena', 17);
INSERT INTO MissionStash (id_code_mission, id_code_stash) VALUES ('Demeter', 6);
INSERT INTO MissionStash (id_code_mission, id_code_stash) VALUES ('Dionysos', 7);
INSERT INTO MissionStash (id_code_mission, id_code_stash) VALUES ('Hades', 8);
INSERT INTO MissionStash (id_code_mission, id_code_stash) VALUES ('Hades', 16);
INSERT INTO MissionStash (id_code_mission, id_code_stash) VALUES ('Hephaistos', 9);
INSERT INTO MissionStash (id_code_mission, id_code_stash) VALUES ('Hera', 10);
INSERT INTO MissionStash (id_code_mission, id_code_stash) VALUES ('Hermes', 11);
INSERT INTO MissionStash (id_code_mission, id_code_stash) VALUES ('Hermes', 18);
INSERT INTO MissionStash (id_code_mission, id_code_stash) VALUES ('Hestia', 12);
INSERT INTO MissionStash (id_code_mission, id_code_stash) VALUES ('Hestia', 19);
INSERT INTO MissionStash (id_code_mission, id_code_stash) VALUES ('Poseidon', 13);
INSERT INTO MissionStash (id_code_mission, id_code_stash) VALUES ('Poseidon', 1);
INSERT INTO MissionStash (id_code_mission, id_code_stash) VALUES ('Zeus', 14);
INSERT INTO MissionStash (id_code_mission, id_code_stash) VALUES ('Ananke', 15);

INSERT INTO Administrator (id_admin, firstname, lastname, email, password, created_at) VALUES (1, 'Mathieu', 'Bouthors', 'mathieubouthors@hotmail.com', '$2y$10$G.3vcLJlpKgXL/.ro0BvKuCR.Hcix6nAewHoaeNCPwd8ACxKcIn.2', '2022-07-15');
INSERT INTO Administrator (id_admin, firstname, lastname, email, password, created_at) VALUES (2, 'studi', 'studi', 'studi@gmail.com', '$2y$10$RpJhW99yYHXAsVLzsxooa.J8UIgQgHQmMRGy35sztlkqSpIWCo9Ha', '2022-07-16');
INSERT INTO Administrator (id_admin, firstname, lastname, email, password, created_at) VALUES (3, 'Leena', 'Aylwin', 'laylwin2@google.cn', '$2y$10$9USMqYMT9VgyBXHXn9SomesuYUqlx/jArgcy4w0om.bLbXJmA1uOG', '2022-07-17');
INSERT INTO Administrator (id_admin, firstname, lastname, email, password, created_at) VALUES (4, 'Hermione', 'Millard', 'hmillard3@psu.edu', '$2y$10$BGNk9getX/oJCUQodG/YuO84K.8URl/GCVwMPaJHrL3gRCI7HVTFW', '2022-07-18');
INSERT INTO Administrator (id_admin, firstname, lastname, email, password, created_at) VALUES (5, 'Stanislaus', 'Leaburn', 'sleaburn4@fema.gov', '$2y$10$8mFSP4NkKcyWh7A8czKEJOkYnFe.qOWRFqg//vMsC60lzh5NZv/3S', '2022-07-19');

/**********************************************************************************************/

/* Affiche toutes les missions et le détails */
SELECT title AS Mission, id_code_mission AS CodeName, country AS Pays, type AS Type, status AS Statut, start_date AS Date_de_début, end_date AS Date_de_fin FROM Mission ORDER BY;


SELECT Mission.id_code_mission, title, description, Mission.country, Mission.type, status, start_date, end_date, 
Speciality.name AS speciality, 
Agent.firstname AS firstnameAgent, Agent.lastname AS lastnameAgent,
Contact.firstname AS firstnameContact, Contact.lastname AS lastnameContact,
Target.firstname AS firstnameTarget, Target.lastname AS lastnameTarget,
Stash.type AS stashType
FROM Mission
INNER JOIN Speciality ON Mission.id_speciality = Speciality.id_speciality
INNER JOIN MissionAgent ON Mission.id_code_mission = MissionAgent.id_code_mission
INNER JOIN Agent ON MissionAgent.id_code_agent = Agent.id_code_agent
INNER JOIN MissionContact ON Mission.id_code_mission = MissionContact.id_code_mission
INNER JOIN Contact ON MissionContact.code_name_contact = Contact.code_name_contact
INNER JOIN MissionTarget ON Mission.id_code_mission = MissionTarget.id_code_mission
INNER JOIN Target ON MissionTarget.code_name_target = Target.code_name_target
INNER JOIN MissionStash ON Mission.id_code_mission = MissionStash.id_code_mission
INNER JOIN Stash ON MissionStash.id_code_stash = stash.id_code_stash
ORDER BY start_date, title;

<iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5661869.639753694!2d-2.4333266947231347!3d46.13910021019738!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd54a02933785731%3A0x6bfd3f96c747d9f7!2sFrance!5e0!3m2!1sfr!2sfr!4v1658739781428!5m2!1sfr!2sfr"
                        width="350" height="200" style="border:0;" allowfullscreen="" loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>