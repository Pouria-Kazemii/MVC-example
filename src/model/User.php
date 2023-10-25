<?php
namespace MVC\model ;
use MVC\core\DbModel;

class User extends DbModel
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETE = 2;
    public string $fullname = '';
    public string $email = '';
    public int $status = self::STATUS_INACTIVE ;
    public string $password = '';
    public string $passwordConfirm = '';

    public function tableName()
    {
        return 'users';
    }

    public function attributes()
    {
        return ['fullname' , 'email' , 'password' , 'status'];
    }
    public function rule()
    {
        return [
            'fullname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED , self::RULE_EMAIL ,[
                self::RULE_UNIQUE , 'class' => self::class //,'attribute' => 'fullname'
            ]],
            'password' => [self::RULE_REQUIRED,[self::RULE_MIN , 'min'=>8],[self::RULE_MAX , 'max'=>10]],
            'passwordConfirm' => [self::RULE_REQUIRED , [self::RULE_MATCH , 'match' =>'password']]
        ];
    }

    public function save()
    {
        $this->status = self::STATUS_INACTIVE;
        $this->password = password_hash($this->password , PASSWORD_DEFAULT);
        return parent::save();
    }


}