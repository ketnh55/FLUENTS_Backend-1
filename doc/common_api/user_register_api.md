# User Register api   

| attribute | value |
|-----------|-------|
| version   | 1.0   |
| creator   | ket2.nguyen.huu@gmail.com |
| created   | 2019-03-24 |
| updater   | 
| updated   |  |

## 1. Overview 

- An API allow user register to system by SNS.
- The returned API will indicate the user was registered before or not

## 2. Endpoint

- */api/v1/user_register_api*

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
secret_token|secret token of twitter|-|string|-|false

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
        - secret_token: '111111111131313131'
        
- Url : *http://domain_name/api/v1/user_register_api/*

## 6. Diagram 

- N/A

## 7. Action

- Step 1 : Validate input parameter
    + If not valid, return error message corresponding to each of parameter
    + If valid, go to step 2          
    ↓
    
- Step 2 : Check if user email exists on DB or not
   + Yes: 
        + Check if user filled the field influencer/marketer or not
            + Yes: allow user login and go to step 4 (not require user to update info - required_update_info = 0)
            + No: 
                + Allow login and require client side to allow user fill profile information (required_update_info = 1)
                + Go to step 4 
   + No: go to step 3
 
    
- Step 3 : Create new user base on input information and require client side to allow user fill profile (require_update_info = 1)

- Step 4 : Generate jwt access token for user 

- Step 5 : return json respond with user info and jwt access token

## 8. Output

- Json message is sent to client  

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
                    "secret_token": "null"
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
                    "secret_token": "131313131313131313"
                }
            ],
            "categories": [
                {
                    "id": 1,
                    "category_name": "sport",
                    "description": "sportify"
                },
                {
                    "id": 2,
                    "category_name": "drinking",
                    "description": "cocacola"
                },
                {
                    "id": 3,
                    "category_name": "music",
                    "description": "music"
                }
            ]
        }
    }
    ```
    
    + Failed: 
    
    ```
    {
        {
            "message": "The given data was invalid.",
            "errors": {
                "email": [
                    "The email has already been taken."
                ]
            }
        }
    }
    ```

## 10. Exception

- Return error message if parameter is not valid 
