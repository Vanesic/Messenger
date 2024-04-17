create procedure staff.check_password(IN pass varchar(50))
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

