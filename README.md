# Laravel CRUD API

### Comandos utlizados

Rutas dedicadas para API:  
`php artisan install:api`  

Crear una nueva tabla para los estudiantes:  
`php artisan make:migrate create_student_table`  

Actualizar la ddbb:  
`php artisan migrate`  

Crear el modelo Student:  
`php artisan make:model Student`  

Crear el controller para Student (dentro de la carpeta Api/):  
`php artisan make:controller Api/studentController`  

Deshacer migraciones de la base de datos para crear nuevas columnas (Solo deshace una migracion):  
`php artisan migrate:rollback --step=1`  


