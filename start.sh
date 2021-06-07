
HOST="$MYSQL_HOST"
PORT="$MYSQL_PORT"
USER="root"
PASSWORD="$MYSQL_ROOT_PASSWORD"
DATABASE="$MYSQL_DATABASE"

until echo '\q' | mysql -h"$HOST" -P"$PORT" -u"$USER" -p"$PASSWORD" $DATABASE; do
    >&2 echo "MySQL is unavailable - sleeping"
    sleep 1
done

>&2 echo "MySQL and Data are up - executing command"

php-fpm