# Lara-Tenancy

Lara-Tenancy boilerplate based on the package [hyn/multi-tenant](https://github.com/tenancy/multi-tenant) that makes your app multi tenant. Serving multiple websites, each with one or more hostnames from the same codebase. But with clear separation of assets, database and the ability to override logic per tenant.

The boilerplate has no advanced code is so simple for all Laravel users, so that they can fork it and change it easly
What I care about is the concept of mutli-tenancy so I'm trying to make it simple as possible.

### Installation
```sh
$ git clone https://github.com/PsyLogic/lara-tenancy.git
$ cd lara-tenancy
$ composer install
$ cp .env.example .env
$ php artisan key:generate
$ php artisan migrate --database=system --seed
```

### Usage

Default Super Admin was created for you
to manage all Tenants and Users

```
email: admin@example.com
password: password
```

I suppose this is your vhost

```sh
<VirtualHost *:80> 
    DocumentRoot "path/www/lara-tenancy/public/"
    ServerName lara-tenancy.test
    ServerAlias *.lara-tenancy.test
    <Directory "path/www/lara-tenancy/public/">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

##### Create Tenant via Artisan Commande.

```sh
$ php artisan tenant:create tuto
```
you'll asked for user information such as [name, email, password]
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
lara-tenancy.test/register
```

After Creating New Tenat from Command line or UI, you can now Go to for example
```sh
tuto.lara-tenancy.test
```

##### Delete Tenant via Artisan Commande.

only works in local mode

```sh
$ php artisan tenant:delete tuto
```

##### Tenant Structure
Middlewares
```php
// to enfore using tenant connection
App/Http/Middleware/EnforceTenancy

//The hostname actions middleware (banned ,redirects, https, maintenance).
App/Http/Middleware/HostnameActions
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

 - Tenant CRUD & ACL [done]
 - Tenancy Administration [done]
 - Add Queues and Jobs for Creating tenants & Email verification & password reset
 
