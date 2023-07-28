CREATE TABLE students (
id SERIAL PRIMARY KEY,
username VARCHAR(30) NOT NULL,
password VARCHAR(20) NOT NULL,
first_name VARCHAR(20) NOT NULL,
last_name VARCHAR(30) NOT NULL,
email VARCHAR(40) NOT NULL,
phone VARCHAR(18) NOT NULL,
created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE librarians (
lib_id SERIAL PRIMARY KEY,
lib_username VARCHAR(30) NOT NULL,
lib_password VARCHAR(20) NOT NULL,
lib_first_name VARCHAR(20) NOT NULL,
lib_last_name VARCHAR(30) NOT NULL,
lib_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE room (
room_id SERIAL PRIMARY KEY,
type VARCHAR(15) NOT NULL,
capacity INTEGER NOT NULL,
floor INTEGER NOT NULL,
room_number VARCHAR(10) NOT NULL,
CONSTRAINT room_type_floor CHECK (type IN ('study', 'collaboration', 'group') AND floor < 6)
);

CREATE TABLE reservation (
reservation_id SERIAL PRIMARY KEY,
stud_id INTEGER NOT NULL,
room_id INTEGER NOT NULL,
description VARCHAR(50),
number_of_people INTEGER NOT NULL CHECK (number_of_people <= 6),
date DATE NOT NULL,
start_time TIME NOT NULL,
end_time TIME NOT NULL,
CONSTRAINT reservation_stud FOREIGN KEY (stud_id)
REFERENCES students(id),
CONSTRAINT reservation_room FOREIGN KEY (room_id)
REFERENCES room(room_id)
);

INSERT INTO students (username, password, first_name, last_name, email, phone) VALUES ('S300123', '1234', 'Sam', 'Smith', 'samsmith@gmail.com', '(604) 123 1234');
INSERT INTO students (username, password, first_name, last_name, email, phone) VALUES ('S300124', '1234', 'Claire', 'Buck', 'clairebuck@gmail.com', '(604) 123 1235');

INSERT INTO librarians (lib_username, lib_password, lib_first_name, lib_last_name) VALUES ('L900123', '1234', 'Max', 'Thompson');
INSERT INTO librarians (lib_username, lib_password, lib_first_name, lib_last_name) VALUES ('L900124', '1234', 'Gwen', 'Bell');

INSERT INTO room (type, capacity, floor, room_number) VALUES ('study', 2, 2, 'N2341');
INSERT INTO room (type, capacity, floor, room_number) VALUES ('collaboration', 5, 2, 'N2345');
INSERT INTO room (type, capacity, floor, room_number) VALUES ('group', 10, 3, 'N3341');

INSERT INTO reservation (stud_id, room_id, description, number_of_people, date, start_time, end_time) VALUES (1, 2, 'DB II Group Project meeting', 3, '2019-03-23', '9:00', '11:00');
INSERT INTO reservation (stud_id, room_id, description, number_of_people, date, start_time, end_time) VALUES (2, 2, 'DB II Group Project presentation discussion', 3, '2019-03-30', '12:00', '14:00');
INSERT INTO reservation (stud_id, room_id, description, number_of_people, date, start_time, end_time) VALUES (2, 3, 'Software Engineering', 4, '2019-04-01', '13:00', '15:00');
INSERT INTO reservation (stud_id, room_id, description, number_of_people, date, start_time, end_time) VALUES (1, 1, 'Netowork Security', 2, '2019-04-02', '15:00', '18:00');