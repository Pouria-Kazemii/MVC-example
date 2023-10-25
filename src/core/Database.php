<?php

namespace MVC\core;

class Database
{
    public \PDO $pdo;

    public function __construct(array $config)
    {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';
        $this->pdo = new \PDO($dsn,$user,$password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE , \PDO::ERRMODE_EXCEPTION);
    }

    public function applyMigration()
    {
        $this->createMigrationTable();
        $appliedMigration = $this->getAppliedMigrations();

        $newMigrations = [];
        $files = scandir(Application::$ROOT_DIR.'/migration');
        $toApplyMigrations = array_diff($files,$appliedMigration);
        foreach ($toApplyMigrations as $migration){
            if ($migration === '.' || $migration === '..'){
                continue;
            }
            require_once $x = Application::$ROOT_DIR.'/migration/'.$migration;
            $classname = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $classname();
            $this->log("applying migration $migration");
            $instance->up();
            $this->log("applied migration $migration");
            $newMigrations[] = $migration;
        }
        if(!empty($newMigrations)){
            $this->savedMigrations($newMigrations);
        }else{
            $this->log("all migration are applied");
        }
    }

    public function createMigrationTable()
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
             id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(225),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;");
    }

    public function getAppliedMigrations()
    {
        $stmt = $this->pdo->prepare("SELECT migration from migrations");
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function savedMigrations(array $migration)
    {
        $str =implode(',',array_map(fn($m) => "('$m')" , $migration));
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES 
                   $str
                   ");
        $statement->execute();
    }

    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }

    protected function log($massage)
    {
        echo '['.date('Y-m-d H:i:s').'] - '.$massage.PHP_EOL;
    }

}