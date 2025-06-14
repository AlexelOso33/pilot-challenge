# Pilot - Challenge POSNET API

Este proyecto implementa una API POSNET para procesar pagos con tarjetas de crédito y/o débito (Visa y Amex) usando Laravel y SQLite.

## Comenzando 🚀

Sigue estos pasos para tener el proyecto funcionando en tu máquina local para desarrollo y pruebas.

### Pre-requisitos 📋

- Docker y Docker Compose
- PHP >= 8.1 (si corres fuera de Docker)
- Composer
- DBeaver o puedes utilizar la extensión SQLite Viewer en VSCode (opcional, para ver la base de datos)

### Instalación 🔧

1. **Clona el repositorio**
   ```bash
   git clone https://github.com/AlexelOso33/pilot-challenge.git
   cd challenge-pilot
   ```

2. **Copia el archivo de entorno**
   ```bash
   cp .env.example .env
   ```

3. **Crea la base de datos SQLite**
   ```bash
   mkdir -p database
   touch database/database.sqlite
   ```

4. **Configura la ruta de la base de datos en `.env`**
   ```
   DB_CONNECTION=sqlite
   DB_DATABASE=/var/www/html/database/database.sqlite
   ```

5. **Levanta los servicios con Docker**
   ```bash
   docker-compose up --build -d
   ```

6. **Instala dependencias y ejecuta migraciones dentro del contenedor**
   ```bash
   docker exec -it pilot_api composer install
   docker exec -it pilot_api php artisan key:generate
   docker exec -it pilot_api php artisan migrate
   ```

7. **(Opcional) Ejecuta los tests**
   ```bash
   docker exec -it pilot_api php artisan test
   ```

### Uso de la API

#### Registrar una tarjeta

**POST** `/api/registerCard`

Body (JSON):
```json
{
  "brand": "VISA",
  "bank": "Santander",
  "number": "1234567812345678",
  "limit": 100000,
  "dni": 33444555,
  "first_name": "Alexis",
  "last_name": "Sanchez"
}
```

#### Realizar un pago

**POST** `/api/doPayment`

Body (JSON):
```json
{
  "number": "1234567812345678",
  "amount": 1000,
  "installments": 3
}
```

### Ejecutando las pruebas ⚙️

Para correr los tests automáticos:

```bash
docker exec -it pilot_api php artisan test
```

Esto ejecuta pruebas de integración sobre los endpoints principales de la API.

### Notas adicionales

- Solo se aceptan tarjetas VISA o AMEX.
- El número de tarjeta debe ser de 16 dígitos.
- El límite disponible se descuenta automáticamente al realizar un pago.
- El ticket de pago retorna: nombre y apellido, monto total y monto por cuota.

## Construido con 🛠️

- [Laravel](https://laravel.com/)
- [PHP](https://www.php.net/)
- [SQLite](https://www.sqlite.org/)
- [Docker](https://www.docker.com/)

## Autor ✒️

- **Alexis Sanchez**  
  [![LinkedIn](https://img.shields.io/badge/LinkedIn-Perfil-blue?logo=linkedin)](https://linkedin.com/in/alexis-gabriel-sanchez)

---

⌨️ con ❤️ por [Alexis Sanchez](https://linkedin.com/in/alexis-gabriel-sanchez)