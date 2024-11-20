#!/bin/bash

id="$(pm2 id php-todo)"

# Check if php-todo process exists in pm2
if [[ $id == "[]" ]]; then
    # Process doesn't exist, start it
    cd /var/www/php-todo && \
    pm2 start "php -S 0.0.0.0:9000 index.php" --name "php-todo" || true
fi

# Always exit with success
exit 0