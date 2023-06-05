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

* ** user authentication** (logging in) :
User can only navigate to Login page and Sign Up page before authenticated. By using security tools provided by symfony, user can logged in with their username and password. Because our User entity implements UserInterface and PasswordAuthenticatedUserInterface the authentication is done by security tools (includes csrf token) to compare the inputted password match the hashed password stored in the database. If user put the wrong username and(or) password and then click log in button, an error message will appear as "Invalid credentials". After a succesful login, user will get role as user, redirected to Home page and their username is kept on the top navigation bar.

* **user registration** :
User can register themselves using registration form, however their username should be unique. There is a check done by javascript if user input a unique username, if yes, a message will appear as 'Username can be used". If username is already taken, and error message will says "Username already exists" then the Sign Up button will turned grey and not clickable. The same thing will happen if user not input any username, error message will appear and Sign Up button is not clickable. The rest of the form has a check for if repeated password match the password, if the house number and the postcode is inputted as number not alphabet. If user don't input the correct type, after user click Sign Up user will stay in the same page and an error message will appear accordingly.

* **user logging out** :
User logging out is using security tools by symfony. User can click Logout button on the top nagivation bar, and will redirect to the Login page to input their credentials again.

* **display top trending books** :
In the home page user can see the top 3 trending books that is based on number of followers. When user click to one of the book, they will be redirect to the current book page.

* **display user favorite books** :

* **display user nearest library** :
This features let user know the nearest library (with its address) by matching the postcode of the library with some range to the user address

* **search a book by ISBN number**:

* **follow and unfollow books**:

* **give review and rating about the book**:

* **display user profile** :
The user will be able to see his info by going to his profile. The user can also see which library is the closest. 

* **send meet up request** :
The user is able to invite other users by entering their username and giving the meet up date and location. If the data is incorrect, for example a non existing username, an error message will become visible indicating this to the user. The meet up will be submitted once all the information is valid. 

* **accept/decline meet up request** :
The user will have a scrollable view of all the meet up requests, there will be the choice to accept or decline these requests. Once a meet up request is accepted, the page will refresh and show it in the list with all the accepted requests. If the user declines a meet up request, the request will just be removed from the list of meet up requests.

* **display upcoming meet up** :
All the accepted meet up request will be showed in chronological order in a scrollable view. Once the date is passed of a meet up, the meet up will be removed from the list.
