Introduction
The website designed for this project successfully fulfils all user requirements outlined in the project specification. Bootstrap 5  and UIkit  frameworks were used to aid development as both integrate well with each other. Bootstrap 5 was mainly used for website layout and widget design, while UI Toollkit was used to style tables and card widgets. The remainder of this report outlines how these requirements are fulfilled. However due to the space constraints of this report, please refer to source code comments and video submission for a full description of how all functionality is achieved. 
Database Design
![image](https://github.com/user-attachments/assets/b9dae1ba-0ac4-422c-b845-3112c6b1bc91)


 
Figure 1: Database ER Diagram

Figure 1 above shows the database design and associated relationships. Genre has been normalised from the albums table and linked through the album_subgenres table creating a many-to-many relationship which allows a song to have many subgenres. Genre is also joined to the albums table via genre.id enabling a main genre to be added to each album.  
Account type has been normalised from account, with 3 different account types, user, moderator, and admin. Var binary datatype is used to store ‘password’ as this data is salted and hashed before being stored. Favourites creates a many to many relationship between account and albums, allowing a user to have many favourites and a song to be favourited by many different users. User_reviews creates a many to many relationship between account and albums, allowing an album to have many reviews and a user to leave reviews on many different songs. 
Artists could have been normalised from the albums table, however I made the decision that this was unnecessary for the scope of this project. This is because the total number of records in the songs table will only ever be 500, the artist’s name is extremely unlikely to change, and when the database is updated each year, all data will be truncated and new data inserted automatically via insertion scripts (see File Processing folder in submission files). Therefore, normalisation of this data would have minimal performance benefits. It is however good practice and normalising artists from the albums table could be a future improvement. 
I created the CreateUserAccount and CheckLoginDetails stored procedures to aid with user account creation and to check login details at login.
CreateUserAccount takes data which has been validated client-side during sign up and creates a new record in the account table. Before insertion it first salts and hashes the password data and will fail the insertion if the username chosen by the user already exists in the database, therefore preventing account duplication which would cause issues at login. If this occurs, php logic in authenticate.php will tell the user that the username already exists and ask them to try again with a different username. 
CheckLoginDetails takes data validated at log-in and checks this data against existing records in the database. If an account with the username exists, it grabs the salt from the stored password and uses this to salt and hash the password passed in at login. If this is a match, it will return the row, allowing login to proceed. If either the password or username are incorrect, the user is navigated back to the login page and a message is displayed asking the user to check their details and try again. 
Please see Appendix for full stored procedure code.

Data Processing
Files: ProjectSubmission/FileProcessing
Input CSV & Process Code: album_list.csv, DataClean.java
Output CSV: cleaned_data.csv, cleaned_genres.csv. (Also artists.csv, genres_unprocessed.csv, however these were only used for diagnosing data integrity problems).

I used Java to process and clean the dataset as it also offers good file reading and writing functionality. The first stage of data processing was to find and replace all ‘,’ with ‘-‘  within excel to allow the file reader to parse the data on ‘,’. 
I passed album_list.csv into processFile(file) method to remove unwanted characters from the data set (contained within the array ‘banned’), creating cleaned_data.csv. I then passed cleaned_data.csv into createGenreList(file) to create a separate file storing all genres and subgenres, allowing for easier insertion into the genre table. However, when checking data integrity following the insert, I found there was more rows in the table than there were genres. This was because the genre list contained some artist names which were not removed by processfile(). I created the removeArtists((File file, ArrayList<String> list) method and called this within createGenreList(file) to solve this issue, producing cleaned_genres.csv.
To enhance the data set I connected to the Wiki API  to get the wiki url’s of all album images. Please see wikiapi.php file within the FileProcessing folder. This pulled the image URL’s for approximately 400 albums, with the remaining 100 being gathered manually.
runonce.php inserts data into the database in the following sequence: 
1.	All genres are inserted into the genre table from cleaned_genres.csv data source. 
2.	All albums are then inserted into the album table from cleaned_data.csv data source. 
3.	All album subgenres are added to album_subgenre table and linked to correct songs.
Due to the space constraints of this report, please refer to the FileProcessing folder for further information, where all code is fully commented. 
File: ProjectSubmission/FileProcessing/runonce.php.

Website Design
Requirement 1:
When a user first navigates to the website, they are automatically assigned the status of guest ($_SESSION[‘account_type=0’]). This allows the user to browse the website as a guest, viewing specific album info and search by keyword. It does not allow the user to favourite albums, leave a review or access the ‘My Account’ page.
The user can create an account by navigating to the ‘Sign Up’ page and completing the sign-up form. This form uses client-side JavaScript validation and passes this data to process.php, which in turn calls CreateUserAccount. See ValidateEmail() on line 93 and  $('#createaccount').click(function() on line 103 of signup.php within website folder.  
If the account creation is successful, the user receives a success message and is navigated to the log in form. If the account creation failed, the user is advised to check their details and try again. 
Once the user enters log in details, authenticate.php queries the database calling CheckLoginDetails() and, if an account exists, checks and sets user account type to $_SESSION[‘account_type=1’] for normal user account, and $_SESSION[‘account_type=3’] for an admin account. 
Once logged in, registered user accounts able to favourite albums, submit album reviews for approval, and access the ‘My Account’ page where they can view a list of their favourite albums.
If an admin account logs in, they have all of the above functionality, however the ‘Admin Dashboard’ page will display reviews that require approval/rejection. Here the administrator can approve or reject reviews accordingly. 

Requirement 2: 
This functionality has been achieved for all users. When on the home page (index.php) all users can browse the full list of albums ordered by rank. Upon clicking on any album, the user is linked to corresponding information on albuminfo.php. 
albuminfo.php makes a GET request the API to get information for that album, passing the album ID as the query parameter. 

Requirement 3: 
Using the search bar in the navigation pane, users can search by artist name, album name or genre. On clicking the search button, the home page (index.php) is refreshed and an API GET request is made, passing the user search criteria as the query parameter. This is a wide and flexible search and will return results where the search term appears anywhere in the song name, artist name or genre.  The code that achieves this functionality can be viewed in ProjectSubmission/Projectfiles/website/index.php and ProjectSubmission/ Projectfiles/api/api.php
Requirement 4: 
Users that are not registered or logged in cannot leave a review, however they can see reviews that have been left by other registered users. All registered users can add an album review on the albuminfo.php page when logged in. This review is then submitted to the database by ajax post request, allowing the form to be refreshed and the data posted without navigating away from the albuminfo page. When posted, the review is automatically given an approval status of ‘FALSE’ and will not be displayed on the website until an admin approves it. Client-side JavaScript validation ensures that users cannot leave an empty review, or a review consisting of more than 250 characters. 


Requirement 5: 
Admin accounts can approve reviews on the ‘Admin Dashboard’ page when logged in. When the approve button is clicked, a post request is sent to approvereview.php which updates the review approval status to ’TRUE’, and the review will now be visible on the albuminfo page. If a review is rejected, rejectreview.php is called, deleting the review from the review table. 
Requirement 6: 
User input is subject to client-side JavaScript validation. During sign up, ValidateEmail() first checks if the email address supplied is valid, while  $('#createaccount').click(function() checks additional user input for length parameters.  
To address potential SQL injection attacks, all user input is prepared in a prepared statement before being querying the database. 

API
While not a specific user requirement outlined in the project specification, I exposed the database as an API to allow the data to be used by others who have the API endpoint. (http://nproctor03.webhosting6.eeecs.qub.ac.uk/ProjectFiles/api/api.php).
The API has the following methods:

GET: 
Parameter: all
Returns: JSON file containing Name, Rank, Year, Artist Name, Genre, and Image URL of all songs in the database. 

Parameter: id(int)
Returns: JSON file containing Name, Rank, Year, Artist Name, Genre, Subgenres and Image URL of a song with a specific id. 

Parameter: query(string)
Returns: JSON file containing Name, Rank, Year, Artist Name, Genre, and Image URL of all songs which match the query.  

Parameter: review(int). 
Returns: JSON file containing rating, review, date created and username of the 10 most recent reviews based on album id. (ID being the value passed in by review parameter). 


POST:
Parameter: postreview
Returns: Posts review to the database awaiting admin approval. 
