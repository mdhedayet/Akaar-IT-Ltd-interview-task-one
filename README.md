# TASK

Please find the customers.csv in public folder and complete these following tasks.  
1. Create appropriate migration for this csv
2. Import this csv batch/chunk wise with queue from a html view
3. Show imported data in a normal table  
3.1 Add a branch wise ajax filtering option for html table  
3.2 Add a gender wise ajax filtering option for html table
4. Create a stored procedure which will return branch wise `total_customer_count`, `total_male_customer_count`, `total_female_customer_count` from mysql
5. Show data from stored procedure above the html table
6. Send an email to admin@akaarit.com 30 second after import completes

Email configuration is already added in .env file.


## TASK One Done

## Getting Started

It's super easy to get TaskOne up and running.

1. clone the project

```shell
git clone https://github.com/mdhedayet/Akaar-IT-Ltd-interview-task-one.git
```

2. install the dependencies

```shell
cd Akaar-IT-Ltd-interview-task-one
composer install
```

3. Create Database and set it on  `.env`


4. Generate application key

```shell
php artisan key:generate
```

5. Start the webserver

```shell
php artisan serve
```
6. Migrate the database

```shell
php artisan migrate
```
7. Run Queue

```shell
php artisan queue:work --daemon
```

8. find the customers.csv in public folder and upload it. if queue is done than test the softwate. 
