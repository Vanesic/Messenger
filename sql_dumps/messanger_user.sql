create user 'messanger_user'@'localhost' identified by '12345';

grant insert, select, update, delete on staff.staffs to 'messanger_user'@'localhost';
grant insert, update, delete on staff.emails to 'messanger_user'@'localhost';
grant insert, update,delete on staff.telephones to 'messanger_user'@'localhost';
grant insert, update, delete on staff.schedule to 'messanger_user'@'localhost';
grant insert, update, delete on staff.messages to 'messanger_user'@'localhost';
grant execute on procedure staff.check_password to messanger_user@localhost;