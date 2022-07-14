# Сервис для обработки изображений

 - 1 Регистрация\Авторизация в системе
 - 2 Авторизированный пользователь может:
 - 2.1. Загрузить изображение для обработки
 - 2.2. Скачать обработанное изображение

# Endpoints
Name | Description
------------ | ------------
[Register]({{url}}/api/register)     | New User Registration
[Login]({{url}}/api/login)   | User authorization
[Images uploading]({{url}}/api/image/loading)   | Uploading images to a service for further processing
[Images downloading]({{url}}/api/image/downloading)   | Downloading selected processed images
[Stack images downloading]({{url}}/api/images_stack/downloading) | Downloading processed images from the selected stack (the stack is formed when accessing [Images downloading]({{url}}/api/image/loading)
    
# Register
This endpoint creates registers a new user in the system.

#### Header

Name            | Value 
----------------|------
**Content-Type**| application/json 
**Accept**| application/json 
    
#### Attributes

Name            | Type | Description | Example
----------------|------|------------ |--------
**name**| _string_ | Name new user| `"user1"`
**email**| _email_ | Email new user| `"user1@mail.ru"`
**password**| _password_ | Password new user| `"1234"`
**c_password**| _password_ | Repetition password new user| `"1234"`

##### cURL Example
```bash
$ curl -X POST {{url}}/api/register \
-H "Content-Type: application/json" \
-H "Accept: application/json" \
-d '{"name": "user1", "email": "user1@mail.ru", "password": 1111 , "c_password": 1111}'
```

##### Response Example
Success    
```bash
{
    "data": {
        "success": true,
        "message": "User register successfully.",
        "user": {
            "email": "user1@mail.ru",
            "token-type": "Bearer",
            "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5NmM0YWZhZi0xODFiLTRmYmYtYTc5NC0wOTUyMjNkN2NkNjUiLCJqdGkiOiI3YzU5YjhjNGQ4OTk5ZmMxYWQ3M2U1NTZiYzkwZjIyNGYxZDU0YmU5NTQ5ZWQzOTc0NzE3OTAwNTIzZmQxOTYxZWE0YmI5MDQ2ZDM2YjQ3OSIsImlhdCI6MTY1Nzc3Njk5My4yODg2NTksIm5iZiI6MTY1Nzc3Njk5My4yODg2NjEsImV4cCI6MTY4OTMxMjk5My4yODA5ODYsInN1YiI6IjMiLCJzY29wZXMiOltdfQ.BZGiOY6XqavNmnqmxPY5SE-XdSbzaTPRAhW81e5D6uED5G51efKS4_3Pfi0P25Dev6ndOl1YFpysZ3pKz6c7CQ9KpVY9B_5J0iToECfdSHl-xHICmqWj79M1j2tXrI4tgYwyZ4SPoMkcYmLuDOnJRzm_gHpaE9dDoAmbVJyuq0dTPD6Wbh1PU5WIIF9sXyxXTJe3Pf6Sl1GfcwTo15wDBAA6ksWYXchUVsDqQU382mI-BYmOo5Xq3Hx3BTYvTHDiSlcXZ0dE_kRBCF3CJ7-bGd2qPUw8SJfLW4FFuFkxz8eN-_TYPPuwoz6AbsfMl5b2pNvt_m6de3gvNNLMEYSHs5zYgAVv_RZWXHM-DnsJTbfrRgb4WLN8RCMcxsClVBqD4PH7m0zDIPsVmyjHnfsUOx-ICovgkAdSd6zWvgZHfLKo88FYTsl-1_ngBfIO6DT0vqUHHMEepKcd5pGxSVSCZLvZJsyjRS6BTTA0vWWrzxKTqHQPRbotESo5pEmmVYV2RZzU3a2mXJNp2CsjQ25xvidKC1RiFwZ0wphJtQag01YXx7yiNjcSbIQX_sUx15M15a58O9bXiPoQyBE4F8TA-xMaggNbw_x8UG4iKVm9v0vTJCaiDvvM2e6UIPyMoIU1_L4uJ_5omcC-ELLPEJ_0J346cXxn7AZsK8UjnUvDrxI"
        }
    }
}
```
Faild
```bash
{
    "data": {
        "success": false,
        "message": "Registration error.",
        "error": [
            "The user with this email is already registered"
        ]
    }
}
```

# Login
This endpoint authenticates a new user to the system.

#### Header

Name            | Value 
----------------|------
**Content-Type**| application/json 
**Accept**| application/json 
    
#### Attributes

Name            | Type | Description | Example
----------------|------|------------ |--------
**email**| _email_ | Email user| `"user1@mail.ru"`
**password**| _password_ | Password user| `"1234"`

##### cURL Example
```bash
$ curl -X POST {{url}}/api/login \
-H "Content-Type: application/json" \
-H "Accept: application/json" \
-d '{"email": "user1@mail.ru", "password": 1111}'
```

##### Response Example
Success    
```bash
{
    "data": {
        "success": true,
        "message": "User authenticate successfully.",
        "user": {
            "email": "user1@mail.ru",
            "token-type": "Bearer",
            "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5NmM0YWZhZi0xODFiLTRmYmYtYTc5NC0wOTUyMjNkN2NkNjUiLCJqdGkiOiIyZGE2YzQ5OTVjNTIzNTZkYWNmZmQ2YjM0Mzk0MTRiMTdiOTIzZTNiMzFkY2M4MzQ3YzhlZDlhOTQyMmFlZjFlZDY5MDRkNWJmYjYwOWJiOSIsImlhdCI6MTY1Nzc3NzkwOC41MzQ4MzQsIm5iZiI6MTY1Nzc3NzkwOC41MzQ4MzUsImV4cCI6MTY4OTMxMzkwOC41Mjk4NTgsInN1YiI6IjEiLCJzY29wZXMiOltdfQ.FFWMJ1U5cMJEI_owLM--FgXmV8MOwKUWEEfKcGSapIxErOqLO61Ts6nXviEEtHe1R3SM1WRdJg17FE72JBxrQurZNlu5VdkaArBiykgfFuRj_d9QpW9BMMfWWSo6n1ceeOt4fBrvNzB0rMM5fEntm42Nbhdg97Q_2Eq1WexuLaTTSok45XrdJPZB8-2-NRqaevZLWW1C26yltJ8coeuW2HKQUQOwBAEHG2X2vDwdODYVCB9rzpODpLqZhwrhaIpx5pqgs5VIfpOnFIgdGIxk5uz9P1utG8z-Zej1DCsV61S5VPx9Ov9elyYkki_IsmRr-W9FjE7KfbsWBiH5TIBKKAih-DKEETtPKfclaOspwMmiSK3z25x2K06TUYCsCNobJKkQjMeDYj5Ot8N62og9cdQgtJf65nmbxSpqPTYc3DnPve9Xn7pejDRIsDQSTLZ-V6n_nD2eUZ0Dx9cxT6yxcJ1-jB3_OjZO_GS4lCqFFnyCF7i0HmO02UZnTX9oW8oj28rX6q_yexwMmct9TzHulQy-KcXRMzGduYxTyhnAfReza6rtdNwaWQhPEpmrg3G7K3Nk9Ebn0qlr_6RorGs2ye6cu8zRa1AZZsQrQjVtzd1dBk0mCR6xksmUY2vgcLmYeF8hwhQv1AB5dkbsbcFE2Vv-F0f9c9om7dA3NqVK7pc"
        }
    }
}
```
Faild
```bash
{
    "data": {
        "success": false,
        "message": "Authenticate Error.",
        "error": [
            "Invalid authorization data."
        ]
    }
}
```

# Uploading images
This endpoint uploads images to the service for further processing.

#### Header

Name            | Value 
----------------|------
**Authorization**| {{token}} 
    
#### Attributes

Name            | Type | Description | Example
----------------|------|------------ |--------
**images[]**| _array_(_file_) | Images to be processed| `[file1.png, file2.png]`

##### cURL Example
```bash
$ curl -X POST {{url}}/api/image/loading \
-H "Authorization: {{token}}" \
-d '{"images[0]": "file1.png", "images[0]": file2.png"}'
```

##### Response Example
Success    
```bash
{
    "data": {
        "success": true,
        "message": "Images loading successfully.",
        "images": [
            "file1.png",
            "file2.png"
        ]
    }
}
```

# Downloading images
This endpoint downloading selected processed images.

#### Header

Name            | Value 
----------------|------
**Authorization**| {{token}} 
    
#### Attributes

Name            | Type | Description | Example
----------------|------|------------ |--------
**images_id[]**| _array_(_integer_) | ID images to be processed| `[1, 2]`

##### cURL Example
```bash
$ curl -X POST {{url}}/api/image/downloading \
-H "Authorization: {{token}}" \
-d '{"images_id[0]": 1, "images_id[1]": 2}'
```

##### Response Example
Success    
```bash
{
    "Content-Type": application/zip
}
```
Faild    
```bash
{
    "data": {
        "success": false,
        "message": "The transmitted image was not found.",
        "error": [
            "Error loading images."
        ]
    }
}
```

# Downloading stack images
Downloading processed images from the selected stack (the stack is formed when accessing [Images downloading]({{url}}/api/image/loading).

#### Header

Name            | Value 
----------------|------
**Authorization**| {{token}} 
    
#### Attributes

Name            | Type | Description | Example
----------------|------|------------ |--------
**images_stack_id[]**| _integer_ | ID stack images| `1`

##### cURL Example
```bash
$ curl -X POST {{url}}/api/image/downloading \
-H "Authorization: {{token}}" \
-d '{"images_stack_id": 1}'
```

##### Response Example
Success    
```bash
{
    "Content-Type": application/zip
}
```
Faild    
```bash
{
    "data": {
        "success": false,
        "message": "The transferred stack of images was not found.",
        "error": [
            "Error loading images."
        ]
    }
}
```
