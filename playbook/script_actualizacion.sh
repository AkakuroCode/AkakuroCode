#!/bin/bash

# Variables
DIRECTORIO_PROYECTO="/root/mi_proyecto"  # Cambia según la ubicación del proyecto
INVENTARIO="hosts"  # Archivo de inventario de Ansible
PLAYBOOK_ACTUALIZAR="clonar_proyecto.yml"  # Nombre del playbook de Ansible

echo "Ejecutando actualización del proyecto desde GitHub..."

# Ejecuta el playbook de Ansible para actualizar el proyecto desde GitHub
ansible-playbook -i $INVENTARIO $PLAYBOOK_ACTUALIZAR

echo "Actualización completada. Reiniciando los contenedores de Docker..."

# Navega al directorio del proyecto en la máquina virtual
cd $DIRECTORIO_PROYECTO

# Reinicia los contenedores
docker-compose down
docker-compose up -d

echo "Contenedores reiniciados. Proyecto actualizado y en ejecución."
