create trigger staff.mass_delete
	after delete
	on staff.staffs
	for each row
	begin
        delete from telephones where id_staff = OLD.id;
        delete from emails where id_staff = OLD.id;
        delete from schedule where author_id = OLD.id;
    end;

