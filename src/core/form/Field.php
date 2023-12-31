<?php

namespace MVC\core\form;

use MVC\core\Model;

class Field
{
    public Model $model;
    public string $attribute;

    public function __construct(Model $model , $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }

    public function __toString(): string
    {
        return sprintf('
            <div class="form-group">
                <label>%s</label>
                <input type="text" name="%s"  value="%s" class="form-control %s"  >
                <div class="invalid-feedback">
                    %s
                </div>
            </div>'
            ,
            $this->attribute,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->hasError($this->attribute) ? 'is-invalid' : '',
            $this->model->getFirstError($this->attribute)
        );
    }
}