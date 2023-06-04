# SE & Webtech project repo

## Project URL's
Provide a link to the main page of your application. Or if you have multiple parts in your website you can provide a list of links (i.e. not all pages are in your main navigation bar)
* [Main login page](https://a22web13.studev.groept.be/public/)

---

## Website credentials
### Regular user
- login : Amal__York1720
- password :OUC51OZS0OH

---

## Implemented Features
Provide a short description of the actual implemented features in your project

* user authentication (logging in) (Cornelia)
User can only navigate to Login page and Sign Up page before authenticated. By using security tools provided by symfony, user can logged in with their username and password. Because our User entity implements UserInterface and PasswordAuthenticatedUserInterface the authentication is done by security tools to compare the inputted password match the hashed password stored in the database. If user put the wrong username and(or) password and then click log in button, an error message will appear as "Invalid credentials". After a succesful login, user will get role as user, redirected to Home page and their username is kept on the top navigation bar.

* user registration (Cornelia)
User can register themselves, however their username should be unique. There is a check done by javascript if user input a unique username, if yes, a message will appear as 'Username can be used"

* user logging out (Cornelia)
* display top trending books (Cornelia)
* display user favorite books (Chrysovalantis)
* display user nearest library (Cornelia)
* search a book by ISBN number (Yannick)
* follow and unfollow books (Chrysovalantis)
* give review and rating about the book (Chrysovalantis)
* display user profile (Ruben)
* send meet up request (Joewri)
* accept/decline meet up request (Joewri)
* display upcoming meet up (Joewri)
