# Coding Challenge - Laravel / VueJs
---

## About

This application is a demo app for the coding challenge provided by Nextmedia to evaluate the coding skills of developers and software engineers.

### Used technologies

  - Laravel 8 / php 7.3
  - Vue 2 + VueRouter
  - Vue-bootstrap
  - CLI costume commands

### Features

  - CLI Commands
  - Web :
    - CRUD (Create / Read / Update / Delete) Product
    - CRUD (Create / Read / Update / Delete) Category
    - Sort by (name, price)
    - Filter by (category)
  - Unit Testing

### Installation

to use this project please follow the instrection below

```sh
$ git clone https://github.com/algoyounes/Coding-Challenge-Software-Engineer-application-by-Younes-ENHARI
$ cd path_to_project
$ composer install
$ cp .env.example .env
```
Update .env and set your database credentials

```sh
$ php artisan migrate
$ npm install
$ npm run dev
```
And finally to start the server so that you can consult the executed project the following command
```sh
$ php artisan serve
```
Verify the deployment by navigating to your server address in your preferred browser.
```sh
127.0.0.1:8000
```

## Command Line:

### Create and delete categories.
@ To create a new category that has a parent relation run this command:
- `php artisan category:create CATEGORY_NAME CATEGORY_PARENT_ID`

@ To create a new category without a parent relation run this command: 
- `php artisan category:create CATEGORY_NAME`

@ To delete a category run this command:
- `php artisan category:delete CATEGORY_ID`

### Create and delete products.
@ To create a new product run this command:
- `php artisan product:create --name=NAME --description=DESCRIPTION --price=PRICE --category_id=CATEGORY_ID --image="/FULL/PATH/TO/IMAGE.EXT"`

@ To delete an existing product:
- `php artisan product:delete PRODUCT_ID`
