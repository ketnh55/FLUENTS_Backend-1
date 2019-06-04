# Backend api
API change log
- 2019-05-26    
    - Add URL in mail for deactive api and user_update_info_api (when update email)
    - Add first_name, last_name to user_update_info_api
             
------------------------------------------------------------------------------------------------------------
- 2019-05-26    
    - Add api check_sns_api
    - Add flag requied_update_sns to user object
             
------------------------------------------------------------------------------------------------------------
- 2019-05-25    
    - Send email api register user by email
    - Add api send_reset_password_api
    - Add api reset_password_api
    - Send mail when deactive user
    - Add api request_deactive_user
             
------------------------------------------------------------------------------------------------------------
- 2019-05-20    
    - Add api register user by email and login user by email         
------------------------------------------------------------------------------------------------------------
- 2019-05-17    
    - Change date_time format for date_of_birth (user_update_info_api)         
        + Change from Y-m-d to m-d-Y
------------------------------------------------------------------------------------------------------------
- 2019-05-03
    - Fix bug update avatar impact to categories
    - Make consistency between get user info api and get sns info api 
        + Change full_name to username
        + Change platform to social_type
        + Change id to platform_id
        + Change profile_picture to avatar
------------------------------------------------------------------------------------------------------------
- 2019-04-30
    - Add api deactive user
    - Fix bug remove_sns_acc_api    
    - Add param 'secret_token' to api user_register_api
------------------------------------------------------------------------------------------------------------
- 2019-04-24
    - Add api get_sns_info_api (note: use data from Mongo DB so not too much data for testing)
    - Add api remove sns user api
    - Add logout api
    - Add category list in return of api user_login_api, user_register_api, user_info_api
    - About upload image, please use google api server (contact to Thang for more detail) 
------------------------------------------------------------------------------------------------------------