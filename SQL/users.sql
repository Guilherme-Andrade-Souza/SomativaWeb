create user "admin"@"localhost" identified by "U7d*ki1$Pm";
grant all privileges on somativa_web.* to "admin"@"localhost";
flush privileges;

create user "user"@"localhost" identified by "U&c56xLW%m";
grant select, insert, delete, update on somativa_web.* to "user"@"localhost";
flush privileges;