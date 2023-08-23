<!DOCTYPE html>
<html>
    <head>
        <?= $this->insert('web::partials/head') ?>
        <?= $this->insert('web::partials/constants') ?>
    </head>
    <body>
        <div class="loading"></div>
        <?= $this->section("content"); ?>

        <?= $this->insert('web::partials/footer') ?>
        <?= $this->insert('web::partials/scripts') ?>
        <?= $this->section("scripts"); ?>
    </body>
</html>