# User Login API

| attribute | value |
|-----------|-------|
| version   | 1.0   |
| creator   | ket2.nguyen.huu@gmail.com |
| created   | 2019-05-20 |
| updater   | 
| updated   |  |

## 1. Overview 

- A API allow user login by email.

## 2. Endpoint

- */api/v1/user_login_email_api*

## 3. Method

- POST

## 4.Input 

name  | description| format | type | range | required
--- | ---| ---| ---|---|---
email|email of user|-|string|-|true 
password|password|-|string|> 8 character|true

## 5.Example API Call

- Method : POST

- Header: 
    - X-Requested-With: XMLHttpRequest
                    
- Url : *http://domain_name/api/v1/user_login_email_api/*

## 6. Diagram 

- N/A

## 7. Action

- Step 1 : Check if email and password is correct or not
    + No: return login fail

- Step 2: Check if user is active or not
    + No: Return error
    + Yes: return jwt and user info 

## 8. Output

- Create user success or not 

## 9. Example Response 

- HTTP Code : 200

- JSON response 
    
    + Success:
    
    ```
    {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjExNSwiaXNzIjoiaHR0cDovL2FwaS5mbHVlbnRzLmFwcC9hcGkvdjEvdXNlcl9sb2dpbl9lbWFpbF9hcGkiLCJpYXQiOjE1NTgzNjMyNzksImV4cCI6MTU2MDc4MjQ3OSwibmJmIjoxNTU4MzYzMjc5LCJqdGkiOiJwRzFiYnNZVE4zMThGdzM2In0.HyJUyrvXV3Qlc_fz0nZKyl4SxFEf5UfZRsmUSOTbweY",
        "user": {
            "id": 115,
            "username": null,
            "full_name": null,
            "date_of_birth": null,
            "gender": null,
            "country": null,
            "location": null,
            "email": "sontn@fabbi.io123132",
            "avatar": null,
            "description": null,
            "last_login": null,
            "ip": null,
            "is_active": "1",
            "user_type": null,
            "require_update_info": "true",
            "user_socials": [],
            "interest": []
        }
    }
    ```
    
    + Failed: 
    
    ```
    {
        "error": "User is not active"
    }
    ```

## 10. Exception

- N/A