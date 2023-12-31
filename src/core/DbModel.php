<?php

namespace MVC\core;

abstract class DbModel extends Model
{
    abstract public function tableName();
    abstract public function attributes();

    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $stmt = self::prepare("INSERT INTO $tableName (".implode(',', $attributes).")
                        VALUES(".implode(',', $params).")");
        foreach ($attributes as $attribute){
            $stmt->bindValue(":$attribute", $this->{$attribute});
        }
        $stmt->execute();
        return true;
    }

    public static function prepare($sql)
    {
        return Application::$app->database->pdo->prepare($sql);
    }
}