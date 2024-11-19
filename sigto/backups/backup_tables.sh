#!/bin/bash

# Configuración de conexión a MySQL
DB_HOST="db"              # Host definido en Database.php
DB_USER="root"            # Usuario predeterminado en Database.php
DB_PASSWORD=""            # Contraseña predeterminada (vacía)
DB_NAME="oceantrade"      # Nombre de la base de datos
BACKUP_DIR="./backups"    # Carpeta para almacenar los respaldos

# Crear el directorio de respaldo si no existe
mkdir -p "$BACKUP_DIR"

# Obtener una lista de todas las tablas en la base de datos
TABLES=$(mysql -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASSWORD" -e "SHOW TABLES IN $DB_NAME;" | awk '{if (NR>1) print $1}')

# Respaldar cada tabla en un archivo separado
for TABLE in $TABLES; do
    BACKUP_FILE="$BACKUP_DIR/${TABLE}_backup_$(date +%Y%m%d_%H%M%S).sql"
    echo "Respaldando tabla: $TABLE"
    mysqldump -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASSWORD" "$DB_NAME" "$TABLE" > "$BACKUP_FILE"

    if [ $? -eq 0 ]; then
        echo "Respaldo completado: $BACKUP_FILE"
    else
        echo "Error al respaldar la tabla: $TABLE"
    fi
done

echo "Respaldo de todas las tablas completado."



#./backup_tablas.sh para correr el respaldo 