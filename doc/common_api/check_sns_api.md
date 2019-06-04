# Check sns api

| attribute | value |
|-----------|-------|
| version   | 1.0   |
| creator   | ket2.nguyen.huu@gmail.com |
| created   | 2019-05-26 |
| updater   | 
| updated   |  |

## 1. Overview 

- Check sns account can link to user or not

## 2. Endpoint

- */api/v1/check_sns_api*

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
        - sns_account_id: '89625808',
        - social_type: '2',
        
- Url : *http://domain_name/api/v1/check_sns_api/*

## 6. Diagram 

- N/A

## 7. Action

- Step 1 : Validate input parameter
    + If not valid, return error message corresponding to each of parameter
    + If valid, go to step 2          
    ↓   
- Step 2 : Check if user active or not
    + If not, return error to client
    ↓ 
- Step 3 : Check if sns accoutn was linked to another user account
   + Yes: Return error to client
   ↓              
- Step 4 : Return success

## 8. Output

- User can link to another sns or not

## 9. Example Response 

- HTTP Code : 200

- JSON response 
    
    + Success:
    
    ```
    {
        'message' => 'success'
    }
    ```

- HTTP Code : 413

- JSON response     
    + Failed: 
    
    ```
    {
        'error' => 'User is deactivated'
        //'error'=>'sns account was linked to other account'
    }
    ```

## 10. Exception

- Return error message if parameter is not valid 
