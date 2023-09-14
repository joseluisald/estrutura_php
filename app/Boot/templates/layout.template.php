<!DOCTYPE html>
<html>
    <head>
        <!--START HEAD-->
            <?= $this->insert('{{theme}}::partials/head') ?>
        <!--END HEAD-->
        <!--START CONSTANTS-->
            <?= $this->insert('{{theme}}::partials/constants') ?>
        <!--END CONSTANTS-->
    </head>
    <body>
        <div class="loading"></div>
        <!--START GTMBODY-->
            <?=$gtmBody;?>
        <!--END GTMBODY-->
        <!--START LOADER-->
            <?= $this->insert("admin::partials/loader"); ?>
        <!--END LOADER-->
        <!--START CONTENT-->
            <?= $this->section("content"); ?>
        <!--END CONTENT-->
        <!--START FOOTER-->
            <?= $this->insert('{{theme}}::partials/footer') ?>
        <!--END FOOTER-->
        <!--START SCRIPTS-->
            <?= $this->insert('{{theme}}::partials/scripts') ?>
        <!--END SCRIPTS-->
        <!--START SCRIPTS SECTION-->
            <?= $this->section("scripts"); ?>
        <!--END SCRIPTS SECTION-->
    </body>
</html>