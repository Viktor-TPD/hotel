# YRGOPELAGO Assignment

This repository is a project for the PHP course in the Web Developer program at YRGO Higher Vocational School in Gothenburg. The project has a MIT license. The purpose of the project was to build a hotel website, where classmates could book rooms using transfercodes generated at an API-endpoint. More information can be found at [Yrgopelago](https://www.yrgopelago.se/). Part of the assignment was a competition where you could win different prizes based on visting others' hotels, highest occupancy rate, best frontend and most money left.

The project was built using PHP, SQLite, Javascript and CSS.

The following Composer packages have been used in the website:

- [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) - for .env-files
- [guzzlehttp/guzzle](https://github.com/guzzle/guzzle) - for fetching API endpoints
- [benhall14/php-calendar](https://github.com/benhall14/php-calendar) - for building a calendar

To check out the website live, visit: [Second Long Street](https://viktor-tpd.se/hotel/).

## Description

The hotel allows the user to book one of three hotel rooms, along with a choice of features. Rooms are charged per day and features are charged per booking. The calendar available on the website displays the available dates for the user. Both the calendar and the booking form are connected to a database which stores prior bookings.

When a user books, they must generate a transfer code using their own API-key. This is done at https://www.yrgopelago.se/centralbank but can also be done on the website using the Withdrawal form. When this form is used, it sends a post request to the API endpoint https://www.yrgopelago.se/centralbank/withdraw. If the user and the API-key, it generates a transfer code with the specified amount. The name and the generated transfer code are then dynamically added into the booking form.

When the booking form is filled in and submitted, the dates are first checked against prior bookings in the database. If the dates are already booked, an error message is presented to the user. After this, the total cost is generated. The website then uses Guzzle to send a POST request to the API-endpoint at https://www.yrgopelago.se/centralbank/transferCode with the transfer code and total cost. If the generated transfer code is correct, the dates are entered into the database. If the transfer code is not correct or has already been used or the total cost doesn't match the cost associated with the transfer code, an error message is generated for the user.

Once the transfer code has been checked and the POST request is successful, the transfercode is deposited at https://www.yrgopelago.se/centralbank/deposit, the booking data is added to database.db and a .json-file is generated with all the relevant details from the booking. The user is then redirected back to the index.php page. This receipt can then be saved by the user in their logbook.

![Simon Pegg](https://i.giphy.com/media/v1.Y2lkPTc5MGI3NjExNThoZDIzOHFneGY2YTYyOTMxeG5tMmJyaDByb2FsbjRydHVpeWNraSZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/QsyPRpG6WVR6SYfBVw/giphy.gif)

## Installation

Clone the repository on your local machine in an appropriate folder:

```
 git clone https://github.com/Andreawingardh/Yrgopelago.git
```

Navigate to the folder:

```
cd hotel/app
```

And create the folder "database".

```
mkdir database
```

Start a local host in the folder and navigate to index.php to view the website.

To create your own database, follow the instructions in [Database-queries.txt](/app/database/database-queries.txt).

**Happy travels!**

##Feedback

Very well structured project with multiple different files handling different segments. Good looking site, nice error handling, and I'd definitely stay here.

- store.php / row 54-57: You could have added a trim() around the htmlspecialchars() to avoid errors if someone accidentally adds a space.

- store.php / row 83-84: The more secure practice of a "prepare"-statement could be used here for consistency.

- index.php / row 15-19: Room names could have been stored and called upon from a different file to keep index.php cleaner.

- index.php / row 25, 40, 46, 168: Alt texts could have a description to avoid accessibility issues.

- index.php / row 145: Agreed, despite the economy nowadays, someone may want to visit your hotel for more than 10 days.

- admin.php / row ?: For security reasons, you could add a timeout to log out the admin after a certain amount of time.

- admin.php / row 17, 32, 42: Maybe keep your comments in a similar format to be more coherent, mainly for consistency.
