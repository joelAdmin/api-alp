# API ALP - Sistema de Mensajería en Tiempo Real

Este proyecto es el backend de una plataforma de chat y mensajería desarrollada en **Laravel 8**, diseñada para ofrecer comunicación fluida entre usuarios mediante WebSockets y una arquitectura de API RESTful.

## 🚀 Tecnologías y Versiones

*   **Framework:** Laravel 8.54
*   **Lenguaje:** PHP ^7.3 | ^8.0
*   **Autenticación:** Laravel Passport (OAuth2)
*   **Mensajería en Tiempo Real:** WebSockets (vía Pusher Driver)
*   **Servidor de WebSockets:** Servidor personalizado en `wss.jlssystem.com`
*   **Gestor de Dependencias:** Composer & NPM

---

## 🏗️ Arquitectura del Sistema

### Base de Datos
El proyecto utiliza una estructura de tablas personalizada con el prefijo `pgrw_`.
*   **Usuarios (`pgrw_usuarios`):** Gestión de perfiles, credenciales y estado de conexión.
*   **Chats (`pgrw_chats`):** Cabeceras de conversaciones entre emisores y receptores.
*   **Mensajes (`pgrw_chats_mensajes`):** Contenido multimedia (texto, audio ogg, adjuntos).

### Modelos Principales (`app/Models`)
*   `User`: Modelo de usuario autenticable con soporte para API Tokens.
*   `Chat`: Relaciona a los participantes de una conversación.
*   `Message`: Gestiona el envío y recepción de datos en cada chat.

---

## 📡 Integración de WebSockets y Real-Time

El sistema utiliza una arquitectura de eventos para comunicación bidireccional, configurada para trabajar con un servidor de WebSockets dedicado.

### 1. Configuración del Driver (`config/broadcasting.php`)
El driver `pusher` está personalizado para apuntar a la infraestructura de **JLS System** en lugar de los servidores de Pusher HQ:

```php
'pusher' => [
    'driver' => 'pusher',
    'key' => env('PUSHER_APP_KEY'),
    'secret' => env('PUSHER_APP_SECRET'),
    'app_id' => env('PUSHER_APP_ID'),
    'options' => [
        'host' => 'wss.jlssystem.com',
        'port' => 6001, 
        'scheme' => 'https',
        'useTLS' => true,
        'encrypted' => true,
        'curl_options' => [
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
        ],
    ],
],
```

### 2. Autorización de Canales (`routes/channels.php`)
La seguridad de las suscripciones se maneja mediante clausuras de autorización que validan la identidad del usuario a través de su `usuario_id`:

```php
// Solo el receptor del mensaje puede escuchar su canal privado
Broadcast::channel('new-message.{id}', function ($user, $id) {
    return (int) $user->usuario_id === (int) $id;
});
```

### 3. Ejemplo de Implementación

#### Lado del Servidor (Emisión)
Cuando se guarda un mensaje, se dispara el evento `NewMessage`:
```php
// En el controlador o servicio
$message = Message::create([...]);
broadcast(new \App\Events\NewMessage($message))->toOthers();
```

#### Lado del Cliente (Recepción con Laravel Echo)
El frontend debe suscribirse al canal privado usando el token de Passport:
```javascript
import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');

const echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    wsHost: 'wss.jlssystem.com',
    wsPort: 6001,
    forceTLS: true,
    disableStats: true,
    authEndpoint: '/api/broadcasting/auth',
    auth: {
        headers: {
            Authorization: 'Bearer ' + token
        }
    }
});

echo.private(`new-message.${usuarioId}`)
    .listen('.NewMessage', (e) => {
        console.log('Nuevo mensaje recibido:', e.message);
    });
```

---

## 🛠️ Instalación y Configuración

1.  **Clonar el repositorio e instalar dependencias:**
    ```bash
    composer install
    npm install
    ```
2.  **Configurar variables de entorno:**
    Copia el archivo `.env.example` a `.env` y configura tus credenciales de base de datos y llaves de Pusher.
3.  **Generar llaves y ejecutar migraciones:**
    ```bash
    php artisan key:generate
    php artisan migrate
    php artisan passport:install
    ```
4.  **Configuración del Servidor WebSocket:**
    Asegúrate de que `BROADCAST_DRIVER=pusher` esté configurado en tu `.env`.

---

## 🛣️ Endpoints Principales (API)

Todos los endpoints protegidos requieren el header: `Authorization: Bearer {token}`.

### Autenticación
*   `POST /api/login`: Inicio de sesión y obtención de token.
*   `GET /api/logout`: Cierre de sesión (Protegido).

### Gestión de Chats
*   `POST /api/storeChat`: Crea una nueva conversación.
*   `GET /api/chatsAuthU/{id}`: Obtiene chats donde el usuario es emisor.
*   `GET /api/chatsAuthM/{id}`: Obtiene chats donde el usuario es receptor.

### Mensajería
*   `POST /api/sendMessage`: Envío de mensajes de texto.
*   `POST /api/sendMessageFile`: Envío de archivos adjuntos.
*   `POST /api/sendMessageAudio`: Envío de notas de voz (.ogg).
*   `GET /api/getMessage/{id}`: Obtiene el historial de un chat.
*   `GET /api/download/{id}`: Descarga de adjuntos de un mensaje.

---

## 📁 Almacenamiento
*   **Archivos/Adjuntos:** Se almacenan en `storage/app/messages`.
*   **Avatares/Imágenes:** Disponibles en `public/storage/images`.

---

Desarrollado para **JLS System**.
