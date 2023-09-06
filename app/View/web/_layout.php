<!DOCTYPE html>
<html>
    <head>
        <!--START HEAD-->
            <?= $this->insert('web::partials/head') ?>
        <!--END HEAD-->
        <!--START CONSTANTS-->
            <?= $this->insert('web::partials/constants') ?>
        <!--END CONSTANTS-->
    </head>
    <body>
        <div class="loading"></div>
        <!--START GTMBODY-->
            <?=$gtmBody;?>
        <!--END GTMBODY-->
        <!--START CONTENT-->
            <?= $this->section("content"); ?>
        <!--END CONTENT-->
        <!--START FOOTER-->
            <?= $this->insert('web::partials/footer') ?>
        <!--END FOOTER-->
        <!--START SCRIPTS-->
            <?= $this->insert('web::partials/scripts') ?>
        <!--END SCRIPTS-->
        <!--START SCRIPTS SECTION-->
            <?= $this->section("scripts"); ?>
        <!--END SCRIPTS SECTION-->
    </body>
</html>

