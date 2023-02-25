create database Book_store;
use Book_store;
create table publisher
(
fname varchar(50) not null,
lname varchar(50) not null,
username varchar(50) primary key,
Email varchar(50) not null,
password varchar(150) not null,
address varchar(150) not null
);

create table pub_phone
( 
publisher_id varchar(50),
phone varchar(50),
CONSTRAINT pub_phone_FK
foreign key(publisher_id)
references publisher(username),
CONSTRAINT PK_pub_phone
primary key(publisher_id,phone)
);
create table customer
(
fname varchar(50) not null,
lname varchar(50) not null,
username varchar(50) primary key,
Email varchar(50) not null,
password varchar(150) not null,
address varchar(150) not null
);
create table cus_phone
( 
customer_id varchar(50),
phone varchar(50),
CONSTRAINT cus_phone_FK
foreign key(customer_id)
references customer(username),
CONSTRAINT PK_cus_phone
primary key(customer_id,phone)
);
create table book
(
name varchar(50) not null,
publisher_id varchar(50) not null,
price int not null,
S_number varchar(150) primary key,
quantity int not null,
category varchar(50) not null,
CONSTRAINT book_publiser_FK
foreign key(publisher_id)
references publisher(username)
);
create table card
(
card_id int primary key auto_increment,
customer_id varchar(50) not null,
foreign key(customer_id)
references customer(username)
);
create table orders
(
customer_id varchar(50),
publisher_id varchar(50),
book_id varchar(200),
quntity int not null,
primary key(customer_id,publisher_id,book_id),
foreign key(customer_id)
references customer(username),
foreign key(publisher_id)
references publisher(username)
);
create table card_items 
(
card_id int not null,
book_id varchar(150) not null,
foreign key(card_id)
references card(card_id),
foreign key (book_id)
references book(S_number)
);
select *from publisher;
SELECT username FROM publisher WHERE username =5 LIMIT 1;
alter table orders
add column book_id varchar(200);
select *from orders;
select *from book;
select *from card_items;
drop table card_items;
select*from card;
select *from publisher;
select *from customer;
alter table orders
add column statu varchar(50) ;
SELECT *from publisher inner join pub_phone on publisher.username=pub_phone.publisher_id WHERE username='admin1' ;