create table staffs_sha1
(
    id         int auto_increment,
    gender     bit default b'0' not null,
    skype      varchar(255)     null,
    is_online  bit default b'0' not null,
    is_admin   bit default b'0' not null,
    password   varchar(255)     not null,
    post       int              not null,
    lastname   varchar(255)     null,
    firstname  varchar(255)     null,
    middlename varchar(255)     null,
    dob        date             null,
    photo      text             null,
    constraint id
        unique (id),
    constraint staff_id
        unique (id)
);

INSERT INTO staff.staffs_sha1 (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (1, true, 'Ivanov', false, false, '7c222fb2927d828af22f592134e8932480637c0d', 1, 'Babalaeva', 'Irina', 'Pavlova', '1988-12-01', 'http://server.local/media/onePhoto.jpg');
INSERT INTO staff.staffs_sha1 (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (2, false, 'IRINA', true, false, '4e17a448e043206801b95de317e07c839770c8b8', 2, 'On', 'Hero', 'Heroin', '2002-03-01', 'http://server.local/media/twoPhoto.jpg');
INSERT INTO staff.staffs_sha1 (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (3, true, 'Kuka', true, true, 'dfbc7f52e554504a0ef1651b0e9161d258f6def7', 3, 'Kurochkina', 'Karina', 'Heroin', '2002-03-01', 'http://server.local/media/threePhoto.jpg');
INSERT INTO staff.staffs_sha1 (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (4, true, 'GigaCHad228', false, false, '6fe1cfdff1368e40ca2d19b36762b4c67768d1aa', 4, 'Rubtsov', 'Vladislave', 'Andreevich', '2004-08-02', 'http://server.local/media/fourPhoto.jpg');
INSERT INTO staff.staffs_sha1 (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (5, true, 'Lexa2009', false, false, 'cc9441b7784cd7a1c63b9bc88a43d054f4d6294c', 5, 'Zubenko', 'Aleksey', 'Artemovich', '2001-05-25', 'http://server.local/media/fivePhoto.jpg');
INSERT INTO staff.staffs_sha1 (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (6, false, 'ZhmishenkoMihuil1998', true, false, 'e744ad02d21b9ffa7f41eb7ddba21e773ec0112e', 6, 'Litvina', 'Olga', 'Nikolaevna', '1995-04-14', 'http://server.local/media/sixPhoto.jpg');
INSERT INTO staff.staffs_sha1 (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (7, true, 'Procser2005', false, true, 'f9adef3be3648c279dbc82ece2a7bb76edb638c2', 3, 'Abrikosov', 'Evgeniy', 'Rubenovich', '1988-12-30', 'http://server.local/media/sevenPhoto.jpg');
INSERT INTO staff.staffs_sha1 (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (8, false, 'ZhestkieNogty', true, true, 'a1d37b273b17d0f797565c68a15fa03abd6d6bf1', 3, 'Dudina', 'Natalia', 'Vladimirovna', '2008-02-03', 'http://server.local/media/eightPhoto.jpg');
INSERT INTO staff.staffs_sha1 (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (9, false, 'maximka', false, false, '7c222fb2927d828af22f592134e8932480637c0d', 2, 'Pro', 'Maxim', 'Ivanovich', '2002-03-04', 'http://server.local/media/ninePhoto.jpg');