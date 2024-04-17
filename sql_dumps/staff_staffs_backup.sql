create table staffs_backup
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

create fulltext index f_backup
    on staffs_backup (firstname);

create fulltext index l_backup
    on staffs_backup (lastname);

create fulltext index lfm_backup
    on staffs_backup (lastname, firstname, middlename);

create fulltext index m_backup
    on staffs_backup (middlename);

alter table staffs_backup
    add primary key (id);

INSERT INTO staff.staffs_backup (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (1, true, 'Ivanov', false, false, '12345678', 1, 'Babalaeva', 'Irina', 'Pavlova', '1988-12-01', 'http://server.local/media/onePhoto.jpg');
INSERT INTO staff.staffs_backup (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (2, false, 'IRINA', true, false, 'qwerty12345', 2, 'On', 'Hero', 'Heroin', '2002-03-01', 'http://server.local/media/twoPhoto.jpg');
INSERT INTO staff.staffs_backup (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (3, true, 'Kuka', true, true, 'fatboybutcool2008', 3, 'Kurochkina', 'Karina', 'Heroin', '2002-03-01', 'http://server.local/media/threePhoto.jpg');
INSERT INTO staff.staffs_backup (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (4, true, 'GigaCHad228', false, false, 'bigbrain', 4, 'Rubtsov', 'Vladislave', 'Andreevich', '2004-08-02', 'http://server.local/media/fourPhoto.jpg');
INSERT INTO staff.staffs_backup (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (5, true, 'Lexa2009', false, false, 'Kurolisk', 5, 'Zubenko', 'Aleksey', 'Artemovich', '2001-05-25', 'http://server.local/media/fivePhoto.jpg');
INSERT INTO staff.staffs_backup (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (6, false, 'ZhmishenkoMihuil1998', true, false, 'vodkatop778', 6, 'Litvina', 'Olga', 'Nikolaevna', '1995-04-14', 'http://server.local/media/sixPhoto.jpg');
INSERT INTO staff.staffs_backup (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (7, true, 'Procser2005', false, true, 'Alegator12', 3, 'Abrikosov', 'Evgeniy', 'Rubenovich', '1988-12-30', 'http://server.local/media/sevenPhoto.jpg');
INSERT INTO staff.staffs_backup (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (8, false, 'ZhestkieNogty', true, true, 'LenusikGolovach7200', 3, 'Dudina', 'Natalia', 'Vladimirovna', '2008-02-03', 'http://server.local/media/eightPhoto.jpg');
INSERT INTO staff.staffs_backup (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (9, false, 'maximka', false, false, '12345678', 2, 'Pro', 'Maxim', 'Ivanovich', '2002-03-04', 'http://server.local/media/ninePhoto.jpg');