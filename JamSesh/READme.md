# JamSesh

An open source web application for music composition collaboration.
Currently optimized for Desktop/PC users, mobile platforms are yet to be supported.


### Instruction for XAMPP Users

Clone or download ZIP file to xampp/htdocs folder or any virtual host root folder

Navigate to localhost/phpmyadmin and log in, create a new database named JamSesh2 and import JamSesh/assets/sql/JamSesh2.sql.

Navigate to JamSesh/assets/php/db_conn.php, replace the DB_USERNAME and DB_PASSWORD with your own info.

Navigate to your host JamSesh folder and start JamSeshing!

### Home Page / Log-in Page

Users log in with email and password.
If not registered, users sign up with an email, username, and password. User will be redirected to user-profile page when signing up is completed.

If the user already has an account, log in with an registered email and password

### User Profile Page

On the left is user's info including Profile Picture, Display Name, User Name, and a Bio. 
"Edit Profile" button down below allows users to change your profile.

On the right is user's studios display, including user-owned studios, user-collaborating studios, and user-faorited studios. 
Click any studio listed to access studio page and configure or listen to the studio.

Click "New Studio" to create a new studio!


### Studio Page

In studio, the composition panel allows users to play, and upload an instrument recording to the studio. To add an instrument recording,
click "Add Instrument" button to name an instrument recording and upload the mp3 file.

The setting panel allows users to configure studio name, visibility, fork ability, description, genre, and add or remove collaborators.

### Search Page

The search page offers functionality for users to search studios that are public by name, genre, or instrument.



# Work log

Derek Li:
  Search page functionality and site styling.

Gabe Wild:
  Database functionality and schema.
  User profile page and Studio page functionality and site styling.


Virginia Barnes: 
  Database functionality and schema.
  User profile page and Studio page functionality and site styling.

Zehao Qin:
  Admin page functionality and styling.