# Laravel API

## Login Routes

| Type  | URL                                  | Accepts                                             |
|-------|--------------------------------------|-----------------------------------------------------|
| POST  | `/api/register`                      | `name`, `email`, `password`, `password_confirmation`|
| POST  | `/api/login`                         | `email`, `password`                                 |
| POST  | `/api/logout`                        | `Add the Token`                                     |
| POST  | `/api/forgot-password`               | `email`                                             |
| POST  | `/api/reset-password`                | `email`, `token`,`password`, `password_confirmation`| 

Token of reset-password come from(when send forget-password request an email send to user that email containu url like this
http://localhost:3000/password-reset/150ee3d6a31a33209dbeefed3467f5e4910b3d8f60b38d944bc3733e50825d83?email=a%40a.a
you must create it's frontend page and take the token from url and send  with reset-password request
)
 

# dashboard API Endpoints
| Method     | URL                                  | Description                                        |
|------------|--------------------------------------|----------------------------------------------------|
| GET        | `/api/dashboard/products`            | Retrieve paginated list of products                |
| POST       | `/api/dashboard/products`            | Create a new product                               |
| GET        | `/api/dashboard/products/{id}`       | Retrieve details of a specific product             |
| PUT        | `/api/dashboard/products/{id}`       | Update an existing product                         |
| DELETE     | `/api/dashboard/products/{id}`       | Delete a specific product                          |



 
 


 

## Freamworks Used
- Laravel 11

 