# Get user info api   

| attribute | value |
|-----------|-------|
| version   | 1.0   |
| creator   | ket2.nguyen.huu@gmail.com |
| created   | 2019-04-04 |
| updater   | 
| updated   |  |

## 1. Overview 

- A API allow client get user info.

## 2. Endpoint

- */api/v1/get_user_info_api*

## 3. Method

- POST

## 4.Input 

name  | description| format | type | range | required
--- | ---| ---| ---|---|---


## 5.Example API Call

- Method : POST

- Header: 
    - X-Requested-With: XMLHttpRequest
    
    - Authorization : '"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjI0LCJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL3YxL3VzZXJfbG9naW5fYXBpIiwiaWF0IjoxNTUzNDE5OTM2LCJleHAiOjE1NTM0MjM1MzYsIm5iZiI6MTU1MzQxOTkzNiwianRpIjoib1hDOE41UW12cEtBNUtCZSJ9.GPau62lF2scfzub6cHmlQx40yxjxTlmSKs1W7G9F1ws',        
        
- Url : *http://domain_name/api/v1/get_user_info_api/*

## 6. Diagram 

- N/A

## 7. Action

- Step 1 : Validate jwt token  parameter
    + If not valid, return error message
        + Error message type: 
            + Lack jwt authentication in request
    ↓       + Jwt token expired
            + Jwt token is not valid
            + Jwt user not found

- Step 2 : return the result allow access or not

## 8. Output

- Allow user access or not  

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
        "error": "token_expired"
        //"error": "token_invalid"
        //"error": "user_not_found"
    }
    ```

## 10. Exception

- Return error message if jwt token is not valid 