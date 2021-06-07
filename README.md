# README

This containerized project depends on bind mounts so it's necessary to run `composer install` first or just run the `up.sh` script.

If you've run `composer install` already, just run `docker-compose up`.

Hitting the service at `localhost:3001` reads the challenge.json file.
An SQL Admin Services can be accessed on `localhost:3002`. The details to access it are as follows:
* HOST: `mysql`
* USER: `root`
* PASSWORD: `password`
* DATABASE: `laravel` 
