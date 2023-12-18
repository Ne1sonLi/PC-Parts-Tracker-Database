# PC Parts Tracker Database Project

### Project Description

This project is about modeling PC components to allow users to understand how different parts of a PC work together and what is required to create your own PC. Using this database, users will be able to look up the price of different PC parts and customize their own PC. They can add parts to the tables to keep track of the parts that they want and get some summary query results from the parts they have added such as filtering for keyboards by their brand, colour, percentage and price, finding keyboards and mouses that have the same colour or brand, and finding the average, maximum, or minimum price of GPU(s) based on brand or number of fans.

When users provide text input in this project, it is sanitized through a bounding SQL function which treats the inputs as strings first. By doing this, there is no worry about users accidentally deleting or editing the tables. This also acts as to prevent those intentionally trying to delete tables.

### How to Use



### Implementation

This project is done entirely using PHP along with Oracle as the database management system. 

### Milestone 1

This milestone was the introduction of the project. Here the idea was brought together and the first draft of the ER diagram was created.

### Milestone 2

Milestone 2 included improvements to the ER diagram to ensure that it models real PC parts more accurately. In addition, the ER diagram was translated into the appropriate relational model. From there, each table was decomposed into BCNF (Boyce-Codd Normal Form) by breaking down the tables on their functional dependencies. Finally, the SQL/DDL statements for creating each normalized table were drafted along with the states for inserting 5 tuples into each one.

### Milestone 3

Here, the team created a timeline for how to implement the rest of the project.

### Milstone 4

Milestone 4 included the implementation of the entire project. The first step was creating the sql script that would drop all the existing tables, recreate them, and initialize them with the base tuples we have chosen. Once that was done, we started designed the frontend of our project with the idea of keeping it user friendly and minimalistic. With that in mind, we implemented various operations for users to perform on the database such as adding, deleteing, and updating new PC parts, finding keyboards and mouse that are from a certain brand/colour, etc. Once we finished implementing all the functionality, we separated the functions into three separte pages so that it is easier for users to operate.