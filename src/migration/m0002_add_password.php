<?php

class m0002_add_password
{
    public function up()
    {
        $db = \MVC\core\Application::$app->database;
        $sql = "ALTER TABLE users ADD COLUMN password VARCHAR(225) NOT NULL ";
        $db->pdo->exec($sql);
    }

    public function down()
    {
        $db = \MVC\core\Application::$app->database;
        $sql = "ALTER TABLE users DROP COLUMN password";
        $db->pdo->exec($sql);
    }
}