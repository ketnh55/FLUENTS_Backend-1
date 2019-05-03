# mobile_backend api
API change log
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