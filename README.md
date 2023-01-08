## php-postgres
Docker Compose configuration to run PHP 7.4 with Nginx, PHP-FPM, PostgreSQL 15 and Composer.

##  Requirements
* Using only PHP and Composer.
* Must be authenticated or authorized to use the API.
* Using worker or queue or message distribution.
* Store all sent messages/emails into postgres DB.

## Overview
* Web (Nginx)
* PHP (PHP 7.4 with PHP-FPM)
* DB (PostgreSQL 15)
* Composer
* Redis
* Oauth2 Server

## Install prerequisites
* [Docker CE](https://docs.docker.com/engine/installation/)
* [Docker Compose](https://docs.docker.com/compose/install)
* [Postgres]
* [PHP 7.0 or Higher]

## How to use it
### Composer
Run composer install:
    ```composer
    composer install
    ```
### Starting Docker Build
    ```docker
    docker-compose build
    ```
### Starting Docker Compose
    ```docker
    docker-compose up -d
    ```
### Run Application
    ```php
    php -S localhost:8080 -t .
    ```
### Alter Table Postgress Manualy
    Run database.sql in [APP_PATH]/database.sql


## Flow System Design
```

-------------                   ------------------    
|  CLIENT   | ----------------- |  API ENDPOINT  | ---
-------------                   ------------------   |
         __________________ ____________|            |
        |                               |            |
----------------                ----------------     |
|              |                |  MIDDLEWARE  |     |
|  CONTROLLER  |----------------|  & DATABASE  |------
|              |                |  & OUATH2    |
----------------                ----------------
        |                       ---------------
        |---------------------- |    REDIS    |
        |                       ---------------
-----------------       
|  PHP MAILER   | 
-----------------

```

## API Endpoint
<table>
  <tr>
    <th>Path</th>
    <th>End Point</th>
    <th>Parameter</th>
    <th>Controller</th>
    <th>Function</th>
    <th>Description</th>
  </tr>
  <tr>
    <td>GET</td>
    <td>/oauth</td>
    <td></td>
    <td>OauthClientController</td>
    <td>retrieve</td>
    <td>Get All list oauth_client table (without middleware)</td>
  </tr>
  <tr>
    <td>POST</td>
    <td>/token</td>
    <td> 
    Body : <br>
    {
        "grant_type":"client_credentials",
        "client_id":"fewp",
        "client_secret":"123"
    }
    </td>
    <td>TokenController</td>
    <td></td>
    <td>Generate Token</td>
  </tr>
  <tr>
    <td>GET</td>
    <td>/messages/emails</td>
    <td></td>
    <td>EmailController</td>
    <td>retrieve</td>
    <td>Retrieve Email Log (with middleware)</td>
  </tr>
  <tr>
    <td>POST</td>
    <td>/messages/emails</td>
    <td>
    Authorization Bearer [access_token] <br>
    Body : <br>
    {
        "mail_to" : "aaa@bbb.ccc",
        "mail_subject" : "Testing Email",
        "mail_body" : "This is testing email, send from system"
    }
    </td>
    <td>EmailController</td>
    <td>create</td>
    <td>Send Email & Save Database (with middleware)</td>
  </tr>
  <tr>
    <td>GET</td>
    <td>/messages/emails/redis</td>
    <td>
        Authorization Bearer [access_token]
    </td>
    <td>WorkerController</td>
    <td></td>
    <td>Retrieve email log and check if saved in cache. if saved in cache then get from chace. If not then query from database.</td>
  </tr>
</table>
# b148316c9fea3c2c5509bbde480b3753
