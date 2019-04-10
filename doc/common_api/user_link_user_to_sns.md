# User Register message api   

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
- Step 3: Check if user account was linked to the same sns type before
    + If yes, return error to client 
- Step 4 : Check if sns accoutn was linked to another user account
   + Yes: Return error to client              
- Step 4 : Create new new sns accoutn and link to user account

- Step 5 : Save to DB and return success

## 8. Output

- Request result and the user info (inlcude linkned sns)

## 9. Example Response 

- HTTP Code : 200

- JSON response 
    
    + Success:
    
    ```
    {
        "link_to_sns": "success",
        "user": {
            "id": 56,
            "username": "k54353",
            "full_name": null,
            "date_of_birth": null,
            "gender": null,
            "country": null,
            "location": null,
            "email": "abcd@xyz.com",
            "avatar": "http://www.hyperdia.com/en/",
            "description": null,
            "created_at": "2019-04-10 14:40:44",
            "updated_at": "2019-04-10 14:40:44",
            "deleted_at": null,
            "last_login": null,
            "ip": null,
            "is_active": 1,
            "user_type": null,
            "category": null,
            "user_socials": [
                {
                    "id": 36,
                    "link": "https://github.com/ketnh55/influencer_api/blob/master/doc/common_api/user_get_user_info.md",
                    "email": "abcd@xyz.com",
                    "created_at": "2019-04-10 14:40:44",
                    "updated_at": "2019-04-10 14:40:44",
                    "deleted_at": null,
                    "social_type": 1,
                    "sns_access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjQ4LCJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL3YxL3VzZXJfcmVnaXN0ZXJfYXBpIiwiaWF0IjoxNTU0MjE4ODIxLCJleHAiOjE1NTQ1Nzg4MjEsIm5iZiI6MTU1NDIxODgyMSwianRpIjoiMEpCNFBFMTZ5RGIxZ29iZiJ9.c3xi0Q5vpKDzMVMdBUhVlFD_VHCiFHe-P9nIjhRhqdY",
                    "user_id": 56,
                    "extra_data": null,
                    "platform_id": "242354255553332",
                    "avatar": "http://www.hyperdia.com/en/",
                    "username": "k54353"
                },
                {
                    "id": 37,
                    "link": null,
                    "email": "abcd@xyz.com",
                    "created_at": "2019-04-10 14:41:26",
                    "updated_at": "2019-04-10 14:41:26",
                    "deleted_at": null,
                    "social_type": 4,
                    "sns_access_token": null,
                    "user_id": 56,
                    "extra_data": null,
                    "platform_id": "2423554564",
                    "avatar": "http://www.hyperdia.com/en/",
                    "username": "kết"
                },
                {
                    "id": 38,
                    "link": null,
                    "email": "abcd@xyz.com",
                    "created_at": "2019-04-10 14:42:07",
                    "updated_at": "2019-04-10 14:42:07",
                    "deleted_at": null,
                    "social_type": 3,
                    "sns_access_token": null,
                    "user_id": 56,
                    "extra_data": null,
                    "platform_id": "242355456433",
                    "avatar": "http://www.hyperdia.com/en/",
                    "username": "kết"
                }
            ]
        }
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
