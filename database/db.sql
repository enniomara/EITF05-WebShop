USE webshop;

drop table if exists users;
create table users(
    username char(120) PRIMARY KEY,
    password char(120),
    address char(220)
);

DROP TABLE IF EXISTS items;
CREATE TABLE items(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    name TEXT,
    price integer
);

drop table if exists orderItems;
create table orderItems(
    orderId INTEGER NOT NULL,
    itemId integer NOT NULL,
    amount integer,
    primary key (orderId, itemId),
    foreign key (itemId) references items(id)
);

drop table if exists orders;
create table orders(
    id integer AUTO_INCREMENT PRIMARY KEY,
    username char(120),
    time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    foreign key (username) references users(username)
);

DROP TABLE IF EXISTS blacklistedPasswords;
CREATE TABLE blacklistedPasswords(
    id integer AUTO_INCREMENT PRIMARY KEY,
    password char(120)
);

