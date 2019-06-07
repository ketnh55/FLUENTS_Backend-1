# Get interest api   

| attribute | value |
|-----------|-------|
| version   | 1.0   |
| creator   | ket2.nguyen.huu@gmail.com |
| created   | 2019-04-10 |
| updater   | 
| updated   |  |

## 1. Overview 

- A API allow front end get interest from DB

## 2. Endpoint

- */api/v1/get_interest_api*

## 3. Method

- GET

## 4.Input 

name  | description| format | type | range | required
--- | ---| ---| ---|---|---


## 5.Example API Call

- Method : GET

- Header: 
    - X-Requested-With: XMLHttpRequest
    
    - Authorization : '"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjI0LCJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL3YxL3VzZXJfbG9naW5fYXBpIiwiaWF0IjoxNTUzNDE5OTM2LCJleHAiOjE1NTM0MjM1MzYsIm5iZiI6MTU1MzQxOTkzNiwianRpIjoib1hDOE41UW12cEtBNUtCZSJ9.GPau62lF2scfzub6cHmlQx40yxjxTlmSKs1W7G9F1ws',        
        
- Url : *http://domain_name/api/v1/get_interest_api/*

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

- Step 2 : return the array of interest

## 8. Output

- Return array of interest or error

## 9. Example Response 

- HTTP Code : 200

- JSON response 
    
    + Success:
    
    ```
    {
        "interest": [
            {
                "id": 1,
                "interest_name": "sport",
                "description": "sports"
            },
            {
                "id": 2,
                "interest_name": "shopping",
                "description": "shopping"
            },
            {
                "id": 3,
                "interest_name": "music",
                "description": "music"
            },
            {
                "id": 4,
                "interest_name": "manga",
                "description": "manga"
            },
            {
                "id": 5,
                "interest_name": "dragon ball",
                "description": "dragon ball"
            },
            {
                "id": 6,
                "interest_name": "naruto",
                "description": "naruto"
            },
            {
                "id": 7,
                "interest_name": "one peach",
                "description": "one peach"
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