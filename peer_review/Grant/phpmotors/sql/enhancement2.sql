INSERT INTO clients (clientFirstname, clientLastname, clientEmail, clientPassword, clientLevel, comment) 
Values ('Tony', 'Stark', 'tony@starkent.com', 'Iam1ronM@n', 1, 'I am the real Ironman');

UPDATE clients 
SET clientLevel = 3
WHERE clientEmail = 'tony@starkent.com';

UPDATE inventory 
SET invDescription = REPLACE('small interior', 'small', 'spacious')
WHERE invModel = 'Hummer' AND invMake = 'GM';

SELECT i.invModel, c.classificationName
FROM inventory i
INNER JOIN carclassification c
ON i.classificationId = c.classificationId;

DELETE FROM inventory 
WHERE invModel = 'Wrangler' and invMake = 'Jeep';

UPDATE inventory 
SET invImage = concat('/phpmotors', invImage), invThumbnail = concat('/phpmotors', invThumbnail);