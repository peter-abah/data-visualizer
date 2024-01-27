# PlotDat

PlotData is a web application built with Laravel that allows users to easily upload CSV data, transform it into meaningful visualizations, and share these insights with others. Whether you're a data analyst, business professional, or just someone who wants to turn data into impactful charts, PlotDat simplifies the process.

## Built With

- PHP
- Laravel
- Typescript
- React
- Chart.js

## Video Demo

[![Watch the video](https://img.youtube.com/vi/fOI8uOiRT-0/hqdefault.jpg)](https://youtu.be/fOI8uOiRT-0?si=fe7PQPNjjtHCLxQ0)


## Getting Started
To get a local copy up and running follow these simple example steps.

### Prerequisites
Make sure these are installed on your system:
- [Git](https://git-scm.com/downloads)
- [PHP (8.1)](https://www.php.net/downloads)
- [Composer](https://getcomposer.org/download/)
- [NodeJS/NPM](https://nodejs.org/en/download)
- [Postgresql 15](https://www.postgresql.org/download/)


### Install
- Enable `zip` php extension for composer to work
- Enable `pdo_pgsql` and `pgsql` php extensions to allow php work with posgresql database
- Make sure these [PHP extensions](https://laravel.com/docs/10.x/deployment#server-requirements) are enabled for laravel to work.

- Run this command to clone the repository
```
git clone https://github.com/peter-abah/data-visualizer.git
```

- CD into the project
```
cd data-visualizer
```

- Install Composer dependencies
```
composer install
```

- Install NPM dependencies
```
npm install
```

- Create copy of env file from `.env.example`
```
cp .env.example .env
```

- Create a Database for the application on Postgresql

- Update the env file with the database name and user

- Run the following commands to start the application:
```
php artisan key:generate

php artisan migrate

npm run dev

php artisan server
```



## Author

- GitHub: [@peter-abah](https://github.com/peter-abah)
- Twitter: [@obekpa](https://twitter.com/obekpa__)
- LinkedIn: [Peter Abah](https://linkedin.com/in/abah-peter)


## 📝 License

This project is [MIT](./LICENSE) licensed.
