create database curso_testing_dev;
create database curso_testing_test;

grant all privileges on curso_testing_dev.* to curso_testing_dev@'%' identified by 'curso_testing_dev'  with grant option;
grant all privileges on curso_testing_test.* to curso_testing_test@'localhost' identified by 'curso_testing_test' with grant option;
flush privileges;
