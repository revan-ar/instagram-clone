<?php

declare(strict_types=1);

namespace Tests;

use App\Infrastructure\Connection;

class DataBaseSetUp
{
    public static function up(): void
    {
        $password1 = password_hash('password1', PASSWORD_DEFAULT);
        $password2 = password_hash('password2', PASSWORD_DEFAULT);
        $actualDate = now();

        Connection::getInstance()->getConnection()->exec("
                DROP TABLE IF EXISTS users;

                CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username varchar(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                name varchar(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                created_at DATETIME,
                updated_at DATETIME,
                UNIQUE (email, username));

                INSERT INTO users (username, email, name, password, created_at, updated_at) VALUES ('user1', 'user1@mail.com', 'User One', '{$password1}', '{$actualDate}', '{$actualDate}');
                INSERT INTO users (username, email, name, password, created_at, updated_at) VALUES ('user2', 'user2@mail.com', 'User Two', '{$password2}', '{$actualDate}', '{$actualDate}');
        ");
    }
}
