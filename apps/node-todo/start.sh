#!/bin/bash

id="$(pm2 id node-todo)"

# Check if php-todo process exists in pm2
if [[ $id == "[]" ]]; then
    # Process doesn't exist, start it
    cd /var/www/node-todo && \
    pm2 start "NODE_ENV=production node server.js" --name "node-todo" || true
fi

# Always exit with success
exit 0