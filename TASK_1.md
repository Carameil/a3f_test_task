# Создание таблиц
CREATE TABLE ttask.contacts(
id INT PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(50) NOT NULL,
phone VARCHAR(12) UNIQUE
);

CREATE TABLE ttask.friends (
id INT PRIMARY KEY AUTO_INCREMENT,
contact_1 INT,
contact_2 INT,
CONSTRAINT contact1_fk FOREIGN KEY (contact_1)
REFERENCES ttask.contacts(id),
CONSTRAINT contact2_fk FOREIGN KEY (contact_2)
REFERENCES ttask.contacts(id)
);
# Запрос №1
SELECT name,phone FROM ttask.contacts
WHERE id IN (SELECT contact_1 FROM friends
GROUP BY contact_1
HAVING COUNT(contact_1)>=5);
# Запрос №2
SELECT DISTINCT ct1.name as name_c1,'friend with',ct2.name as name_c2 FROM friends
INNER JOIN contacts ct1 ON ct1.id = friends.contact_1
INNER JOIN contacts ct2 ON ct2.id = friends.contact_2
INNER JOIN friends fr ON friends.contact_1 = fr.contact_2 AND friends.contact_2 = fr.contact_1
WHERE (friends.contact_1 < friends.contact_2);