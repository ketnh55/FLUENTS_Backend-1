# Deactive user api

| attribute | value |
|-----------|-------|
| version   | 1.0   |
| creator   | ket2.nguyen.huu@gmail.com |
| created   | 2019-05-20 |
| updater   | 
| updated   |  |

## 1. Overview 

- A API allow user create account.

## 2. Endpoint

- */api/v1/user_register_email_api*

## 3. Method

- GET

## 4.Input 

name  | description| format | type | range | required
--- | ---| ---| ---|---|---
email|email of user|-|string|-|true 
password|password|-|string|> 8 character|true

## 5.Example API Call

- Method : POST

- Header: 
    - X-Requested-With: XMLHttpRequest
                    
- Url : *http://domain_name/api/v1/user_register_email_api/*

## 6. Diagram 

- N/A

## 7. Action

- Step 1 : Check if input data is valid or not

- Step 2 : Check if email was used by another user or not
    + Yes: return error

- Step 3: Save user with username password to DB and mark as not active user

## 8. Output

- Create user success or not 

## 9. Example Response 

- HTTP Code : 200

- JSON response 
    
    + Success:
    
    ```
    {
        "status": "success"
    }
    ```
    
    + Failed: 
    
    ```
    {
        "error": "email was linked to other account"
    }
    ```

## 10. Exception

- N/A