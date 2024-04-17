create table staffs_aes
(
    id         int auto_increment,
    gender     bit default b'0' not null,
    skype      varchar(255)     null,
    is_online  bit default b'0' not null,
    is_admin   bit default b'0' not null,
    password   blob             not null,
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

INSERT INTO staff.staffs_aes (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (1, true, 'Ivanov', false, false, 0x9BEE29EF4946BF56FE63B502B3D9AEE7, 1, 'Babalaeva', 'Irina', 'Pavlova', '1988-12-01', 'http://server.local/media/onePhoto.jpg');
INSERT INTO staff.staffs_aes (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (2, false, 'IRINA', true, false, 0x5A4A55FEF8156B585AFCB6EE3AEC56AA, 2, 'On', 'Hero', 'Heroin', '2002-03-01', 'http://server.local/media/twoPhoto.jpg');
INSERT INTO staff.staffs_aes (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (3, true, 'Kuka', true, true, 0xED89409B7F8C0AE16DFBCD4719692C5AE2F26A183477834F897637368E42A405, 3, 'Kurochkina', 'Karina', 'Heroin', '2002-03-01', 'http://server.local/media/threePhoto.jpg');
INSERT INTO staff.staffs_aes (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (4, true, 'GigaCHad228', false, false, 0x5581DE6E2E9EA6B02F4CAAE61A2CD944, 4, 'Rubtsov', 'Vladislave', 'Andreevich', '2004-08-02', 'http://server.local/media/fourPhoto.jpg');
INSERT INTO staff.staffs_aes (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (5, true, 'Lexa2009', false, false, 0xA9FA9812A46AC410115CE9BB291308AC, 5, 'Zubenko', 'Aleksey', 'Artemovich', '2001-05-25', 'http://server.local/media/fivePhoto.jpg');
INSERT INTO staff.staffs_aes (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (6, false, 'ZhmishenkoMihuil1998', true, false, 0xE04B814C9CE1A09C11A16EF2570992D7, 6, 'Litvina', 'Olga', 'Nikolaevna', '1995-04-14', 'http://server.local/media/sixPhoto.jpg');
INSERT INTO staff.staffs_aes (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (7, true, 'Procser2005', false, true, 0x89B1C8E0AFE78F353857D8C38723FAE6, 3, 'Abrikosov', 'Evgeniy', 'Rubenovich', '1988-12-30', 'http://server.local/media/sevenPhoto.jpg');
INSERT INTO staff.staffs_aes (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (8, false, 'ZhestkieNogty', true, true, 0x55BD33C298EA1F864D035F2EBBC4D8A91E1E92C03E2FEA3BB4415E795E9FD9A2, 3, 'Dudina', 'Natalia', 'Vladimirovna', '2008-02-03', 'http://server.local/media/eightPhoto.jpg');
INSERT INTO staff.staffs_aes (id, gender, skype, is_online, is_admin, password, post, lastname, firstname, middlename, dob, photo) VALUES (9, false, 'maximka', false, false, 0x9BEE29EF4946BF56FE63B502B3D9AEE7, 2, 'Pro', 'Maxim', 'Ivanovich', '2002-03-04', 'http://server.local/media/ninePhoto.jpg');