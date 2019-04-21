# Get sns info api 

| attribute | value |
|-----------|-------|
| version   | 1.0   |
| creator   | ket2.nguyen.huu@gmail.com |
| created   | 2019-04-21 |
| updater   | 
| updated   |  |

## 1. Overview 

- A API allow front end get sns info (like, comments, posts, ...) for indicated user

## 2. Endpoint

- */api/v1/get_sns_info_api*

## 3. Method

- GET

## 4.Input 

name  | description| format | type | range | required
--- | ---| ---| ---|---|---
sns_account_id|sns_account_id|-|string|-|true
social_type|1:facebook, 2:twitter, 3:instagram, 4:youtube|-|int|from 1 to 4|true



## 5.Example API Call

- Method : GET

- Header: 
    - X-Requested-With: XMLHttpRequest
    
    - Authorization : '"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjI0LCJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL3YxL3VzZXJfbG9naW5fYXBpIiwiaWF0IjoxNTUzNDE5OTM2LCJleHAiOjE1NTM0MjM1MzYsIm5iZiI6MTU1MzQxOTkzNiwianRpIjoib1hDOE41UW12cEtBNUtCZSJ9.GPau62lF2scfzub6cHmlQx40yxjxTlmSKs1W7G9F1ws',        
- Body: 
    - GET param: N/A     
- Url : *http://domain_name/api/v1/get_sns_info_api/*

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

- Step 2 : return the array of category

## 8. Output

- Return sns info for input user

## 9. Example Response 

- HTTP Code : 200

- JSON response 
    
    + Success:
    
    ```
    {
        "info": [
            {
                "id": "2131685551",
                "comments": 0,
                "followed_by": 96,
                "follows": 256,
                "full_name": "Hoang Thang",
                "likes": 0,
                "platform": "instagram",
                "posts": 0,
                "profile_picture": "https://scontent.cdninstagram.com/vp/66c30d44705f5d75f93198fedf152cf8/5D3A5EA6/t51.2885-19/11269191_1587122258225285_939115658_a.jpg?_nc_ht=scontent.cdninstagram.com",
                "user_name": "hoang_van_thang"
            }
        ]
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