<?php

use osoznan\patri\Top;

$phone = Top::$app->getConfig('phone');
$phoneFull = Top::$app->getConfig('phoneFull');
$email = Top::$app->getConfig('email')

?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="robots" content="noindex">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel = "stylesheet" href = "/css/bootstrap.min.css">
        <link rel = "stylesheet" href = "/css/main.css">
    </head>
    <body>

        <?= $content; ?>

        <div class="progress-indicator"><img src="/images/progress.gif"></div>

        <script src="/js/vue.min.js"></script>
        <script src="/js/system.js"></script>
        <script src="/js/main.js"></script>

    </body>
</html>
