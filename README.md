# Anagram finder

This is the backend repo for the Anagram finder webapp  
**URL**: W.I.P  
**Front end repo**: https://github.com/Tyks23/anagrams-front  

## About Anagram finder

The anagram finder is a webapp created with a React + Laravel + PostgreSQL stack. It allows a registered user to upload a wordbbase to the webapp and use the provided wordbase to find anagrams.

## Dev environment setup

### Backend 

The webapp requires the following to be installed on the system before it can me started:  
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
1) Create a postgre database named 'anagrams'  
2) Change the variables in the .env(example of .env is included with the name .envExample) to reflect the properties of your database  
![.env image](https://i.imgur.com/eca34Tt.png)
3) Navigate to anagrams-back directory in CLI
4) Enter command "php artisan migrate:refresh" to generate database  
  
Database is no populated with tables and ready to use.

#### Testing

After successfully setting up the project you may run tests.  
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


