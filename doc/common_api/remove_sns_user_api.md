# Remove sns user api   

| attribute | value |
|-----------|-------|
| version   | 1.0   |
| creator   | ket2.nguyen.huu@gmail.com |
| created   | 2019-04-15 |
| updater   | 
| updated   |  |

## 1. Overview 

- An API allow user remove the link to sns account
- The returned API will indicate the action success or not

## 2. Endpoint

- */api/v1/remove_sns_acc_api*

## 3. Method

- POST

## 4.Input 

name  | description| format | type | range | required
--- | ---| ---| ---|---|---
sns_account_id|sns_account_id|-|string|-|true
social_type|1:facebook, 2:twitter, 3:instagram, 4:youtube|-|int|from 1 to 4|true

## 5.Example API Call

- Method : POST

- Header: X-Requested-With: XMLHttpRequest
- Authorization : '"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjI0LCJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL3YxL3VzZXJfbG9naW5fYXBpIiwiaWF0IjoxNTUzNDE5OTM2LCJleHAiOjE1NTM0MjM1MzYsIm5iZiI6MTU1MzQxOTkzNiwianRpIjoib1hDOE41UW12cEtBNUtCZSJ9.GPau62lF2scfzub6cHmlQx40yxjxTlmSKs1W7G9F1ws',

- Body: 
    - POST param
        - social_type: '2',
        - sns_access_token: '3xyzljfdsajldsjaf2354%fdajasdf.fdaljkfda',
        
- Url : *http://domain_name/api/v1/remove_sns_acc_api/*

## 6. Diagram 

- N/A

## 7. Action

- Step 1 : Validate input parameter
    + If not valid, return error message corresponding to each of parameter
    + If valid, go to step 2          
    ↓
- Step 2: Check user active or not    
    ↓
 
- Step 3 : Check if the sns user belong to requested user or not
   + No: Return error
             
   + Yes: Go to step 4
 
    
- Step 4 : Remove the sns user (soft-delte)

- Step 5 : return json remove success

## 8. Output

- Remove success or not

## 9. Example Response 

- HTTP Code : 200

- JSON response 
    
    + Success:
    
    ```
    {
        "remove" => "success"
    }
    ```
    
    + Failed: 
    
    ```
    {
        "error": "token_expired"
    }
    ```

## 10. Exception

- Return error message if parameter is not valid 
