
# Test RH Asesorate

Esta es la docmentación para el proyecto de la prueba técnica para la empresa de reclutamiento profesional RH Asesorate. En las siguientes secciones se desglosarán las distintas componentes que conforman al proyecto.




## Prueba Local

Clona el proyecto

```bash
  git clone https://github.com/gisuss/test-RHAsesorate.git
```

Ve al directorio

```bash
  cd my-project
```

Instala las dependencias

```bash
  composer update
  npm install
```

Genera el .env y posteriormente configura la DB

```bash
  cp .env-example .env
```

Genera la llave de la api

```bash
  php artisan key:generate
```

Ejecuta las migraciones y seeders

```bash
  php artisan migrate --seed
```

Inicia el server

```bash
  php artisan serve
  npm run dev
```


## Usuarios de Prueba

Usuario admin

```bash
  email: admin@example.com
  clave: password
```

Usuario cliente

```bash
  email: user@example.com
  clave: password
```




## Referencias de la API

### [Auth - login]

Endpoint de api para el inicio de sesión de usuarios.

```http
  POST /api/auth/login
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `email_username` | `string` | **Required**. |
| `password` | `string` | **Required**. |


### [Auth - logout]

Endpoint de api para el cierre de sesión de usuarios.

```http
  POST /api/auth/logout
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `api_key`      | `string` | **Required**. |


### [Quotes - random]

Endpoint del paquete quotes api que retorna una cita aleatoria. 

```http
  GET /api/quotes/random/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `api_key`      | `string` | **Required**. |
| `id`      | `integer` | **Required**. |


### [Quotes - to-fav]

Endpoint del paquete quotes api que envía una cita determinada hacia el registro de favoritos del usuario que hace la petición.

```http
  POST /api/quotes/to-fav
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `api_key`      | `string` | **Required**. |
| `user_id`      | `integer` | **Required**. |
| `quote_id`      | `integer` | **Required**. |


### [Quotes - to-trash]

Endpoint del paquete quotes api que elimina una cita determinada del registro de favoritos del usuario que hace la petición.

```http
  POST /api/quotes/to-trash
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `api_key`      | `string` | **Required**. |
| `user_id`      | `integer` | **Required**. |
| `quote_id`      | `integer` | **Required**. |


### [Quotes - fav]

Endpoint del paquete quotes api que retorna una colección de todas las citas que el usuario logueado haya registrado como favoritas.

```http
  GET /api/quotes/fav/{user_id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `api_key`      | `string` | **Required**. |
| `user_id`      | `integer` | **Required**. |


### [Quotes - quote]

Endpoint del paquete quotes api que retorna una cita dada por parámetro de url.

```http
  GET /api/quotes/quote/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `api_key`      | `string` | **Required**. |
| `user_id`      | `integer` | **Required**. |


### [User - index]

Endpoint de api principal que retorna una colección de usuarios para el listado de administración de usuarios en el panel administrativo.

```http
  GET /api/user/index
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `api_key`      | `string` | **Required**. |


### [User - show]

Endpoint de api principal que retorna un usuario dado por parámetro de url.

```http
  GET /api/user/show/{user}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `api_key`      | `string` | **Required**. |
| `user`      | `integer` | **Required**. |


### [User - activate]

Endpoint de api principal que activa un usuario dado por parámetro de url.

```http
  POST /api/user/activate/{user}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `api_key`      | `string` | **Required**. |
| `user`      | `integer` | **Required**. |


### [User - desactivate]

Endpoint de api principal que inhabilita un usuario dado por parámetro de url. Esta acción no permite que el usuario pueda iniciar sesión.

```http
  POST /api/user/desactivate/{user}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `api_key`      | `string` | **Required**. |
| `user`      | `integer` | **Required**. |


### [User - update]

Endpoint de api principal que actualiza datos de usuario. Los datos son enviados mediante form data a la api.

```http
  POST /api/user/update/{user}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `api_key`      | `string` | **Required**. |
| `user`      | `integer` | **Required**. |
| `name`      | `string` | **Required**. |
| `lastname`      | `string` | **Required**. |
| `email`      | `string` | **Required**. |
| `role`      | `string` | **Required**. |
| `password`      | `string` | **Optional**. |
| `confirm_password`      | `string` | **Optional**. |


### [User - register]

Endpoint de api principal que registra un nuevo usuario. Los datos son enviados mediante form data a la api.

```http
  POST /api/auth/register
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `name`      | `string` | **Required**. |
| `lastname`      | `string` | **Required**. |
| `email`      | `string` | **Required**. |
| `role`      | `string` | **Required**. |
| `password`      | `string` | **Required**. |
| `confirm_password`      | `string` | **Required**. |

## Authors

- [@gisuss](https://www.github.com/gisuss)

