CREATE TABLE Utente (
  Nome varchar(100),
  Cognome varchar(100),
  id_device varchar(100),
  n_matricola varchar(100),
  password varchar(200),
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
  Argomento varchar(200),
  Ore_effettuate int(11),
  Alunni_presenti varchar(500) DEFAULT NULL,
  Classe varchar(100),
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
('2020-06-09 10:00:00', 'salvatoremartello', 'Informatica', 'Javascript: la tecnica AJAX', 1, 'bel24697,bel12345', '5°Bi'),
('2020-06-12 10:00:00', 'salvatoremartello', 'Informatica', 'PHP: gli oggetti', 1, NULL, '5°Bi'),
('2020-06-18 08:00:00', 'salvatoremartello', 'Informatica', 'PHPl: l\'oggetto PDO', 2, NULL, '5°Bi');

INSERT INTO `Utente` (`Nome`, `Cognome`, `id_device`, `n_matricola`, `password`) VALUES
('Manuel', 'Arto', 'e:f:g:h', 'bel00000', 'E9C8F56198841AB255C2D08E5D481FDE92C911CCC7DC3B132F49315C4771E82A9B393C2AADD785C9EF79564317667983CD5FA07E9CA79FD5D515ABAE98DDAB7F'),
('Edoardo', 'Carrà', 'k:n:g:l', 'bel010101', 'E9C8F56198841AB255C2D08E5D481FDE92C911CCC7DC3B132F49315C4771E82A9B393C2AADD785C9EF79564317667983CD5FA07E9CA79FD5D515ABAE98DDAB7F'),
('Martino', 'Delbianco', 'a:b:c:d', 'bel12345', 'E9C8F56198841AB255C2D08E5D481FDE92C911CCC7DC3B132F49315C4771E82A9B393C2AADD785C9EF79564317667983CD5FA07E9CA79FD5D515ABAE98DDAB7F'),
('Gabriele', 'Genovese', 'a:b:c:d', 'bel24697', 'E9C8F56198841AB255C2D08E5D481FDE92C911CCC7DC3B132F49315C4771E82A9B393C2AADD785C9EF79564317667983CD5FA07E9CA79FD5D515ABAE98DDAB7F'),
('Filippo', 'Cuti', 'a:r:g:h', 'filippocuti', 'E9C8F56198841AB255C2D08E5D481FDE92C911CCC7DC3B132F49315C4771E82A9B393C2AADD785C9EF79564317667983CD5FA07E9CA79FD5D515ABAE98DDAB7F'),
('Salvatore', ' Martello', '0:0:0:1', 'salvatoremartello', 'E9C8F56198841AB255C2D08E5D481FDE92C911CCC7DC3B132F49315C4771E82A9B393C2AADD785C9EF79564317667983CD5FA07E9CA79FD5D515ABAE98DDAB7F');
