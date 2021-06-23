# README

This containerized project depends on bind mounts so it's necessary to run `composer install` first or just run the `up.sh` script.

If you've run `composer install` already, just run `docker-compose up`.

Hitting the service at `localhost:3001` reads the challenge.json file.
An SQL Admin Services can be accessed on `localhost:3002`. The details to access it are as follows:
* HOST: `mysql`
* USER: `root`
* PASSWORD: `password`
* DATABASE: `laravel` 

__NOTE:__ You will see some `connection refused` outputs in the cli while `docker-compose` is provisioning the services. This is because the app is waiting for the mysql services to be properly up and running before proceeding with running of migrations, hence the app keeps trying to connect in a different script until it's successful.

## Methodology

The Job was Queued using the `JobController`

The Job that extracts and processes the json file is `app/Jobs/SaveDataJob.php`

REDIS was used to record progress in case of midway termination

JSON processor was designed as an adapter so other data formats could be supported in future.