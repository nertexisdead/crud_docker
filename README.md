# Laravel Guest Management Microservice

## Описание проекта

Это микросервис для управления гостями, разработанный с использованием Laravel и запускаемый в Docker. Микросервис предоставляет API для создания, редактирования, обновления и удаления записей гостей.

## Требования

- Docker
- Docker Compose

## Инструкция по запуску

1. Клонируйте репозиторий на свой локальный компьютер:

    ```sh
    git clone https://github.com/nertexisdead/crud_docker.git
    cd имя-репозитория
    ```

2. Создайте файл `.env` в корневой директории проекта и скопируйте в него содержимое из `.env.example`. Обновите переменные окружения, если это необходимо:

    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=apiClients
    DB_USERNAME=root
    DB_PASSWORD=secret
    ```

3. Запустите контейнеры Docker:

    ```sh
    docker-compose up -d
    ```

4. Выполните миграции базы данных:

    ```sh
    docker-compose exec app php artisan migrate
    ```

5. Приложение будет доступно по адресу [http://localhost:8000]

## API Документация

### Получение списка гостей

**Запрос:**

```http
GET /api/guests
 ```

**Описание:**

Возвращает список всех гостей.

**Пример ответа:**

[
    {
        "id": 1,
        "first_name": "Имя",
        "last_name": "Фамилия",
        "email": "example@example.com",
        "phone": "+795262460405",
        "country": "Россия"
    },
    {
        "id": 2,
        "first_name": "Другое имя",
        "last_name": "Другая фамилия",
        "email": "another@example.com",
        "phone": "+79123456789",
        "country": "Россия"
    },
    ...
]

### Получение информации о госте по ID

**Запрос:**

```http
GET api/guests/{id}
 ```

**Описание:**

Возвращает информацию о госте по его уникальному идентификатору.

**Пример ответа:**

{
    "id": 1,
    "first_name": "Имя",
    "last_name": "Фамилия",
    "email": "example@example.com",
    "phone": "+795262460405",
    "country": "Россия"
}

### Создание нового гостя

**Запрос:**

```http
POST /api/guests/save
Content-Type: application/json

{
    "first_name": "Новое имя",
    "last_name": "Новая фамилия",
    "email": "new@example.com",
    "phone": "+791234567890",
    "country": "Россия"
}

**Описание:**

Создает новую запись гостя с указанными данными.

**Пример ответа:**

{
    "id": 3,
    "first_name": "Новое имя",
    "last_name": "Новая фамилия",
    "email": "new@example.com",
    "phone": "+791234567890",
    "country": "Россия"
}

### Обновление информации о госте

**Запрос:**

```http
POST /api/guests/update/{id}
Content-Type: application/json

{
    "first_name": "Измененное имя",
    "email": "updated@example.com"
}

**Описание:**

Обновляет информацию о госте по его уникальному идентификатору.

**Пример ответа:**

{
    "id": 1,
    "first_name": "Измененное имя",
    "last_name": "Фамилия",
    "email": "updated@example.com",
    "phone": "+795262460405",
    "country": "Россия"
}

### Удаление гостя

**Запрос:**

```http
DELETE /api/guests/delete/{id}

**Описание:**

Удаляет гостя по его уникальному идентификатору.

**Пример ответа:**

{
    "message": "Guest was deleted successfully"
}
