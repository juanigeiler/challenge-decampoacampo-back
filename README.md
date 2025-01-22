Pasos a seguir para implementar:

1. En primer lugar, se debe duplicar el archivo /php/src/config/env.xample.php para llamarlo env.php. De esta manera la variable del precio del dólar estará disponible, y también las credenciales y la información necesaria para conectarse a la base de datos.
2. Luego, en la raíz del proyecto se encuentra el docker-compose. Al ejecutar docker-compose up --build:
    - Por un lado va a generar el contenedor de php ejecutando el Dockerfile, y montando toda la carpeta de src en /var/www/html. Se correrá en el puerto 8080.
    - Por otro lado, va a generar el contenedor de la base de datos, creandola con el nombre configurado en MYSQL_DATABASE (dejar el predeterminado) y va a ejecutar automáticamente el script ubicado en db/init.sql para crear la tabla de productos.
