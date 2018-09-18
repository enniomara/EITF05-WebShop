USE webshop;

INSERT INTO users(username, password, address) VALUES
("test", "password", "Helsingborg");

insert into items(id, name, price) values
(1, "Bil", 200),
(2, "Motorcykel", 100);

insert into orders(id, username) values 
(1, "test");

insert into orderItems(orderId, itemId, amount) values 
(1, 1, 2),
(1, 2, 1);
