CREATE TABLE Utente (
  Nome varchar(100),
  Cognome varchar(100),
  id_device varchar(100),
  n_matricola varchar(100),
  password varchar(100),
  PRIMARY KEY (n_matricola)
);

CREATE TABLE Classe (
  Codice varchar(100),
  id_studente varchar(100),
  PRIMARY KEY (Codice,id_studente),
  CONSTRAINT `student_class`
	FOREIGN KEY (id_studente) REFERENCES Utente(n_matricola)
);

CREATE TABLE Insegnante (
  id_professore varchar(100),
  Materia varchar(100),
  Classe varchar(100),
  PRIMARY KEY (id_professore,Classe),
  CONSTRAINT `prof_class`
	FOREIGN KEY (id_professore) REFERENCES Utente(n_matricola)
);

CREATE TABLE Lezione (
  Data_ora datetime,
  id_professore varchar(100),
  Materia varchar(100),
  Argomento varchar(100),
  Ore_effettuate int(11),
  Alunni_presenti varchar(500) DEFAULT NULL,
  PRIMARY KEY (Data_ora),
  CONSTRAINT `lesson_class`
	FOREIGN KEY (id_professore) REFERENCES Utente(n_matricola)
);

INSERT INTO `Classe` (`Codice`, `id_studente`) VALUES
('5°Bi', 'bel00000'),
('5°Bi', 'bel12345'),
('5°Bi', 'bel24697'),
('5°Di', 'bel010101');

INSERT INTO `Insegnante` (`id_professore`, `Materia`, `Classe`) VALUES
('filippocuti', 'Sistemi e reti', '5°Bi'),
('filippocuti', 'Sistemi e reti', '5°Di'),
('salvatoremartello', 'TPS', '3°Ai'),
('salvatoremartello', 'Informatica', '5°Bi');

INSERT INTO `Lezione` (`Data_ora`, `id_professore`, `Materia`, `Argomento`, `Ore_effettuate`, `Alunni_presenti`, `Classe`) VALUES
('2020-05-20 10:00:00', 'filippocuti', 'Sistemi e reti', 'DNS', 1, 'bel24697,bel12345', '5°Bi'),
('2020-05-27 10:00:00', 'filippocuti', 'Sistemi e reti', 'DHCP', 2, 'bel00000,bel12345', '5°Bi'),
('2020-06-18 08:00:00', 'salvatoremartello', 'Informatica', 'PHP+MySql: l\'oggetto PDO', 2, NULL, '5°Bi');

INSERT INTO `Utente` (`Nome`, `Cognome`, `id_device`, `n_matricola`, `password`) VALUES
('Manuel', 'Arto', 'e:f:g:h', 'bel00000', 'ciao1234'),
('Edoardo', 'Carrà', 'k:n:g:l', 'bel010101', 'pollo'),
('Martino', 'Delbianco', 'a:b:c:d', 'bel12345', 'ciao1234'),
('Gabriele', 'Genovese', 'a:b:c:d', 'bel24697', 'ciao1234'),
('Filippo', 'Cuti', 'a:r:g:h', 'filippocuti', 'ciao1243'),
('Salvatore', ' Martello', '0:0:0:1', 'salvatoremartello', '1234ciao');
