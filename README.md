# Anagram finder

This is the backend repo for the Anagram finder webapp  
**URLs**:  
* **Hosting Terminated**  
**Front end repo**: https://github.com/Tyks23/anagrams-front  

## About Anagram finder

The anagram finder is a webapp created with a React + Laravel + PostgreSQL stack. It allows a registered user to upload a wordbbase to the webapp and use the provided wordbase to find anagrams.  
To submit a wordbase, you must format a txt document so that it contains one word per line, like so:  
![php.ini image](https://i.imgur.com/nr7stjj.png)  
A good example of a document containing a large wordbase is: http://www.eki.ee/tarkvara/wordlist/lemmad2013.txt  
**Notice**: Due to the server being currently hosted on a feeble raspberry pi, large files may overload the the hardware. Therefore it is recommended to not exceed 1000 words per wordbase upload while using the web app. Local dev environment has successfully uploaded files containing upto 200 000 words. 
## Dev environment setup

### Backend 

The webapp requires the following to be installed on the system before it can be started:  
PHP - https://www.php.net/downloads.php  
Composer - https://getcomposer.org/download/  
PostgreSQL - https://www.postgresql.org/download/  


#### Laravel setup
After confirming that you gave PHP and Composer installed on your system you will need to follow these steps:  
1) Clone repo
2) Navigate to anagram-back directory with CLI
3) Enter command "composer install"
4) Enter command "php artisan serve"  
  
Backend application is now running on port 8000(can be configured in .env).


#### Database setup

After confirming that you have PostgreSQL installed on the system you will need to follow these steps:  
1) Uncomment 'extension=pdo_pgsql' and 'extension=pgsql' in the php.ini file:  
![php.ini image](https://i.imgur.com/3a2kQIb.png)
2) Create a postgre database named 'anagrams'  
3) Change the variables in the .env(example of .env is included with the name .env.example) to reflect the properties of your database  
![.env image](https://i.imgur.com/eca34Tt.png)
4) Navigate to anagrams-back directory in CLI
5) Enter command "php artisan migrate:refresh" to generate database  
  
Database is now populated with tables and ready to use.

#### Testing

After successfully setting up the project, you may run tests.  
To do this follow these steps:  
1) Navigate to anagram-back directory in CLI
2) Enter command "php artisan test"  
  
This will run Feature and Unit test and display the results in the CLI.

## Endpoints
### User
**Registration** -> [URL]/api/register -> POST
```json
{
    "email": "[email]", 
    "password": "[password]" 
    "name":"[name]"
}
```  
Returns  
```json
{
    "token":"[token]",
    "user_id":"[id]"
}
```  
Used to register new users to the database and returns the authentication token and user_id to the browser.  
  
**Login** -> [URL]/api/login -> POST
```json
{
    "email": "[email]", 
    "password": "[password]"
}
```  
Returns  
```json
{
    "token":"[token]",
    "user_id":"[id]"
}
```  
Used to login existing users and returns the authentication token and user_id to the browser.  
  
### Word
Requests must contain the "Authorization": "Bearer [token]" header.  
If requests are made without or invalid token API returns  
Status 401
```json
{
    "message": "Unauthenticated."
}
``` 
  
**Upload Wordbase** -> [URL]/api/uploadWordbase -> POST
```json
{
    "file": "[file.txt]", 
    "user_id": "[id]"
}
```  
Used to upload a text document containing a wordbase to the applications database. It goes through validation middlewear and the request must be authenticated.  

**Find Anagrams** -> [URL]/api/findAnagrams -> POST
```json
{
    "word": "[word]", 
    "user_id": "[id]"
}
```  
Returns  
```json
[
    {"word":"[word]"},
    {"word":"[word2]"}
]
```  
Used to find anagrams from the wordbases the user has provided for the word the user has provided. It goes through validation middlewear and the request must be authenticated.  


