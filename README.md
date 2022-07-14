<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p

# Сервис для обработки изображений
    1. Регистрация\Авторизация в системе
    2. Авторизированный пользователь может:
        2.1. Загрузить изображение для обработки
        2.2. Скачать обработанное изображение
    
Name | Description
------------ | ------------
[Register]({{url}}/api/register)     | New User Registration
[Login]({{url}}/api/login)   | User authorization
[Images uploading](https://kirschbaumdevelopment.com)   | Uploading images to a service for further processing
[Images downloading](https://64robots.com)   | Downloading selected processed images
[Stack images downloading](https://cubettech.com) | Downloading processed images from the selected stack (the stack is formed when accessing [Images downloading](https://64robots.com))
    
#### Register
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
