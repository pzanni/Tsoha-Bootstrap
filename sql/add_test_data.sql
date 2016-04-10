INSERT INTO Friend (name, email, password, age, location, gender, info) 
	VALUES ('Anni Puurunen', 'puurunen.anni@gmail.com', 'anni123', '19', 'Helsinki', 'Nainen',
			 'Moi olen Anni :)');

INSERT INTO Friend (name, email, password, age, location, gender, info)
	VALUES ('Megan Trainor', 'no@gmail.com', 'no123', '21', 'Vantaa', 'Nainen', '21 vuotias laulaja :)');

INSERT INTO Post (sender, postTime, title, content)
	VALUES (1, NOW(), 'Cluedo pelaajia', 'Etsin kokeneita Cluedo-pelin pelaajia  pääkaupunkiseudulta.');

INSERT INTO Message (sentTime ,title, content) 
	VALUES (1, 2, NOW(), 'Moi', 'Tässä viesti Annilta Meganille.'
			);

INSERT INTO Message (sender, receiver, sentTime ,title, content) 
	VALUES (2, 1, NOW(), 'Hei Anni', 'Tässä viesti Meganilta Annille'
			);
