DROP DATABASE IF EXISTS listings;
CREATE DATABASE listings;
USE listings;

CREATE TABLE Property (
    address VARCHAR(50) PRIMARY KEY,
    ownerName VARCHAR(30),
    price INTEGER
);

--------- PROPERTY DATA ---------
INSERT INTO Property (address, ownerName, price) VALUES
('3871 Tomales Petaluma Rd., Tomales, CA', 'Stu Macher', 250000), -- Scream 1
('1428 Elm St., Springwood, OH', 'Nancy Thompson', 210000), -- A Nightmare on Elm St.
('709 Meridian Ave., Haddonfield, IL', 'Michael Myers', 200000), -- Myers Residence, Halloween
('1675 Ridgeway St., Harrisville, RI', 'Lorretta Warren', 350000), -- The Conjuring
('3600 Prospect St., Georgetown, Washington, D.C.', 'Regan MacNeil', 400000), -- The Exorcist
('333 Estes Drive, Estes Park, CO', 'Stanley Family', 450000),          -- The Stanley Hotel
('Camp Crystal Lake, NJ', 'Mrs. Voorhees', 200000),                     -- Friday the 13th camp
('Broadway Toy Store, Chicago, IL', 'Karen Barclay', 180000),           -- Toy store from Child’s Play
('Wall Street Office, NYC, NY', 'Patrick Bateman', 550000),             -- Office from American Psycho
('Burkittsville Woods, MD', 'Blair Witch', 150000);                     -- Woods from Blair Witch Project

CREATE TABLE House (
    address VARCHAR(50) PRIMARY KEY,
    bedrooms INTEGER,
    bathrooms INTEGER,
    size INTEGER,
    FOREIGN KEY (address) REFERENCES Property(address)
);

--------- HOUSE DATA ---------
INSERT INTO House (address, bedrooms, bathrooms, size) VALUES
('3871 Tomales Petaluma Rd., Tomales, CA', 4, 2, 2200),
('1428 Elm St., Springwood, OH', 3, 2, 1800),
('709 Meridian Ave., Haddonfield, IL', 5, 3, 3000),
('1675 Ridgeway St., Harrisville, RI', 4, 2, 2800),
('3600 Prospect St., Georgetown, Washington, D.C.', 6, 3, 3500);

CREATE TABLE BusinessProperty (
    address VARCHAR(50) PRIMARY KEY,
    type CHAR(20),
    size INTEGER,
    FOREIGN KEY (address) REFERENCES Property(address)
);

--------- BUSINESS PROPERTY DATA ---------
INSERT INTO BusinessProperty (address, type, size) VALUES
('333 Estes Drive, Estes Park, CO', 'Hotel', 25000),        -- The Stanley Hotel
('Camp Crystal Lake, NJ', 'Camp', 15000),                   -- Friday the 13th
('Broadway Toy Store, Chicago, IL', 'Toy Store', 5000),     -- Chucky store
('Wall Street Office, NYC, NY', 'Office Space', 8000),            -- American Psycho
('Burkittsville Woods, MD', 'Woods', 20000);               -- Blair Witch Project

CREATE TABLE Firm (
    id INTEGER PRIMARY KEY,
    name VARCHAR(30),
    address VARCHAR(50)
);

--------- FIRM DATA ---------
INSERT INTO Firm (id, name, address) VALUES
(1, 'Haddonfield Realty', '13 Elm Street, Haddonfield, IL'),        -- Laurie Strode
(2, 'Springwood Homes', '1428 Elm St., Springwood, OH'),             -- Nancy Thompson
(3, 'Woodsboro Estates', '10 Elm Street, Woodsboro, CA'),            -- Sidney Prescott
(4, 'Nostromo Realty', 'LV-426 Industrial Complex'),                 -- Ellen Ripley
(5, 'Crystal Lake Realty', 'Camp Crystal Lake, NJ');                 -- Alice Hardy

CREATE TABLE Agent (
    agentId INTEGER PRIMARY KEY,
    name VARCHAR(30),
    phone CHAR(12),
    firmId INTEGER,
    dateStarted DATE,
    FOREIGN KEY (firmId) REFERENCES Firm(id)
);

--------- AGENT DATA ---------
INSERT INTO Agent (agentId, name, phone, firmId, dateStarted) VALUES
(1, 'Laurie Strode', '555-1010', 1, '2020-01-01'),      -- Halloween
(2, 'Nancy Thompson', '555-2020', 2, '2019-03-15'),     -- A Nightmare on Elm St.
(3, 'Sidney Prescott', '555-3030', 3, '2021-06-10'),    -- Scream
(4, 'Ellen Ripley', '555-4040', 4, '2022-02-20'),       -- Alien
(5, 'Alice Hardy', '555-5050', 5, '2018-11-05');        -- Friday the 13th

