# Link to another sns api   

| attribute | value |
|-----------|-------|
| version   | 1.0   |
| creator   | ket2.nguyen.huu@gmail.com |
| created   | 2019-04-04 |
| updater   | 
| updated   |  |

## 1. Overview 

- An API allow user link to another SNS.

## 2. Endpoint

- */api/v1/link_user_to_sns_api*

## 3. Method

- POST

## 4.Input 

name  | description| format | type | range | required
--- | ---| ---| ---|---|---
email|email of user|-|string|-|false 
username|username|-|string|-|false
sns_account_id|sns_account_id|-|string|-|true
social_type|1:facebook, 2:twitter, 3:instagram, 4:youtube|-|int|from 1 to 4|true
sns_access_token|access token of sns|-|string|-|false
link|link to sns page|-|string|-|false
avatar|avatar of sns|-|string|-|false

## 5.Example API Call

- Method : POST

- Header: X-Requested-With: XMLHttpRequest

- Body: 
    - POST param
        - email : 'abcd_xyz@gmail.com',
        - username: 'kelvin',
        - sns_account_id: '89625808',
        - social_type: '2',
        - sns_access_token: '3xyzljfdsajldsjaf2354%fdajasdf.fdaljkfda',
        - link: 'https://twitter.com/Cuong_dep_trai89625808'
        - avatar: 'https://twitter.com/Cuong_dep_trai89625808.png'
        
- Url : *http://domain_name/api/v1/link_user_to_sns_api/*

## 6. Diagram 

- N/A

## 7. Action

- Step 1 : Validate input parameter
    + If not valid, return error message corresponding to each of parameter
    + If valid, go to step 2          
    ↓
    
- Step 2 : Check if user active or not
    + If not, return error to client 
- Step 3 : Check if sns accoutn was linked to another user account
   + Yes: Return error to client              
- Step 4 : Create new new sns accoutn and link to user account

- Step 5 : Save to DB and return success

## 8. Output

- Json message is sent to client  

## 9. Example Response 

- HTTP Code : 200

- JSON response 
    
    + Success:
    
    ```
    {
        "Link to sns": "Update success"
    }
    ```
    
    + Failed: 
    
    ```
    {
        'error' => 'User is deactivated'
        //'error'=>'Duplicate user sns'
        //'error'=>'user was existed'
    }
    ```

## 10. Exception

- Return error message if parameter is not valid 
