# User Update Information api   

| attribute | value |
|-----------|-------|
| version   | 1.0   |
| creator   | ket2.nguyen.huu@gmail.com |
| created   | 2019-03-24 |
| updater   | 
| updated   |  |

## 1. Overview 

- An API allow user update information.

## 2. Endpoint

- */api/v1/user_update_info_api*

## 3. Method

- POST

## 4.Input 

name  | description| format | type | range | required
--- | ---| ---| ---|---|---
date_of_birth|date of birth of user|-|string|-|false
country|country of user|-|string|-|false 
gender|gender|-|string|-|false
location|location|-|string|-|false 
email|email|-|string|-|false
avatar|avatar|-|string|-|false
description|description|-|string|-|false
user_type|user type|-|string|1 (influencer) or 2 (marketer)|false  
username|username|-|string|-|false
avatar|avatar user|-|string|-|false
categories[]|categories of user|-|array|-|false

## 5.Example API Call

- Method : POST

- Header: 

    - X-Requested-With: XMLHttpRequest
        
    - Authorization : '"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjI0LCJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL3YxL3VzZXJfbG9naW5fYXBpIiwiaWF0IjoxNTUzNDE5OTM2LCJleHAiOjE1NTM0MjM1MzYsIm5iZiI6MTU1MzQxOTkzNiwianRpIjoib1hDOE41UW12cEtBNUtCZSJ9.GPau62lF2scfzub6cHmlQx40yxjxTlmSKs1W7G9F1ws',        
- Body:
    - POST param
        - date_of_birth : '2000-11-12' //Y-M-d (required correct format)
        - country: 'vietnam',
        - gender: 'male',
        - location: 'hanoi',
        - email: 'cuong-nguyen@gmail.com',
        - description: 'nothing is impossible',
        - avatar: 'https://twitter.com/Cuong_dep_trai8962580.png',
        - username: 'thangdeptrai'
        - categories[]: '1'
        - categories[]: '2'
        - link: 'https://twitter.com/Cuong_dep_trai89625808'
        - category: 'https://twitter.com/Cuong_dep_trai89625808'
        - user_type: '1'        
- Url : *http://domain_name/api/v1/user_update_info_api/*

## 6. Diagram 

- N/A

## 7. Action

- Step 1 : Validate jwt token  parameter
    + If not valid, return error message
        + Error message type: 
            + Lack jwt authentication in request
    ↓       + Jwt token expired
            + Jwt token is not valid
            + Jwt user not found

- Step 2 : update information of user

## 8. Output

- Update success or not 

## 9. Example Response 

- HTTP Code : 200

- JSON response 
    
    + Success:
    
    ```
    {
        "update_user_info": "success"
    }    
    ```
    
    + Failed: 
    
    ```
    {
        "error": "token_expired"
        //"error": "token_invalid"
        //"error": "user_not_found"
    }
    ```

## 10. Exception

- Return error message if jwt token is not valid
- Return error message if input data is not correct 