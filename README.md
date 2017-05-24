symfony3
========

A Symfony project created on May 19, 2017, 7:11 pm.

This is an example Symfony3 project to meet the requirements found at https://github.com/TalentNet/coding-challenges/blob/master/roles/senior-php.md

Overview:

-The majority of the code makes use of FOSRestBundle for basic CRUD functionality.

-Guard token authentication was used for authentication against Put, Post & Delete and requires a username and token be added to the user table.

-For created and updated fields StofDoctrineExtensionsBundle was used for the timestampable feature.

-Kahlan package is installed with a basic spec file.

-Config file is set to use 'p4ssw0rd' for the local mysql database named 'symfony', adjust accordingly.

-Undone: Doctrine fixtures for loading seed data. I manually inserted dummy data during development and have reached the time limit.

REST API Endpoints

/product  - Basic CRUD endpoints for GET, POST, PUT & DELETE
/category - Just a GET