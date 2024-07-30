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
| GET        | `/api/dashboard/products/{product}`       | Retrieve details of a specific product             |
| PUT        | `/api/dashboard/products/{product}`       | Update an existing product                         |
| DELETE     | `/api/dashboard/products/{product}`       | Delete a specific product                          |

Get | Prodcuts Can be sorted and set number of products to get can set all the following
        ```

        ('per_page', 10);
        ('search', '');
        ('sort_field', 'created_at');
        ('sort_direction', 'desc');

# Site API For all Users
| Method     | URL                                  | Description                                        |
|------------|--------------------------------------|----------------------------------------------------|
| GET        | `/api/products`                      | Retrieve paginated list of products                |
| GET        | `/api/products/{product:slug}`       | Retrieve details of a specific product             |


# Cart System

| Method     | URL                                    | Description                                            |
|------------|----------------------------------------|--------------------------------------------------------|
| GET        | `/api/guest/cart`                      | Retrieve the current user's cart                       |
| POST        | `/api/guest/cart/add/{product:slug}`   | Add a product to the cart                              |
| POST        | `/api/guest/cart/remove/{product:slug}`| Remove a product from the cart                         |
| POST        | `/api/guest/cart/update-quantity/{product:slug}` | Update the quantity of a product in the cart         |

If He Authenticated 
| Method     | URL                                    | Description                                            |
|------------|----------------------------------------|--------------------------------------------------------|
| GET        | `/api/cart`                      | Retrieve the current user's cart                       |
| POST        | `/api/cart/add/{product:slug}`   | Add a product to the cart                              |
| POST        | `/api/cart/remove/{product:slug}`| Remove a product from the cart                         |
| POST        | `/api/cart/update-quantity/{product:slug}` | Update the quantity of a product in the cart         |

***Notice Add take ?quantity={number}***

       







 
 


 

## Freamworks Used
- Laravel 11

 