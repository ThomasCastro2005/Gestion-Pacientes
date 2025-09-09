# Gestión de Pacientes

## Descripción
Este proyecto es una aplicación web para **gestionar pacientes**, permitiendo:
- Crear, editar y eliminar pacientes.
- Filtrar municipios según el departamento seleccionado.
- Buscar pacientes por nombre, correo o número de documento.
- Paginación de la tabla de pacientes.
- Login y logout con autenticación mediante JWT.
- Manejo de errores y alertas para el usuario.

Se desarrolló como prueba técnica integrando **frontend con backend** y mostrando buenas prácticas en manejo de APIs y validación.

---

## Tecnologías utilizadas
- **Frontend:** HTML5, CSS, JavaScript, Bootstrap 5, Axios.
- **Backend:** PHP con Laravel.
- **Base de datos:** MySQL.
- **Pruebas:** PHPUnit.
- **Control de versiones:** Git y GitHub.

---

## Estructura del proyecto



/proyecto
├─ app.js # Lógica principal del frontend
├─ index.html # Interfaz de usuario
├─ .gitignore # Archivos y carpetas ignoradas
├─ README.md # Documentación
├─ routes/web.php # Rutas web (Laravel)
├─ app/Models/ # Modelos Eloquent
├─ app/Http/Controllers/ # Controladores
├─ database/migrations/ # Migraciones de base de datos
├─ database/seeders/ # Seeders para datos iniciales
└─ tests/ # Pruebas unitarias con PHPUnit


---

## Instalación y ejecución

### 1. Clonar el repositorio

git clone <https://github.com/ThomasCastro2005/Gestion-Pacientes.git>

2. Instalar dependencias
composer install
npm install       # Solo si hay dependencias frontend

3. Configurar entorno

**Copiar .env.example a .env y configurar la base de datos y JWT.**

cp .env.example .env
php artisan key:generate

4. Migrar y sembrar base de datos
php artisan migrate
php artisan db:seed

5. Ejecutar servidor local
php artisan serve


Accede a http://127.0.0.1:8000 para probar la aplicación.

**Funcionalidades implementadas**

- CRUD de pacientes

- Crear, editar, eliminar y listar pacientes.

- Validación de formularios en frontend y backend.

- Selects dependientes

- Al seleccionar un departamento, el select de municipios se filtra automáticamente.

- Búsqueda y paginación

- Búsqueda por nombre, correo o número de documento.

- Tabla paginada mostrando 5 pacientes por página.

- Autenticación

- Login y logout usando JWT.

- Solo usuarios autenticados pueden acceder a la API.

- Manejo de errores

- Alertas dinámicas con Bootstrap.

- Validación de datos y manejo de errores de servidor.

- Pruebas unitarias (PHPUnit)

- Se implementaron pruebas para verificar el correcto funcionamiento de:

- Creación de pacientes.

- Actualización de pacientes.

- Eliminación de pacientes.

- Para ejecutar las pruebas:

- php artisan test


- PHPUnit validará las rutas del API, la integración con la base de datos y la correcta persistencia de los datos.

- Criterios de valoración

- Funcionalidad: CRUD completo y correcto.

- UX/UI: Selects dependientes, alertas dinámicas, paginación y búsqueda funcional.

- Código: Limpio, organizado y modular.

- GitHub: Uso correcto de Git, commits claros y .gitignore configurado.

**Pruebas: PHPUnit implementado y ejecutable.**

# **Notas adicionales**

- Los archivos sensibles y dependencias están ignorados con .gitignore.

- Frontend y backend se comunican mediante API REST con JWT.

- Datos de prueba cargados mediante seeders para prueba rápida de la aplicación.
