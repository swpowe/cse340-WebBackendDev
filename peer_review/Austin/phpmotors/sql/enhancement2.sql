
/* Insert Tony Stark */
INSERT INTO clients (
    `clientFirstName`,
    `clientLastName`,
    `clientEmail`,
    `clientPassword`,
    `clientLevel`,
    `comment`
    )
VALUES (
    'Tony',
    'Stark',
    'tony@starkent.com',
    'Iam1ronM@n',
     1,
    'I am the real Ironman'
    );

/* Update Tony's Level to 3 */
UPDATE clients
SET clientLevel = 3
WHERE clientFirstName = 'Tony';

/* Update the Hummer's Description to read spacious rather than small */
UPDATE inventory
SET invDescription = replace(invDescription, 'small', 'spacious')
WHERE invId = 12;

/* Use InnerJoin to view all SUV vehicles in your inventory */
SELECT inventory.invModel, carclassification.classificationName
FROM inventory
INNER JOIN carclassification ON inventory.classificationId=carclassification.classificationId
WHERE inventory.classificationId = 1;

/* Delete the Wrangler from Inventory */
DELETE FROM inventory
WHERE invId = 1;

/* Update image + thumbnail filepaths in inventory table with Concatenate */
UPDATE inventory
SET invImage=concat('/phpmotors', invImage),
invThumbnail=concat('/phpmotors', invThumbnail);