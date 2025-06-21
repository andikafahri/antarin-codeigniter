#!/bin/sh
echo "Starting CI4 server..."
php spark serve --host=0.0.0.0 --port=${PORT:-8080} --public=public
