<!DOCTYPE html>
<html>
<head>
    <?= $this->insert('{{theme}}::partials/head') ?>
    <?= $this->insert('{{theme}}::partials/constants') ?>
</head>
<body>
<div class="loading"></div>
<?= $this->section("content"); ?>

<?= $this->insert('{{theme}}::partials/footer') ?>
<?= $this->insert('{{theme}}::partials/scripts') ?>
<?= $this->section("scripts"); ?>
</body>
</html>