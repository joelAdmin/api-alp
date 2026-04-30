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

## 📡 Integración de WebSockets

El sistema utiliza un servidor de WebSockets independiente para la transmisión de eventos.

**Configuración (`config/broadcasting.php`):**
*   **Host:** `wss.jlssystem.com`
*   **Puerto:** `6001`
*   **Canales Privados:** Protegidos mediante `auth:api`.

**Eventos Principales:**
1.  **`NewMessage`**: Transmitido en el canal privado `new-message.{receptor_id}`.
2.  **`Mensaje`**: Transmitido en el canal público `MensajeChannel`.

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
