-- Script de création de la base de données SORTIES
--   type :      SQL Server 2012
-- 
DROP TABLE IF EXISTS `VILLES`;
DROP TABLE IF EXISTS `SORTIES`;
DROP TABLE IF EXISTS `SITES`;
DROP TABLE IF EXISTS `PARTICIPANTS`;
DROP TABLE IF EXISTS `LIEUX`;
DROP TABLE IF EXISTS `INSCRIPTIONS`;
DROP TABLE IF EXISTS `ETATS`;

CREATE TABLE ETATS (
    no_etat   INTEGER NOT NULL,
    libelle   VARCHAR(30) NOT NULL
);

ALTER TABLE ETATS ADD constraint etats_pk PRIMARY KEY (no_etat);


CREATE TABLE INSCRIPTIONS (
    date_inscription              datetime NOT NULL,
    sorties_no_sortie             INTEGER NOT NULL,
    participants_no_participant   INTEGER NOT NULL
);

ALTER TABLE INSCRIPTIONS ADD constraint inscriptions_pk PRIMARY KEY  (SORTIES_no_sortie, PARTICIPANTS_no_participant);


CREATE TABLE LIEUX (
    no_lieu         INTEGER NOT NULL,
    nom_lieu        VARCHAR(30) NOT NULL,
    rue             VARCHAR(30),
    latitude           DOUBLE,
    longitude          DOUBLE,
    villes_no_ville   INTEGER NOT NULL
);

ALTER TABLE LIEUX ADD constraint lieux_pk PRIMARY KEY  (no_lieu);


CREATE TABLE PARTICIPANTS (
    no_participant   INTEGER NOT NULL,
	pseudo           VARCHAR(30) NOT NULL,
    nom              VARCHAR(30) NOT NULL,
    prenom           VARCHAR(30) NOT NULL,
    telephone        VARCHAR(15),
    mail             VARCHAR(20) NOT NULL,
	mot_de_passe	 VARCHAR(20) NOT NULL,
    administrateur   tinyint NOT NULL,
    actif            tinyint NOT NULL,
	sites_no_site    INTEGER NOT NULL
);

ALTER TABLE PARTICIPANTS ADD constraint participants_pk PRIMARY KEY  (no_participant);

ALTER TABLE PARTICIPANTS add constraint participants_pseudo_uk unique (pseudo);

CREATE TABLE SITES (
    no_site       INTEGER NOT NULL,
    nom_site      VARCHAR(30) NOT NULL
);

ALTER TABLE SITES ADD constraint sites_pk PRIMARY KEY (no_site);

CREATE TABLE SORTIES (
    no_sortie                     INTEGER NOT NULL,
    nom                           VARCHAR(30) NOT NULL,
    datedebut                     datetime NOT NULL,
    duree                         INTEGER,
    datecloture                   datetime NOT NULL,
    nbinscriptionsmax             INTEGER NOT NULL,
    descriptioninfos              VARCHAR(500),
	urlPhoto                      VARCHAR(250),
    organisateur                  INTEGER NOT NULL,
    lieux_no_lieu                 INTEGER NOT NULL,
    etats_no_etat                 INTEGER NOT NULL
);

ALTER TABLE SORTIES ADD constraint sorties_pk PRIMARY KEY  (no_sortie);

CREATE TABLE VILLES (
    no_ville      INTEGER NOT NULL,
    nom_ville     VARCHAR(30) NOT NULL,
    code_postal   VARCHAR(10) NOT NULL
);

ALTER TABLE VILLES ADD constraint villes_pk PRIMARY KEY  (no_ville);

ALTER TABLE INSCRIPTIONS
    ADD CONSTRAINT inscriptions_participants_fk FOREIGN KEY ( participants_no_participant )
        REFERENCES participants ( no_participant )
ON DELETE NO ACTION 
    ON UPDATE no action ;

ALTER TABLE INSCRIPTIONS
    ADD CONSTRAINT inscriptions_sorties_fk FOREIGN KEY ( sorties_no_sortie )
        REFERENCES sorties ( no_sortie )
ON DELETE NO ACTION 
    ON UPDATE no action ;


ALTER TABLE LIEUX
    ADD CONSTRAINT lieux_villes_fk FOREIGN KEY ( villes_no_ville )
        REFERENCES villes ( no_ville )
ON DELETE NO ACTION 
    ON UPDATE no action ;
	
ALTER TABLE SORTIES
    ADD CONSTRAINT sorties_etats_fk FOREIGN KEY ( etats_no_etat )
        REFERENCES etats ( no_etat )
ON DELETE NO ACTION 
    ON UPDATE no action ;

ALTER TABLE SORTIES
    ADD CONSTRAINT sorties_lieux_fk FOREIGN KEY ( lieux_no_lieu )
        REFERENCES lieux ( no_lieu )
ON DELETE NO ACTION 
    ON UPDATE no action ;

ALTER TABLE SORTIES
    ADD CONSTRAINT sorties_participants_fk FOREIGN KEY ( organisateur )
        REFERENCES participants ( no_participant )
ON DELETE NO ACTION 
    ON UPDATE no action ;