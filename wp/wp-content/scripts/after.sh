#!/usr/bin/env bash

source /opt/codedeploy-agent/deployment-root/${DEPLOYMENT_GROUP_ID}/${DEPLOYMENT_ID}/deployment-archive/scripts/env.conf
#Change ownership to appropriate user:group
chown -R ${GLOBAL_OWNER}:${GLOBAL_GROUP} /var/www/html/${NAME}/wp-content/themes
chown -R ${GLOBAL_OWNER}:${GLOBAL_GROUP} /var/www/html/${NAME}/wp-content/plugins

#Change permissions to proper permissions
chmod -R 775 /var/www/html/${NAME}/wp-content/themes
chmod -R 775 /var/www/html/${NAME}/wp-content/plugins