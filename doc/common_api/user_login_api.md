# User login api   

| attribute | value |
|-----------|-------|
| version   | 1.0   |
| creator   | ket2.nguyen.huu@gmail.com |
| created   | 2019-03-24 |
| updater   | 
| updated   |  |

## 1. Overview 

- A API allow user login to system by SNS.

## 2. Endpoint

- */api/v1/user_login_api*

## 3. Method

- POST

## 4.Input 

name  | description| format | type | range | required
--- | ---| ---| ---|---|---
- |- |- |- |- |- 


## 5.Example API Call

- Method : POST

- Header: 
    - X-Requested-With: XMLHttpRequest
    
    - Authorization : '"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjI0LCJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL3YxL3VzZXJfbG9naW5fYXBpIiwiaWF0IjoxNTUzNDE5OTM2LCJleHAiOjE1NTM0MjM1MzYsIm5iZiI6MTU1MzQxOTkzNiwianRpIjoib1hDOE41UW12cEtBNUtCZSJ9.GPau62lF2scfzub6cHmlQx40yxjxTlmSKs1W7G9F1ws',        
        
- Url : *http://domain_name/api/v1/user_login_api/*

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

- Step 2 : return the result allow access or not

## 8. Output

- Allow user access or not  

## 9. Example Response 

- HTTP Code : 200

- JSON response 
    
    + Success:
    
    ```
    {
    "allow_access": "true"
    "user": {
                "id": 24,
                "username": "1111",
                "full_name": null,
                "date_of_birth": null,
                "gender": null,
                "country": null,
                "location": null,
                "email": "abcdfdsafdsafd@xyz.com456rrrr4fhtrthye556",
                "avatar": null,
                "description": null,
                "created_at": "2019-03-20 17:12:57",
                "updated_at": "2019-03-20 17:12:57",
                "deleted_at": null,
                "last_login": null,
                "ip": null,
                "is_active": null,
                "user_type": 1
            }            
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