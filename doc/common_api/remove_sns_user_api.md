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
