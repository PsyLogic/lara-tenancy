# Lara-Tenancy

Lara-Tenancy boilerplate based on the package [hyn/multi-tenant](https://github.com/tenancy/multi-tenant) that makes your app multi tenant. Serving multiple websites, each with one or more hostnames from the same codebase. But with clear separation of assets, database and the ability to override logic per tenant.

### Installation
```sh
$ git clone https://github.com/PsyLogic/lara-tenancy.git
$ cd lara-tenancy
$ composer install
$ cp .env.example .env
$ php artisan key:generate
$ php artisan migrate --database=system
```

### Usage
##### Create Tenant via Artisan Commande.
_
```sh
$ php artisan tenant:create tuto
```
you'll asked for user information such as [name,email,password]
```sh
 Type your name [User]:
 > tuto
 Type your email:
 > tuto@example.com
 Type your password:
 > ******
```

after the FQDN and User is created you'll get info messages:
> New Hostname tuto is created successufully
> Verification Email was sent to tuto@example.com

##### Create Tenant from web
Go to for example
```sh
$ lara-tenancy.test/register
```


##### Tenant Structure
Middleware (to enfore using tenant connection)
```php
    App/Http/Middleware/EnforceTenancy
```

Controllers
```php
    App/Http/Controllers/Tenants
```

Views
```php
    resources/views/tenant
```

Routes
```php
    routes/tenants.php
```
### Todos

 - Tenant CRUD & ACL
 - Tenancy Administration
 - Add Queues and Jobs for Creating tenants & Email verification & password reset
 