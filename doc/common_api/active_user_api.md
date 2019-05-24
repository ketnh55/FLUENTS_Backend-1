# Active user api

| attribute | value |
|-----------|-------|
| version   | 1.0   |
| creator   | ket2.nguyen.huu@gmail.com |
| created   | 2019-05-23 |
| updater   | 
| updated   |  |

## 1. Overview 

- A API allow active account from mail.
- Invalidate token after active user.

## 2. Endpoint

- */api/v1/active_user_api*

## 3. Method

- POST

## 4.Input 

name  | description| format | type | range | required
--- | ---| ---| ---|---|---
password|password|-|string|> 6 character|true

## 5.Example API Call

- Method : POST

- Header: 
    - X-Requested-With: XMLHttpRequest
    
    - Authorization : '"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjI0LCJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL3YxL3VzZXJfbG9naW5fYXBpIiwiaWF0IjoxNTUzNDE5OTM2LCJleHAiOjE1NTM0MjM1MzYsIm5iZiI6MTU1MzQxOTkzNiwianRpIjoib1hDOE41UW12cEtBNUtCZSJ9.GPau62lF2scfzub6cHmlQx40yxjxTlmSKs1W7G9F1ws',        
        
- Url : *http://domain_name/api/v1/active_user_api/*

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

- Step 2 : Check if user already active or not
    + Yes: Return error
    + No: Go to step 3

- Step 3: Active user, invalidate jwt and return result

## 8. Output

- Active user success or fail  

## 9. Example Response 

- HTTP Code : 200

- JSON response 
    
    + Success:
    
    ```
    {
        "message": "Active user success"
    }
    ```
    
    + Failed: 
    
    ```
    {
        "error": "token_expired"
        //"error": "User is deactivated"
        //"deactive": "success"
    }
    ```

## 10. Exception

- Return error message if jwt token is not valid 