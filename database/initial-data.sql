USE webshop;

INSERT INTO users(username, password, address) VALUES
("test", "$2y$10$5vl3FfT/p/0ke1fPvUURA.TdiDH9SxAIsUxXG2yf1.r0CvTNivQAu", "Helsingborg");
-- Note the password for the test user is 'Password1!'

insert into items(id, name, price) values
(1, "Bil", 200),
(2, "Motorcykel", 100),
(3, "Hus", 200),
(4, "Cykel", 100);

insert into orders(id, username) values
(1, "test");

insert into orderItems(orderId, itemId, amount) values
(1, 1, 2),
(1, 2, 1);

INSERT INTO blacklistedPasswords(password) VALUES
("123456Ab?"),
("ABCDEf12?"),
("QWERTy12!"),
('111111Aa?');
