create procedure staff.mass_crypt()
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