CREATE TABLE Listings (
    mlsNumber INTEGER PRIMARY KEY,
    address VARCHAR(50),
    agentId INTEGER,
    dateListed DATE,
    FOREIGN KEY (address) REFERENCES Property(address),
    FOREIGN KEY (agentId) REFERENCES Agent(agentId)
);

--------- LISTINGS DATA ---------
INSERT INTO Listings (mlsNumber, address, agentId, dateListed) VALUES
-- Houses
(1001, '3871 Tomales Petaluma Rd., Tomales, CA', 1, '2023-01-01'),
(1002, '1428 Elm St., Springwood, OH', 2, '2023-02-01'),
(1003, '709 Meridian Ave., Haddonfield, IL', 3, '2023-03-01'),
(1004, '1675 Ridgeway St., Harrisville, RI', 4, '2023-04-01'),
(1005, '3600 Prospect St., Georgetown, Washington, D.C.', 5, '2023-05-01'),
-- Business Properties
(1006, '333 Estes Drive, Estes Park, CO', 1, '2023-06-01'),
(1007, 'Camp Crystal Lake, NJ', 5, '2023-07-01'),
(1008, 'Broadway Toy Store, Chicago, IL', 3, '2023-08-01'),
(1009, 'Wall Street Office, NYC, NY', 4, '2023-09-01'),
(1010, 'Burkittsville Woods, MD', 2, '2023-10-01');


CREATE TABLE Buyer (
    id INTEGER PRIMARY KEY,
    name VARCHAR(30),
    phone CHAR(12),
    propertyType CHAR(20),
    bedrooms INTEGER,
    bathrooms INTEGER,
    businessPropertyType CHAR(20),
    minimumPreferredPrice INTEGER,
    maximumPreferredPrice INTEGER
);

--------- BUYER DATA ---------
INSERT INTO Buyer (id, name, phone, propertyType, bedrooms, bathrooms, businessPropertyType, minimumPreferredPrice, maximumPreferredPrice) VALUES
(1, 'Ghostface', '555-1111', 'House', 3, 2, 'House', 200000, 400000),           -- Scream 1
(2, 'Freddy Krueger', '555-2222', 'House', 3, 2, 'House', 250000, 500000),      -- Elm St.
(3, 'Michael Myers', '555-3333', 'House', 5, 3, 'House', 150000, 350000),       -- Myers residence
(4, 'Annabelle', '555-4444', 'House', 2, 1, 'House', 180000, 300000),           -- The Conjuring house
(5, 'Pazuzu', '555-5555', 'House', 6, 3, 'House', 300000, 600000),              -- The Exorcist house
(6, 'Jigsaw', '555-6666', 'Business Property', NULL, NULL, 'Hotel', 400000, 600000),        -- The Stanley Hotel
(7, 'Jason Voorhees', '555-7777', 'Business Property', NULL, NULL, 'Camp', 150000, 300000),   -- Camp Crystal Lake
(8, 'Chucky', '555-8888', 'Business Property', NULL, NULL, 'Toy Store', 100000, 250000),     -- Chucky toy store
(9, 'Patrick Bateman', '555-9999', 'Business Property', NULL, NULL, 'Office', 300000, 500000),-- American Psycho office
(10, 'Blair Witch', '555-1010', 'Business Property', NULL, NULL, 'Woods', 150000, 350000);   -- Blair Witch woods

CREATE TABLE Works_With (
    buyerId INTEGER,
    agentId INTEGER,
    PRIMARY KEY (buyerId, agentId),
    FOREIGN KEY (buyerId) REFERENCES Buyer(id),
    FOREIGN KEY (agentId) REFERENCES Agent(agentId)
);

--------- WORKS WITH DATA ---------
INSERT INTO Works_With (buyerId, agentId) VALUES
-- House buyers
(1, 3),   -- Ghostface works with Sidney Prescott
(2, 2),   -- Freddy Krueger works with Nancy Thompson
(3, 1),   -- Michael Myers works with Laurie Strode
(4, 4),   -- Annabelle works with Ellen Ripley
(5, 5),   -- Pazuzu works with Alice Hardy
-- BusinessProperty buyers
(6, 1),   -- Jigsaw works with Laurie Strode
(7, 5),   -- Jason Voorhees works with Alice Hardy
(8, 3),   -- Chucky works with Sidney Prescott
(9, 4),   -- Patrick Bateman works with Ellen Ripley
(10, 2);  -- Blair Witch works with Nancy Thompson




