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
    [
        {
            "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImlzcyI6Imh0dHA6Ly8zNS4yMzYuNjYuOTUvYXBpL3YxL3VzZXJfbG9naW5fYXBpIiwiaWF0IjoxNTUzMTgwNjA3LCJleHAiOjE1NTMxODQyMDcsIm5iZiI6MTU1MzE4MDYwNywianRpIjoiRkhtQXZSTkdBQmRiWE9wMiJ9.gl0nV0ZOJvQgLpzl2KJYoWHzAZRqOO5qFmv2T66FK28"
        },
        {
            "user": {
                "id": 2,
                "username": "1111",
                "full_name": null,
                "date_of_birth": null,
                "gender": null,
                "country": null,
                "location": null,
                "email": "abcdfdsafdsafd@xyz.com456rrrr4fhtrthye",
                "avatar": null,
                "description": null,
                "created_at": "2019-03-21 15:03:27",
                "updated_at": "2019-03-21 15:03:27",
                "deleted_at": null,
                "last_login": null,
                "ip": null,
                "is_active": null,
                "user_type": "1",
                "require_update_info" : "1"
                "user_socials": [
                    {
                        "id": 2,
                        "link": "https://laravel.com/docs/5.8/eloquent-relationships#one-to-many",
                        "email": "abcdfdsafdsafd@xyz.com456rrrr4fhtrthye",
                        "created_at": "2019-03-21 15:03:27",
                        "updated_at": "2019-03-21 15:03:27",
                        "deleted_at": null,
                        "social_type": "3",
                        "sns_access_token": null,
                        "user_id": "2",
                        "extra_data": null,
                        "flatform_id": "111111111111111"
                    }
                ]
            }
        }
    ]
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
