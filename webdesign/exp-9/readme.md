CREATE DATABASE todo_app;
Select \* from todos;
USE todo_app;
DROP TABLE todos;

USE todo_app;

CREATE TABLE todos (
id INT AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(255) NOT NULL,
description TEXT,
status ENUM('pending', 'completed') DEFAULT 'pending'

);
