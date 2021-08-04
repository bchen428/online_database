# online_database
A simple frontend webpage that allows for interacting with a MYSQL database after a simple login. Uses a mixture of HTML, CSS, JS, PHP (and by extension some MYSQL for querying/editing). Displays information in a table that updates (via AJAX, so really just loading a whole new table) based on filter parameters / changes made.

Note that the line:
```$conn = new mysqli('SOMEHOST','SOMEUSER','SOMEPASS','SOMETABLE');```
Needs to be edited for your specific database.

Obviously, the code currently is designed for displaying/editing the information from our specific database and thus would need to be edited to fit whatever project you may want to use it for.

For the opensrcdir.php, exploredir.php, and readfile.php files, it should be noted that they are specifically structured for how file storage on our system is conducted. Again, significant editing will probably be necessary to customize for other usage.

# Testing
Unfortunately, as our database is private and contains proprietary information, no example will be provided.
