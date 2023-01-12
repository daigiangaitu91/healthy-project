Technical
-------------------
Use Yii2 advanced 
Documentation is at [docs/guide/README.md](docs/guide/README.md).

DIRECTORY STRUCTURE
-------------------

```
api
    config/              contains api configurations
    controllers/         contains api controllers (api)    
    models/              contains api-specific model classes
    runtime/             contains files generated during runtime 
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application    
    widgets/             contains frontend widgets
public
    assets/              contains application assets such as JavaScript and CSS
    admin/               redirect into backend folder
    api/                 redirect into api folder
    contents/            contains file upload
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```
Setup
-------------------
1. run composer install
2. if OS
    - use window run init.bat
    - use linux run php init
3. create new database and config database information into file common\config\main-local.php
4. run php yii migrate ( if import db skip step )
5. run php yii permissions ( if import db skip step )
6. config vhost on server
    - apache
    ```
   <VirtualHost *:80>
       ServerName example.com
       DocumentRoot "/path/to/project/public"
       Options +FollowSymlinks
       ...
   </VirtualHost> 
   ```
   - nginx 
   ```
   server {
       charset utf-8;
       client_max_body_size 128M;
   
       listen 80; ## listen for ipv4
       #listen [::]:80 default_server ipv6only=on; ## listen for ipv6
   
       server_name mysite.local;
       root        /path/to/project/public;
       index       index.php;
       ...
   
      location /api {                       
              try_files $uri $uri/ @api;
          } 
          location /admin {                       
              try_files $uri $uri/ @admin;
          } 
          # PHP
          location @admin {
              rewrite ^(.*)/?$ /admin/index.php?$query_string;
          }
          location @api {
              rewrite ^(.*)/?$ /api/index.php?$query_string;
          } 
   }
   ```
Use Guide
-------------------
1. Admin
    - Management User: have two type user is Staff and Member
        + Staff : user can login into admin to management
        + Member : user can login from api 
    - Management Recommended Category : Management Recommended Category ( Column, Diet, Healthy and Bealty )
    - Management Recommended : Management Recommended with category to display on Recommended page ( api Recommendede )
2. API : Please check api document https://documenter.getpostman.com/view/1254232/2s8ZDR7kpH
    - Login : Member can login with username and password
    - My Diary : Response list diary of Member 
    - Recommended : Response list recommeneded category and recommended 
    - Meal History : Member can create meal by date and get list history
    - Body Record : Member submit target for date and submit infor weight, body_fat and list history by date, week, month
    - Exercise : Member submit exercise of date    