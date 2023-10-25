<?php

namespace MVC\core;

abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MAX = 'max';
    public const RULE_MIN = 'min';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';
    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if(property_exists($this , $key)){
                $this->{$key} = $value;
            }

        }
    }

    abstract public function rule();

    public array $errors = [];
    public function validate()
    {
        foreach ($this->rule() as $attribute => $rules){
            $value = $this->{$attribute};
           foreach ($rules as $rule){
              $ruleName = $rule;
              if(!is_string($ruleName)){
                  $ruleName = $rule[0];
              }
              if($ruleName === self::RULE_REQUIRED && !$value){
                  $this->addErrors($attribute , self::RULE_REQUIRED);
              }
              if($ruleName === self::RULE_EMAIL && !filter_var($value , FILTER_VALIDATE_EMAIL)){
                  $this->addErrors($attribute , self::RULE_EMAIL);
              }
              if($ruleName === self::RULE_MIN && strlen($value) < $rule['min']){
                  $this->addErrors($attribute , self::RULE_MIN , $rule);
              }
               if($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                   $this->addErrors($attribute, self::RULE_MAX , $rule);
               }
               if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                   $this->addErrors($attribute, self::RULE_MATCH , $rule);
               }
               if ($ruleName === self::RULE_UNIQUE){
                   $className = $rule['class'];
                   $uniqueAttr = $rule['attribute'] ?? $attribute;
                   $tableName = $className::tableName();
                   $stmt = Application::$app->database->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
                   $stmt->bindValue(":attr" , $value);
                   $stmt->execute();
                   $record = $stmt->fetchObject();
                   if($record){
                       $this->addErrors($attribute , self::RULE_UNIQUE , ['field' => $attribute ]);
                   }
               }
           }
        }
        return empty($this->errors);
    }

    public function addErrors($attribute , $rule , $params = [])
    {
        $message = $this->errorMessage()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}" , $value , $message);
        }
        $this->errors[$attribute][] = $message;
    }

    public function errorMessage()
    {
        return [
            self::RULE_REQUIRED => 'this is require',
            self::RULE_EMAIL => 'email is not valid',
            self::RULE_MIN => 'length must be min {min}',
            self::RULE_MAX => 'length must be max {max}',
            self::RULE_MATCH => 'this is most be same as {match}',
            self::RULE_UNIQUE => 'record whit this {field} is already exist',

        ];
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
}