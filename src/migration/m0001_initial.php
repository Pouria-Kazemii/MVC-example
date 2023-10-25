<?php
class m0001_initial
{
    public function up()
    {
        $db = \MVC\core\Application::$app->database;
        $sql ="CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(225) NOT NULL ,
                fullname VARCHAR(225) NOT NULL ,
                status TINYINT NOT NULL ,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=INNODB;" ;
        $db->pdo->exec($sql);
    }

    public function down()
    {
        $db = \MVC\core\Application::$app->database;
        $sql ="DROP TABLE users" ;
        $db->pdo->exec($sql);    }
}