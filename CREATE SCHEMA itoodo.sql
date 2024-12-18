CREATE SCHEMA itoodo;

SHOW databases;

USE itoodo;

-- User ->
--     id
--     username
-- 	   email
--     password
--     created_at

create table user(
	id int auto_increment primary key,
    username varchar(250) not null,
    email varchar(250),
    pass varchar(250),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- select * from user;

-- Todo ->
--     id
--     title
--     body
--     status
--     user_id
--     created_at
--     updated_at

create table todo(
	id int auto_increment primary key,
    title varchar(250) not null,
    body text,
    completed boolean,
    completion_date TIMESTAMP,
    user_id int not null,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    foreign key (user_id) references user(id) on delete cascade
)


-- ***** testing data:
INSERT INTO user (username, email, pass) VALUES
('john_doe', 'john@example.com', 'password123'),
('jane_smith', 'jane@example.com', 'securepass456'),
('mike_brown', 'mike@example.com', 'mikebrown789'),
('sarah_jones', 'sarah@example.com', 'sarahpassword'),
('emily_white', 'emily@example.com', 'emily12345'),
('david_clark', 'david@example.com', 'davidpass567'),
('olivia_adams', 'olivia@example.com', 'oliviapass123'),
('daniel_moore', 'daniel@example.com', 'danielsecure789'),
('sophia_hill', 'sophia@example.com', 'sophiapass111'),
('liam_walker', 'liam@example.com', 'liampassword123');

--INSERT INTO user (username, email, pass) VALUES
--('pete_zahut', 'petezahut@example.com', 'petezahut');

-- select * from user;

INSERT INTO todo (title, body, completed, completion_date, user_id) VALUES
-- Todos for User 1
('Buy groceries', 'Get milk, bread, and eggs from the store.', false, NULL, 1),
('Read book', 'Read the first three chapters of "Atomic Habits".', false, NULL, 1),
('Workout', 'Complete a 30-minute workout session.', true, '2024-12-01 10:00:00', 1),

-- Todos for User 2
('Call Mom', 'Give Mom a quick call to check in.', true, '2024-11-30 15:00:00', 2),
('Plan vacation', 'Research destinations and book tickets.', false, NULL, 2),
('Clean kitchen', 'Wash dishes and wipe down counters.', true, '2024-11-30 18:30:00', 2),

-- Todos for User 3
('Submit report', 'Finalize and submit the monthly sales report.', true, '2024-12-01 09:00:00', 3),
('Attend meeting', 'Participate in the team meeting via Zoom.', false, NULL, 3),
('Pick up dry cleaning', 'Collect the clothes from the dry cleaner.', true, '2024-12-01 14:00:00', 3),

-- Todos for User 4
('Study for exam', 'Review chapters 5-7 of the math textbook.', false, NULL, 4),
('Write blog post', 'Draft and publish the new blog post on productivity.', false, NULL, 4),
('Organize files', 'Sort and organize documents in the computer.', true, '2024-11-29 17:00:00', 4),

-- Todos for User 5
('Grocery shopping', 'Get veggies, fruits, and snacks.', false, NULL, 5),
('Finish presentation', 'Complete the slides for the upcoming client meeting.', true, '2024-11-28 21:00:00', 5),
('Walk the dog', 'Take Max out for a 20-minute walk.', true, '2024-11-28 19:00:00', 5),

-- Todos for User 6
('Practice guitar', 'Learn and practice new chords for an hour.', false, NULL, 6),
('Watch tutorial', 'Complete the web development tutorial series.', true, '2024-11-27 22:00:00', 6),
('Water plants', 'Water the plants in the living room and balcony.', false, NULL, 6),

-- Todos for User 7
('Buy birthday gift', 'Find a gift for Olivia\'s birthday.', true, '2024-11-30 11:00:00', 7),
('Prepare dinner', 'Cook pasta for the family dinner.', true, '2024-11-30 20:00:00', 7),
('Check emails', 'Respond to all pending emails from the week.', false, NULL, 7),

-- Todos for User 8
('Update resume', 'Add the recent work experience to the resume.', false, NULL, 8),
('Pay bills', 'Pay the electricity and internet bills.', true, '2024-12-01 12:00:00', 8),
('Plan weekend trip', 'Research activities and book tickets.', false, NULL, 8),

-- Todos for User 9
('Meditation', 'Spend 15 minutes meditating to relax.', false, NULL, 9),
('Repair bike', 'Fix the flat tire on the bike.', true, '2024-12-01 08:30:00', 9),
('Organize desk', 'Clear and arrange the desk for better productivity.', true, '2024-11-29 19:00:00', 9),

-- Todos for User 10
('Buy groceries', 'Get vegetables and pasta for dinner.', false, NULL, 10),
('Study PHP', 'Learn about Laravel framework for a new project.', true, '2024-12-01 22:00:00', 10),
('Call friend', 'Catch up with Daniel on a quick call.', false, NULL, 10);

-- select * from todo;
-- SELECT * -- 1 
-- FROM user
-- WHERE username = 'jane_smith' AND pass = 'securepass456' 
-- LIMIT 1;

-- -- joins

-- select td.*
-- from todo td
-- inner join user us
-- on td.user_id = us.id
-- where us.username = "john_doe";

-- trigger for completed
DELIMITER $$

CREATE TRIGGER update_completion_date
BEFORE UPDATE ON todo
FOR EACH ROW
BEGIN
    -- Check if the 'completed' field is being updated and if it's being set to true (1)
    IF NEW.completed != OLD.completed THEN
        -- Set 'completion_date' to the current timestamp when 'completed' is updated
        SET NEW.completion_date = IF(NEW.completed = 1, NOW(), NULL);
    END IF;
END $$

DELIMITER ;