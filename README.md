Requisitos previos:
    <li> PHP 8.2
    <li> Composer
    <li> XAMPP/WAMPP
    <li> MySQL 

Configuracion: 
Lo primero a configurar será la base de datos, donde se deberá de crear una nueva o utilizar una ya existente pero sin tablas para evitar problemas.
Con la base de datos funcional se debe de actualizar las variables de entorno del archivo .env

    DB_DATABASE="el nombre de la base de datos a utilizar"
    DB_USERNAME="el usuario de la base de datos (por defecto es root)"
    DB_PASSWORD="la contraseña del usuario de la base de datos (por defecto no hay contraseña, si es el caso, dejar vacio)"

Luego con la base de datos creada y confugrada ejecutar el comando:
    php artisan migrate 
Este comando crea automaticamente las tablas a utilizar en la base de datos, es importante ejecutarlo antes de levantar el proyecto, si todo quedó bien se ejecutará sin problemas.

Levantar el servidor:
Para ejecutar el servidor debe haber realizado los pasos anteriores y ejecutar el siguiente script en la terminal
  php artisan serve
Si todo anda bien mostrará el mensaje: Server running on [http://127.0.0.1:8000].

Para ver la documentacion de los endpoints ingrese al siguiente link
https://documenter.getpostman.com/view/21273556/2s93m8zg2f
