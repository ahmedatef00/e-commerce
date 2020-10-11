## Installation instructions:

##### first cd to project directory
##### Install Composer Dependencies:

```
composer install
```

##### Install NPM Dependencies

```
npm install
```

##### Create a copy of your .env file

```
cp .env.example .env
```

##### Generate an app encryption key

```
php artisan key:generate
```

##### Create an empty database for our application

##### In the .env file, add database information to allow Laravel to connect to the database

##### Migrate the database

```
php artisan migrate
```

##### Seed the database

```
php artisan db:seed
```

