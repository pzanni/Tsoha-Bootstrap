INSERT INTO Friend (name, email, password, age, location, gender, info) 
	VALUES ('Anni Puurunen', 'puurunen.anni@gmail.com', 'anni123', '19', 'Helsinki', 'Nainen',
			 'Moi olen Anni :)');

INSERT INTO Friend (name, email, password, age, location, gender, info)
	VALUES ('Megan Trainor', 'no@gmail.com', 'no123', '21', 'Vantaa', 'Nainen', 'Olen kaikki siitä bassosta');

INSERT INTO Post (postTime, title, content)
	VALUES (NOW(), 'Cluedo pelaajia', 'Etsin kokeneita Cluedo-pelin pelaajia  pääkaupunkiseudulta.');

INSERT INTO Message (content) 
	VALUES ('Tallenna seuraavaksi molemmat tiedostot ja siirrä ne tuttuun tapaan palvelimelle. 
			Suorita sen jälkeen terminaalissa projektisi juuressa komento bash create_tables.sh, 
			joka ajaa ensin drop_tables.sql- ja sen jälkeen create_tables.sql-tiedoston tietokantaasi. 
			Jos syntaksissasi oli virheitä, korjaa virheet ja aja bash create_tables.sh uudestaan.'
			);
