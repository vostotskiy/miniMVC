CREATE TABLE students
(
    id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    date_of_birth DATETIME NOT NULL,
    sex ENUM('male', 'female') NOT NULL,
    `group` VARCHAR(255) NOT NULL,
    faculty VARCHAR(255) NOT NULL
);
INSERT INTO mini_mvc.students (first_name, last_name, date_of_birth, sex, `group`, faculty) VALUES ('John', 'Doe', '2008-07-04 00:00:00', 'male', 'XZ-1', 'Gryffindor');
INSERT INTO mini_mvc.students (first_name, last_name, date_of_birth, sex, `group`, faculty) VALUES ('Super', 'Woman', '2009-08-05 00:00:00', 'female', 'YY-2', 'Ravenclaw');
INSERT INTO mini_mvc.students (first_name, last_name, date_of_birth, sex, `group`, faculty) VALUES ('Extra', 'Person', '2009-08-05 00:00:00', 'female', 'XY-2', 'Slytherin');