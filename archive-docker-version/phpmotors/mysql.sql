-- select * from inventory
-- where (invMake LIKE '%GM%') OR (invModel LIKE '%GM%')

-- Item #1
INSERT INTO clients(clientFirstname, clientLastname, clientEmail, clientPassword, comment)
VALUES ('Tony', 'Stark', 'tony@starkent.com', 'Iam1ronM@n', 'I am the real Ironman');

-- Item #2
UPDATE clients
SET clientLevel = '3'
WHERE (clientFirstname = 'Tony');

-- Item #3
UPDATE inventory
SET invDescription = replace(invDescription, 'small interiors', 'spacious interior')
WHERE (invMake = 'GM') AND (invModel = 'Hummer');

-- Item #4
SELECT inv.invModel, car.classificationName
FROM inventory AS inv
INNER JOIN carclassification AS car
    ON inv.classificationId = car.classificationId
WHERE (car.classificationName = 'SUV');

-- Item #5
DELETE FROM inventory
WHERE (invMake = 'Jeep') AND (invModel = 'Wrangler');

-- Item #6
UPDATE inventory
SET invImage = CONCAT('/phpmotors', invImage), invThumbnail = CONCAT('/phpmotors', invThumbnail);




