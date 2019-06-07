# Link user to sns account 

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
    ↓ 
- Step 3 : Check if sns accoutn was linked to another user account
   + Yes: Return error to client
   ↓              
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
        "user": {
            "id": 58,
            "username": "kết",
            "full_name": null,
            "date_of_birth": "1992-12-31 00:00:00",
            "gender": "Male",
            "country": null,
            "location": "Vietnam, Quan Hoa",
            "email": "abcd@xyz.com",
            "avatar": "http://www.hyperdia.com/en/",
            "description": "ugcihcigcicihchc8hv",
            "last_login": null,
            "ip": null,
            "is_active": 1,
            "user_type": null,
            "user_socials": [
                {
                    "id": 49,
                    "link": null,
                    "email": "abcd@xyz.com",
                    "created_at": "2019-04-17 17:22:40",
                    "social_type": 2,
                    "sns_access_token": null,
                    "user_id": 58,
                    "extra_data": null,
                    "platform_id": "24235",
                    "avatar": "http://www.hyperdia.com/en/",
                    "username": "kết"
                },
                {
                    "id": 50,
                    "link": null,
                    "email": "abcd@xyz.com",
                    "created_at": "2019-04-19 14:56:38",
                    "social_type": 2,
                    "sns_access_token": null,
                    "user_id": 58,
                    "extra_data": null,
                    "platform_id": "24235555",
                    "avatar": "http://www.hyperdia.com/en/",
                    "username": "kết"
                }
            ],
            "interest": [
                {
                    "id": 1,
                    "interest_name": "sport",
                    "description": "sportify"
                },
                {
                    "id": 2,
                    "interest_name": "drinking",
                    "description": "cocacola"
                },
                {
                    "id": 3,
                    "interest_name": "music",
                    "description": "music"
                }
            ]
            "profession": [
                {
                    "id": 1,
                    "profession_name": "sport",
                    "description": "sportify"
                },
                {
                    "id": 2,
                    "profession_name": "drinking",
                    "description": "cocacola"
                },
                {
                    "id": 3,
                    "profession_name": "music",
                    "description": "music"
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
