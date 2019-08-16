# VueJS + Symfony

## Project setup
```
composer install
yarn install
php bin/console schema:create
php bin/console schema:update
```
Add to tables `aiports` and `terminals` something values
### Compiles and hot-reloads for development
```
php bin/console server:start
yarn encore dev-server --hot

```

### Compiles and minifies for production
```
yarn encore production
```
