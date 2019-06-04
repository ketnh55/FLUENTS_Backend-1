# Request deactive user api

| attribute | value |
|-----------|-------|
| version   | 1.0   |
| creator   | ket2.nguyen.huu@gmail.com |
| created   | 2019-05-24|
| updater   | 
| updated   |  |

## 1. Overview 

- A API allow client request send mail to user to de-active user

## 2. Endpoint

- */api/v1/request_deactive_user_api*

## 3. Method

- GET

## 4.Input 

name  | description| format | type | range | required
--- | ---| ---| ---|---|---


## 5.Example API Call

- Method : GET

- Header: 
    - X-Requested-With: XMLHttpRequest                
        
- Url : *http://domain_name/api/v1/request_deactive_user_api/*

## 6. Diagram 

- N/A

## 7. Action

- Step 1 : Check if user already existed or not
    + No: Return error
    + Yes: Go to step 2

- Step 2: Send email to user

## 8. Output

- Email was sent to user

## 9. Example Response 

- HTTP Code : 200

- JSON response 
    
    + Success:
    
    ```
    {
        "message": "success"
    }
    ```
    
    + Failed: 
    
    ```
    {
        "error": "user is not existed"
    }
    ```

## 10. Exception

- N/A