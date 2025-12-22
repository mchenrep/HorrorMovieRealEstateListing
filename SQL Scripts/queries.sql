-- queries.sql
USE listings;

-- 1) Find the addresses of all houses currently listed
SELECT p.address
FROM Property p
JOIN House h ON p.address = h.address
JOIN Listings l ON p.address = l.address;

-- 2) Find the addresses and MLS numbers of all houses currently listed
SELECT p.address, l.mlsNumber
FROM Property p
JOIN House h ON p.address = h.address
JOIN Listings l ON p.address = l.address;

-- 3) Find the addresses of all 3-bedroom, 2-bathroom houses currently listed
SELECT p.address
FROM Property p
JOIN House h ON p.address = h.address
JOIN Listings l ON p.address = l.address
WHERE h.bedrooms = 3 AND h.bathrooms = 2;

-- 4) Find the addresses and prices of all 3-bedroom, 2-bathroom houses 
--    with prices in $100,000 to $250,000, descending by price
SELECT p.address, p.price
FROM Property p
JOIN House h ON p.address = h.address
JOIN Listings l ON p.address = l.address
WHERE h.bedrooms = 3 
  AND h.bathrooms = 2
  AND p.price BETWEEN 100000 AND 250000
ORDER BY p.price DESC;

-- 5) Find the addresses and prices of all business properties advertised as office space
--    in descending order of price
SELECT p.address, p.price
FROM Property p
JOIN BusinessProperty b ON p.address = b.address
JOIN Listings l ON p.address = l.address
WHERE b.type = 'Office Space'
ORDER BY p.price DESC;

-- 6) Find all agents' ids, names, phones, firm names, and start dates
SELECT a.agentId, a.name, a.phone, f.name AS firmName, a.dateStarted
FROM Agent a
JOIN Firm f ON a.firmId = f.id;

-- 7) Find all properties currently listed by agent with id '1' (can change)
SELECT p.address, p.ownerName, p.price, l.mlsNumber, l.dateListed
FROM Property p
JOIN Listings l ON p.address = l.address
WHERE l.agentId = 1;

-- 8) Find all Agent.name - Buyer.name pairs, sorted alphabetically by Agent.name
SELECT a.name AS agentName, b.name AS buyerName
FROM Works_With w
JOIN Agent a ON w.agentId = a.agentId
JOIN Buyer b ON w.buyerId = b.id
ORDER BY a.name, b.name;

-- 9) For each agent, find total number of buyers currently working with that agent
SELECT a.agentId, COUNT(w.buyerId) AS buyerCount
FROM Agent a
LEFT JOIN Works_With w ON a.agentId = w.agentId
GROUP BY a.agentId;

-- 10) For a specific buyer (e.g., id = '1'), find all houses meeting preferences, descending by price
SELECT p.address, p.price, h.bedrooms, h.bathrooms, h.size
FROM Buyer b
JOIN House h ON b.bedrooms = h.bedrooms AND b.bathrooms = h.bathrooms
JOIN Property p ON h.address = p.address
JOIN Listings l ON p.address = l.address
WHERE b.id = 1
ORDER BY p.price DESC;
