# Upload image api

| attribute | value |
|-----------|-------|
| version   | 1.0   |
| creator   | ket2.nguyen.huu@gmail.com |
| created   | 2019-05-01 |
| updater   | 
| updated   |  |

## 1. Overview 

- A API allow uploading image to server.

## 2. Endpoint

- */api/v1/images/event/{file_name}*

## 3. Method

- POST

## 4.Input 

name  | description| format | type | range | required
--- | ---| ---| ---|---|---
image|the image to upload|jpg, png|binary|-|true

## 5.Example API Call

- Method : POST

- Header: 
    - X-Requested-With: XMLHttpRequest
    
    - Authorization : '"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjI0LCJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL3YxL3VzZXJfbG9naW5fYXBpIiwiaWF0IjoxNTUzNDE5OTM2LCJleHAiOjE1NTM0MjM1MzYsIm5iZiI6MTU1MzQxOTkzNiwianRpIjoib1hDOE41UW12cEtBNUtCZSJ9.GPau62lF2scfzub6cHmlQx40yxjxTlmSKs1W7G9F1ws',        
        
- Url : *http://domain_name//api/v1/images/event/{file_name}*

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

- Step 2 : Upload image to server and return image url (with the name was hashed)

## 8. Output

- Image url and upload success or not  

## 9. Example Response 

- HTTP Code : 200

- JSON response 
    
    + Success:
    
    ```
    {
        "status": {
            "code": 200,
            "message": "Success to upload image"
        },
        "data": {
            "filename": "5cc9ae0498d2e.png",
            "path": "http://127.0.0.1:8000/images/event/\\/5cc9ae0498d2e.png"
        }
    }
    ```
    
    + Failed: 
    
    ```
    {
        "error": "token_expired"
        //"error": "User is deactivated"
        //"deactive": "success"
    }
    ```

## 10. Exception

- Return error message if image is not in body request