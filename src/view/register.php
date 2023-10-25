<?php
use MVC\core\form\Form;
use MVC\core\Application;
?>
<h1>register</h1>
<?php $form =  Form::begin('','post') ?>
    <?php echo $form->field($model , 'fullname') ?>
    <?php echo $form->field($model , 'email') ?>
    <?php echo $form->field($model , 'password') ?>
    <?php echo $form->field($model , 'passwordConfirm') ?>
    <button type="submit" class="btn btn-primary my-2">Submit</button>
<?php Form::end() ?>
