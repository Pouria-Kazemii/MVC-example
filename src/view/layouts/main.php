<?php
use MVC\core\Application;
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
    <div class="mx-5">
        <a class="navbar-brand" href="/">home</a>
        <a class="navbar-brand" href="/contact">contact</a>
        <a class="navbar-brand" href="/login">login</a>
        <a class="navbar-brand" href="/register">register</a>
    </div>
</nav>
<div class="mx-3">
    <?php if(Application::$app->session->getFlash('success')): ?>
    <div class="alert alert-success">
        <?php echo Application::$app->session->getFlash('success'); ?>
    </div>
    <?php endif; ?>
    {{content}}
</div>
</body>
</html>
