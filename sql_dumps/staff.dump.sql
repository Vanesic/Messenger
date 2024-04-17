
create table staffs
(
    id         int auto_increment,
    gender     bit default b'0' not null,
    skype      varchar(255)     null,
    is_online  bit default b'0' not null,
    is_admin   bit default b'0' not null,
    password   blob             not null,
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

create fulltext index f
    on staffs (firstname);

create fulltext index l
    on staffs (lastname);

create fulltext index lfm
    on staffs (lastname, firstname, middlename);

create fulltext index m
    on staffs (middlename);

alter table staffs
    add primary key (id);



INSERT INTO staffs (id, gender, skype, is_online, is_admin, password, lastname, firstname, middlename, dob, photo) VALUES (1, true, 'Ivanov', true, false, 0x9BEE29EF4946BF56FE63B502B3D9AEE7, 'Babalaeva', 'Irina', 'Pavlova', '1988-12-01', 'http://server.local/media/onePhoto.jpg');
INSERT INTO staffs (id, gender, skype, is_online, is_admin, password, lastname, firstname, middlename, dob, photo) VALUES (2, false, 'IRINA', true, false, 0x5A4A55FEF8156B585AFCB6EE3AEC56AA, 'On', 'Hero', 'Heroin', '2002-03-01', 'http://server.local/media/twoPhoto.jpg');
INSERT INTO staffs (id, gender, skype, is_online, is_admin, password, lastname, firstname, middlename, dob, photo) VALUES (3, true, 'Kuka', true, true, 0xED89409B7F8C0AE16DFBCD4719692C5AE2F26A183477834F897637368E42A405, 'Kurochkina', 'Karina', 'Heroin', '2002-03-01', 'http://server.local/media/threePhoto.jpg');
INSERT INTO staffs (id, gender, skype, is_online, is_admin, password, lastname, firstname, middlename, dob, photo) VALUES (4, true, 'GigaCHad228', false, false, 0x5581DE6E2E9EA6B02F4CAAE61A2CD944, 'Rubtsov', 'Vladislave', 'Andreevich', '2004-08-02', 'http://server.local/media/fourPhoto.jpg');
INSERT INTO staffs (id, gender, skype, is_online, is_admin, password, lastname, firstname, middlename, dob, photo) VALUES (5, true, 'Lexa2009', false, false, 0xA9FA9812A46AC410115CE9BB291308AC, 'Zubenko', 'Aleksey', 'Artemovich', '2001-05-25', 'http://server.local/media/fivePhoto.jpg');
INSERT INTO staffs (id, gender, skype, is_online, is_admin, password, lastname, firstname, middlename, dob, photo) VALUES (6, false, 'ZhmishenkoMihuil1998', true, false, 0xE04B814C9CE1A09C11A16EF2570992D7, 'Litvina', 'Olga', 'Nikolaevna', '1995-04-14', 'http://server.local/media/sixPhoto.jpg');
INSERT INTO staffs (id, gender, skype, is_online, is_admin, password, lastname, firstname, middlename, dob, photo) VALUES (7, true, 'Procser2005', false, true, 0x89B1C8E0AFE78F353857D8C38723FAE6, 'Abrikosov', 'Evgeniy', 'Rubenovich', '1988-12-30', 'http://server.local/media/sevenPhoto.jpg');
INSERT INTO staffs (id, gender, skype, is_online, is_admin, password, lastname, firstname, middlename, dob, photo) VALUES (8, false, 'ZhestkieNogty', true, true, 0x55BD33C298EA1F864D035F2EBBC4D8A91E1E92C03E2FEA3BB4415E795E9FD9A2, 'Dudina', 'Natalia', 'Vladimirovna', '2008-02-03', 'http://server.local/media/eightPhoto.jpg');
INSERT INTO staffs (id, gender, skype, is_online, is_admin, password, lastname, firstname, middlename, dob, photo) VALUES (9, false, 'maximka', false, false, 0x9BEE29EF4946BF56FE63B502B3D9AEE7, 'Pro', 'Maxim', 'Ivanovich', '2002-03-04', 'http://server.local/media/ninePhoto.jpg');


create table emails
(
    id       int auto_increment,
    id_staff int          not null,
    email    varchar(255) not null,
    constraint id
        unique (id),
    constraint FK_staff_id_emails
        foreign key (id_staff) references staffs (id)
            on update cascade on delete cascade
);

create fulltext index ft
    on emails (email);

alter table emails
    add primary key (id);



INSERT INTO staff.emails (id, id_staff, email) VALUES (1, 1, 'lublusql2001@gmail.com');
INSERT INTO staff.emails (id, id_staff, email) VALUES (2, 1, 'jumba@sfedu.ru');
INSERT INTO staff.emails (id, id_staff, email) VALUES (3, 2, 'dudinivan15@gmail.com');
INSERT INTO staff.emails (id, id_staff, email) VALUES (4, 4, 'vlaDick909@gmail.com');
INSERT INTO staff.emails (id, id_staff, email) VALUES (5, 4, 'vladRub2004@mail.ru');
INSERT INTO staff.emails (id, id_staff, email) VALUES (6, 5, 'AlexZver@mail.ru');
INSERT INTO staff.emails (id, id_staff, email) VALUES (7, 6, 'olya31@mail.ru');
INSERT INTO staff.emails (id, id_staff, email) VALUES (8, 6, 'vasiliyHyiliy2001@mail.ru');
INSERT INTO staff.emails (id, id_staff, email) VALUES (9, 7, 'Zhen92002@yandex.ru');
INSERT INTO staff.emails (id, id_staff, email) VALUES (10, 8, 'NATAxA999@mail.ru');
INSERT INTO staff.emails (id, id_staff, email) VALUES (11, 8, 'dudina@sfedu.ru');
INSERT INTO staff.emails (id, id_staff, email) VALUES (12, 8, 'dudina15@gmail.com');
INSERT INTO staff.emails (id, id_staff, email) VALUES (13, 9, 'maximPro2004@gmail.com');
INSERT INTO staff.emails (id, id_staff, email) VALUES (14, 9, 'ilovecook@yandex.ru');
INSERT INTO staff.emails (id, id_staff, email) VALUES (15, 3, 'huhatuta12@mail.ru');

create table messages
(
    id             int auto_increment,
    letter         text             not null,
    send_at        datetime         not null,
    open_at        datetime         null,
    id_dialog      int              not null,
    id_send        int              not null,
    id_get         int              not null,
    is_notificated bit default b'0' null,
    constraint id
        unique (id),
    constraint FK_staff_id_get
        foreign key (id_get) references staffs (id)
            on update cascade on delete cascade,
    constraint FK_staff_id_send
        foreign key (id_send) references staffs (id)
            on update cascade on delete cascade
);

create index FK_id_dialog
    on messages (id_dialog);



INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (1, 'I LOVE PELMENI! YOU TOO?????', '2022-04-22 13:48:09', null, 1, 1, 4, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (2, 'OK, it''s cool!', '2022-04-22 10:12:33', null, 1, 4, 1, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (3, 'Hello, i''m your mentor. Send me your task', '2022-05-01 12:12:23', '2022-09-29 02:40:44', 2, 2, 3, true);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (4, 'Hello. Sorry, i don''t do this task :( Can i send it later?', '2022-05-01 14:45:10', '2022-10-04 16:56:18', 2, 3, 2, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (5, 'Stupid idiot. Oh.... ok', '2022-05-01 14:47:12', null, 2, 2, 3, true);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (6, 'Thanks!', '2022-05-01 14:48:12', null, 2, 3, 2, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (7, 'Yeah, i like it too. But beer is better', '2022-04-22 15:12:01', null, 1, 1, 4, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (8, 'Hello! You are very smart girl. Maybee...we''ll get to know each other?', '2022-05-02 19:10:11', null, 3, 4, 6, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (9, 'Hello, it''s a pity but you are very ugly.. Sorry', '2022-05-02 20:11:12', null, 3, 6, 4, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (10, 'Wtf, bitch??? I will break your preety face, ok?', '2022-05-02 11:32:58', null, 3, 4, 6, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (11, 'oh, DUUUUDE, you are so stupid, i''m ban you. DOOG BYE!', '2022-05-03 09:12:40', null, 3, 6, 4, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (12, 'I want to be free!', '2022-05-02 12:55:13', null, 4, 5, 1, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (13, 'Potato free??? AHHAHAHAHAHAHAH!', '2022-05-02 17:30:29', null, 4, 1, 5, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (14, 'Man, it''s not a funny .__.', '2022-05-01 04:00:40', null, 4, 5, 1, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (15, 'I know...', '2022-05-02 12:55:13', null, 4, 1, 5, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (16, 'Good afternoon, can you give me a 1000$?', '2022-05-02 20:11:12', null, 5, 6, 7, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (17, 'NO! FUCK OFF!', '2022-05-02 11:32:58', null, 5, 7, 6, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (18, 'PLZ!!!!!', '2022-05-02 19:10:11', null, 5, 6, 7, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (19, 'i don''t have so much money', '2022-05-03 09:12:40', null, 5, 7, 6, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (20, 'you forever hate me! :((((((', '2022-05-02 20:11:12', null, 5, 6, 7, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (21, 'Maybee, we went home? I don''t want to stay in this office...', '2022-05-02 11:32:58', null, 6, 8, 7, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (22, 'Me too... But director will fucked us!', '2022-05-02 12:55:13', null, 6, 7, 8, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (23, 'oh... then, i go home!', '2022-05-02 19:10:11', null, 6, 8, 7, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (24, ';))))', '2022-05-02 20:11:12', null, 6, 7, 8, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (25, 'oh hello', '2022-05-04 13:21:30', '2022-05-04 13:25:49', 7, 6, 8, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (26, 'id 8, hello. it is me, 5', '2022-05-22 19:32:09', null, 8, 4, 5, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (27, 'hello, 5!. it is me, 8', '2022-05-25 12:33:32', null, 9, 8, 5, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (28, 'Hello, Irina', '2022-08-22 14:45:42', null, 1, 4, 1, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (29, 'I wonna rock', '2022-08-22 14:47:16', null, 1, 4, 1, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (30, 'I wonna rock too', '2022-08-22 16:34:57', null, 1, 1, 4, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (31, 'asd', '2022-08-22 16:35:08', null, 1, 1, 4, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (32, 'dasd', '2022-08-22 16:35:10', null, 1, 1, 4, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (33, 'dasd', '2022-08-22 16:35:11', null, 1, 1, 4, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (34, 'dasda', '2022-08-22 16:35:13', null, 1, 1, 4, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (35, 'dasda', '2022-08-22 16:35:14', null, 1, 1, 4, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (36, 'dasd', '2022-08-22 16:35:24', null, 1, 1, 4, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (37, 'fds', '2022-08-22 16:50:46', null, 1, 1, 4, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (38, 'вфывфы', '2022-08-22 17:58:54', '2022-10-16 15:52:06', 10, 1, 2, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (39, 'Ok, it''s not funny joke...', '2022-08-23 16:17:54', null, 4, 1, 5, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (40, 'd', '2022-09-23 06:32:18', null, 2, 3, 2, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (42, 'd', '2022-09-23 06:41:04', null, 2, 3, 2, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (43, 's', '2022-09-23 06:41:46', null, 2, 3, 2, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (44, 'fd', '2022-09-23 06:42:16', null, 2, 3, 2, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (45, 'das', '2022-09-23 06:43:19', null, 2, 3, 2, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (46, 'ds', '2022-09-23 06:44:15', null, 2, 3, 2, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (47, 'Hello, Irina', '2022-09-23 06:44:36', null, 2, 3, 2, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (48, 'sa', '2022-09-23 06:44:57', null, 2, 3, 2, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (49, 'dsa', '2022-09-23 06:45:23', null, 2, 3, 2, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (50, 'I like php, but zend is so fucking hard for my brain', '2022-09-23 06:51:49', null, 2, 3, 2, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (51, '1', '2022-09-23 07:00:34', null, 2, 3, 2, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (52, '2', '2022-09-23 07:00:35', null, 2, 3, 2, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (53, '3', '2022-09-23 07:00:35', null, 2, 3, 2, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (54, '4', '2022-09-23 07:00:36', null, 2, 3, 2, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (55, '5', '2022-09-23 07:00:37', null, 2, 3, 2, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (56, '6', '2022-09-23 07:00:38', null, 2, 3, 2, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (57, '7', '2022-09-23 07:01:10', null, 2, 3, 2, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (58, '8', '2022-09-23 07:18:36', '2022-09-29 02:41:04', 2, 3, 2, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (59, 'hdhdhd', '2022-09-29 17:31:40', null, 2, 2, 3, true);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (60, 'hdhdhd', '2022-09-29 17:31:42', null, 2, 2, 3, true);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (61, 'Hello, Irina', '2022-09-29 17:33:07', null, 2, 2, 3, true);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (62, 'dsa', '2022-09-29 17:34:32', null, 2, 2, 3, true);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (63, '', '2022-09-29 17:46:11', '2022-09-29 18:56:57', 2, 2, 3, true);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (64, 'fuck', '2022-09-29 19:01:49', '2022-09-29 23:03:45', 2, 3, 2, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (65, 'Hello, Irina', '2022-10-04 17:35:43', '2022-10-04 17:35:44', 11, 2, 2, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (66, 'Hello, Irina', '2022-10-04 17:36:06', null, 12, 2, 4, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (67, 'dajsd;akj', '2022-10-06 18:06:44', null, 2, 2, 3, true);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (68, 'Хехехехе, оно работает бля буду представлешь?', '2022-10-12 17:06:37', null, 12, 2, 4, false);
INSERT INTO staff.messages (id, letter, send_at, open_at, id_dialog, id_send, id_get, is_notificated) VALUES (69, 'Я в шоке ряльна', '2022-10-12 17:06:51', null, 12, 2, 4, false);

create table telephones
(
    id        int auto_increment,
    id_staff  int         not null,
    telephone varchar(12) not null,
    constraint id
        unique (id),
    constraint FK_staff_id_telephone
        foreign key (id_staff) references staffs (id)
            on update cascade on delete cascade
);

create fulltext index ft
    on telephones (telephone);

alter table telephones
    add primary key (id);



INSERT INTO staff.telephones (id, id_staff, telephone) VALUES (1, 1, '89081808697');
INSERT INTO staff.telephones (id, id_staff, telephone) VALUES (2, 1, '89881877654');
INSERT INTO staff.telephones (id, id_staff, telephone) VALUES (3, 2, '89881877654');
INSERT INTO staff.telephones (id, id_staff, telephone) VALUES (4, 4, '88123144313');
INSERT INTO staff.telephones (id, id_staff, telephone) VALUES (5, 5, '88394212343');
INSERT INTO staff.telephones (id, id_staff, telephone) VALUES (6, 5, '89892938212');
INSERT INTO staff.telephones (id, id_staff, telephone) VALUES (7, 6, '88213232123');
INSERT INTO staff.telephones (id, id_staff, telephone) VALUES (8, 7, '88213232123');
INSERT INTO staff.telephones (id, id_staff, telephone) VALUES (9, 8, '88122123433');
INSERT INTO staff.telephones (id, id_staff, telephone) VALUES (10, 8, '81232486886');
INSERT INTO staff.telephones (id, id_staff, telephone) VALUES (11, 5, '89081808697');
INSERT INTO staff.telephones (id, id_staff, telephone) VALUES (12, 9, '86546317236');
INSERT INTO staff.telephones (id, id_staff, telephone) VALUES (13, 3, '89081808697');
INSERT INTO staff.telephones (id, id_staff, telephone) VALUES (14, 3, '82536126536');

create table schedule
(
    id             int auto_increment,
    schedule_name  text                     not null,
    schedule_text  text                     not null,
    schedule_photo text                     null,
    schedule_time  datetime default (now()) not null,
    wiews          int      default 0       null,
    author_id      int                      not null,
    constraint id
        unique (id),
    constraint schedule_ibfk_1
        foreign key (author_id) references staffs (id)
);

create index author
    on schedule (author_id);

alter table schedule
    add primary key (id);



INSERT INTO staff.schedule (id, schedule_name, schedule_text, schedule_photo, schedule_time, wiews, author_id) VALUES (1, 'Ваня пидор', 'Это факт', null, '2022-10-30 15:00:45', 0, 1);

create table access_keys
(
    id         smallint auto_increment
        primary key,
    access_key varchar(40) default (_utf8mb4'shimmer') not null,
    date       datetime    default (now())             not null
);

INSERT INTO staff.access_keys (id, access_key, date) VALUES (1, 'duboeb', '2022-10-29 12:33:04');
