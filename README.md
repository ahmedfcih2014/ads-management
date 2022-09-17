This repo contains an ads Management API`s built using Laravel 9

## Instructions For Run
* clone the repo
* run composer install
* run this command `php artisan migrate --seed`
* then call APIs using curl | postman | etc..

## For testing
* run `php artisan test` then you'll get all passed (13 tests) otherwise fill free to leave a comment

### For schedule mail task
* run this command as a cron job on your server `* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1`
