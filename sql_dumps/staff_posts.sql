create table posts
(
    id        int auto_increment
        primary key,
    name_post varchar(127) not null
);

INSERT INTO staff.posts (id, name_post) VALUES (3, 'sysadm');
INSERT INTO staff.posts (id, name_post) VALUES (5, 'teacher');
INSERT INTO staff.posts (id, name_post) VALUES (6, 'programmer');
INSERT INTO staff.posts (id, name_post) VALUES (8, 'cleaner');
INSERT INTO staff.posts (id, name_post) VALUES (9, 'frontend');
INSERT INTO staff.posts (id, name_post) VALUES (11, 'database');
INSERT INTO staff.posts (id, name_post) VALUES (12, 'cook');