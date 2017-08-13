CREATE TABLE students
(
    id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255)  NULL,
    date_of_birth DATETIME NOT NULL,
    sex ENUM('male', 'female') NOT NULL,
    `group` VARCHAR(255) NOT NULL,
    faculty VARCHAR(255) NOT NULL
);
INSERT INTO mini_mvc.students (first_name, last_name, email, date_of_birth, sex, `group`, faculty) VALUES
('John', 'Doe', 'doe@gmail.com' , '2008-07-04 00:00:00', 'male', 'XZ-1', 'Gryffindor'),
('Super', 'Woman', 'your_super_woman@gmail.com', '2009-08-05 00:00:00', 'female', 'YY-2', 'Ravenclaw'),
('Extra', 'Person', 'something@extra.com', '2009-08-05 00:00:00', 'female', 'XY-2', 'Slytherin');