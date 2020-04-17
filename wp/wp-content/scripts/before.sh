#!/usr/bin/env bash

source /opt/codedeploy-agent/deployment-root/${DEPLOYMENT_GROUP_ID}/${DEPLOYMENT_ID}/deployment-archive/scripts/env.conf
if [ ! -f "/var/www/html/${NAME}/wp-config.php" ]
then
    mkdir /var/www/html/${NAME}
    sudo wp core download --path=/var/www/html/${NAME}  --allow-root
    sudo wp core config --dbprefix=${NAME}_ --dbname=${NAME} --path=/var/www/html/${NAME} --allow-root
    sudo wp db create --path=/var/www/html/${NAME} --allow-root
    sudo wp core install --url=https://${NAME}.designs.brafton.com --title="${TITLE}" --path=/var/www/html/${NAME} --allow-root
    chown -R ${GLOBAL_OWNER}:${GLOBAL_GROUP} /var/www/html/${NAME}
    chmod -R 775 /var/www/html/${NAME}
else
    echo 1;
fi