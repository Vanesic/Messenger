# Проверка плагинов

use information_schema;

select PLUGIN_NAME, PLUGIN_STATUS from PLUGINS;

show variables like '%keyring%';

show global variables like 'innodb_file_per_table';

show variables like 'plugin_dir';

install plugin keyring_file soname 'keyring_file.dll';




# Роли

create user 'messanger_user'@'localhost' identified by '12345';

grant insert, select, update, delete on staff.staffs to 'messanger_user'@'localhost';
grant insert, update, delete on staff.emails to 'messanger_user'@'localhost';
grant insert, update,delete on staff.telephones to 'messanger_user'@'localhost';
grant insert, update, delete on staff.schedule to 'messanger_user'@'localhost';
grant insert, update, delete on staff.messages to 'messanger_user'@'localhost';
grant execute on procedure staff.check_password to messanger_user@localhost;


# Работа с staff

use staff;

SELECT PLUGIN_NAME, PLUGIN_STATUS FROM INFORMATION_SCHEMA.PLUGINS WHERE PLUGIN_NAME LIKE 'keyring%';

create table access_keys (
    id smallint primary key auto_increment,
    access_key varchar(40) not null default ('shimmer'),
    date datetime not null default (now())
);

select * from access_keys;



# sha1

select * from staffs_sha1;

select * from staffs_sha1 where password = sha1('12345678');



# aes_encrypt

select * from staffs;

select * from staffs_aes;

select gender, skype, is_online, is_admin,
       aes_decrypt(password, (select access_key from access_keys where id = 1)),
       post, lastname, firstname, middlename, dob, photo
    from staffs_aes;




# Процедура шифрования (Не описывать в отчете - это на всякий)

create procedure mass_crypt ()
    begin
     declare a int;
     declare pass varchar(50);

     set a = 1;
     set @key = (select access_key from access_keys where id = 1);

     while a < 10 do
         set pass = (select password from staffs where id = a);
         update staffs set password = aes_encrypt(pass, @key) where staffs.id = a;
         set a = a + 1;
         end while;
    end;

call mass_crypt();


# Процедура проверки пароля

create procedure check_password (pass varchar(50))
    begin
        declare password_check bool;
        set password_check = false;

        if
            exists((select password from staffs
            where password =
                  aes_encrypt(pass, (select access_key from access_keys
                  where access_keys.id = 1))))
            then
        set password_check = true;

        end if;

        select password_check;

    end;

call check_password('qwerty12345');







# Посты

create table schedule (
    id int primary key auto_increment unique ,
    schedule_name text(128) not null ,
    schedule_text text(512) not null ,
    schedule_photo text(512),
    schedule_time datetime not null default (now()),
    wiews int default 0,
    author_id int not null,
    foreign key (author_id) references staffs (id)
);



select * from schedule;









# Триггер на полное удаление инфы о пльзователе

create trigger mass_delete
    after delete on staffs
    for each row
    begin
        delete from telephones where id_staff = OLD.id;
        delete from emails where id_staff = OLD.id;
        delete from schedule where author_id = OLD.id;
    end;


