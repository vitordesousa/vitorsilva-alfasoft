#!/bin/bash
set -e

if [ -d "/tmp/ssh-keys" ]; then
    echo "Configurando chaves SSH..."
    cp -r /tmp/ssh-keys/* /root/.ssh/
    chmod 600 /root/.ssh/*
    chown -R root:root /root/.ssh
fi

echo "Iniciando Supervisor..."
exec "$@"
