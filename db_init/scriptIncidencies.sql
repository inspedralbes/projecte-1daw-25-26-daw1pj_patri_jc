-- Codificació --
SET NAMES utf8mb4;

-- Crear Database --

CREATE DATABASE IF NOT EXISTS incidenciesDB
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

-- Donar Permisos --
GRANT ALL PRIVILEGES ON incidenciesDB.* TO 'usuari'@'%';
FLUSH PRIVILEGES;

-- Utilitzar la DB --
USE incidenciesDB;

-- Esborrem si les taules existeixen --
DROP TABLE IF EXISTS INCIDENCIA;
DROP TABLE IF EXISTS ACTUACIO;
DROP TABLE IF EXISTS DEPARTAMENT;
DROP TABLE IF EXISTS TECNIC;
DROP TABLE IF EXISTS TIPUS;

-- Creem les taules de nou --


CREATE TABLE DEPARTAMENT(
    ID_DEPT INT PRIMARY KEY AUTO_INCREMENT,
    NOM_DEPT VARCHAR(255) NOT NULL
);


CREATE TABLE TECNIC(
    ID_TECNIC INT PRIMARY KEY AUTO_INCREMENT,
    NOM_TECNIC VARCHAR(255) NOT NULL
);


CREATE TABLE TIPUS(
    ID_TIPUS INT PRIMARY KEY AUTO_INCREMENT,
    NOM_TIPUS VARCHAR(250) NOT NULL
);


CREATE TABLE ACTUACIO(
    ID_ACTUACIO INT PRIMARY KEY AUTO_INCREMENT,
    DATA_ACTUACIO TIMESTAMP NOT NULL,
    DESC_ACTUACIO VARCHAR(500),
    TEMPS TIME,
    ES_VISIBLE BOOLEAN NOT NULL,
    ID_INCIDENCIA INT NOT NULL
);


CREATE TABLE INCIDENCIA(
    ID_INCIDENCIA INT PRIMARY KEY AUTO_INCREMENT,
    PRIORITAT ENUM('Alt', 'Mitjana', 'Baixa'),
    DATA_INICI DATE NOT NULL,
    DATA_FI TIMESTAMP,
    DESC_INCIDENCIA VARCHAR(255) NOT NULL,
    ID_DEPT INT NOT NULL,
    ID_TIPUS INT NOT NULL,
    ID_TECNIC INT NULL
);


--Afegim les dades 
INSERT INTO DEPARTAMENT (NOM_DEPT) VALUES 
    ('Llengua Anglesa'),
    ('Llengua Catalana'),
    ('Història'),
    ('Biologia'),
    ('Matemàtiques'),
    ('Informàtica'),
    ('Administració'),
    ('Direcció'),
    ('Altres');

INSERT INTO TIPUS (NOM_TIPUS) VALUES
    ('Hardware'),
    ('Software'),
    ('Xarxa'),
    ('Perifèrics'),
    ('Altres');

    INSERT INTO TECNIC (NOM_TECNIC) VALUES 
    ('Ermengol'),
    ('Àlvaro'),
    ('Gerard');

CREATE OR REPLACE VIEW vista_informe_tecnics AS
SELECT
    t.ID_TECNIC,
    t.NOM_TECNIC AS nomTecnic,
    i.PRIORITAT,
    i.ID_INCIDENCIA,
    i.DESC_INCIDENCIA AS descripcioIncidencia,
    i.DATA_INICI AS dataInici,
    IFNULL(TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(a.TEMPS))), '%H:%i'), '00:00') AS tempsTotalDedicat
FROM TECNIC t
INNER JOIN INCIDENCIA i
    ON t.ID_TECNIC = i.ID_TECNIC
LEFT JOIN ACTUACIO a
    ON i.ID_INCIDENCIA = a.ID_INCIDENCIA
WHERE i.DATA_FI IS NULL
GROUP BY
    t.ID_TECNIC,
    t.NOM_TECNIC,
    i.PRIORITAT,
    i.ID_INCIDENCIA,
    i.DESC_INCIDENCIA,
    i.DATA_INICI;


CREATE OR REPLACE VIEW vista_consum_departaments AS
SELECT
    d.ID_DEPT,
    d.NOM_DEPT AS nomDepartament,
    COUNT(i.ID_INCIDENCIA) AS nombreIncidencies,
    IFNULL(TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(temps_per_incidencia.tempsTotal))), '%H:%i'), '00:00') AS tempsTotalDedicat
FROM DEPARTAMENT d
LEFT JOIN INCIDENCIA i
    ON d.ID_DEPT = i.ID_DEPT
LEFT JOIN (
    SELECT
        ID_INCIDENCIA,
        SEC_TO_TIME(SUM(TIME_TO_SEC(temps))) AS tempsTotal
    FROM ACTUACIO
    GROUP BY ID_INCIDENCIA
) AS temps_per_incidencia
    ON i.ID_INCIDENCIA = temps_per_incidencia.ID_INCIDENCIA
GROUP BY
    d.ID_DEPT,
    d.NOM_DEPT;































