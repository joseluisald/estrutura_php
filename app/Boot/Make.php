<?php

/**
 *
 */
class ComposerCommands
{
    /**
     * @param $themeName
     * @param $theme
     * @return void
     */
    public function theme($themeName, $theme = 'web')
    {
        //  GERAÇÃO DOS ARQUIVOS DE SRC
        $srcDirTemplate = __DIR__ . '/templates/src/';
        $destinationSrcDir = __DIR__ . '/../../src/'. $themeName.'/';
        $this->recursiveDirectoryCopy($srcDirTemplate, $destinationSrcDir);
        //  GERAÇÃO DOS ARQUIVOS DE SRC

        //  GERAÇÃO DOS ARQUIVOS DE VIEW
        $baseDir = __DIR__ . '/../View/'. $themeName;
        $dirsToCreate = [
            $baseDir,
            $baseDir . '/partials',
            $baseDir . '/pages'
        ];

        foreach ($dirsToCreate as $dir) {
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
        }

        $partialsDir = __DIR__ . '/templates/partials/';
        $destinationDir = $baseDir . '/partials/';
        $this->recursiveDirectoryCopy($partialsDir, $destinationDir);

        $pagesDir = __DIR__ . '/templates/pages/error.php';
        $destinationPagesDir = $baseDir . '/pages/error.php';

        if (copy($pagesDir, $destinationPagesDir)) {
            echo "Arquivo 'error.php' copiado com sucesso!\n";
        } else {
            echo "Falha ao copiar o arquivo 'error.php'.\n";
        }

        $layoutTemplateDir = __DIR__ . '/templates/layout.template.php';
        $indexTemplateDir = __DIR__ . '/templates/pages/index.php';

        $layoutTemplateContent = file_get_contents($layoutTemplateDir);
        $indexTemplateContent = file_get_contents($indexTemplateDir);

        if ($layoutTemplateContent === false || $indexTemplateContent === false) {
            echo "Erro ao ler os arquivos de template.\n";
            exit(1);
        }

        $layoutTemplateContent = str_replace('{{theme}}', $themeName, $layoutTemplateContent);
        $indexTemplateContent = str_replace('{{theme}}', $themeName, $indexTemplateContent);

        file_put_contents($baseDir . '/_layout.php', $layoutTemplateContent);
        file_put_contents($baseDir . '/pages/index.php', $indexTemplateContent);
        //  GERAÇÃO DOS ARQUIVOS DE VIEW

        echo "Tema '$themeName' criado com sucesso!\n";
    }

    /**
     * @param $name
     * @param $theme
     * @return void
     */
    public function resource($name, $theme = 'web')
    {
        $name = ucfirst($name);

        $controllerTemplatePath = __DIR__ . '/templates/controller.template.php';
        $serviceTemplatePath = __DIR__ . '/templates/service.template.php';
        $routeTemplatePath = __DIR__ . '/templates/route.template.php';
        $routesPath = __DIR__ . '/../Routes/Routes.php';

        $controllerContent = file_get_contents($controllerTemplatePath);
        $serviceContent = file_get_contents($serviceTemplatePath);
        $routeTemplateContent = file_get_contents($routeTemplatePath);

        if ($controllerContent === false || $serviceContent === false) {
            echo "Error reading template files.\n";
            exit(1);
        }

        $nameLcfirst = lcfirst($name);

        $controllerContent = str_replace('{{nameLc}}', $nameLcfirst, $controllerContent);
        $controllerContent = str_replace('{{theme}}', $theme, $controllerContent);
        $controllerContent = str_replace('{{name}}', $name, $controllerContent);
        $serviceContent = str_replace('{{name}}', $name, $serviceContent);

        $controllerPath = __DIR__ . "/../Controllers/{$name}.php";
        $servicePath = __DIR__ . "/../Services/{$name}Service.php";

        if (file_put_contents($controllerPath, $controllerContent) === false) {
            echo "Error creating Controller file.\n";
            exit(1);
        }

        if (file_put_contents($servicePath, $serviceContent) === false) {
            echo "Error creating Service file.\n";
            exit(1);
        }

        if ($routeTemplateContent === false) {
            echo "Error reading route template file.\n";
            exit(1);
        }

        $nameUpper = strtoupper($name);
        $nameLower = strtolower($name);

        $routeTemplateContent = str_replace('{{nameUpper}}', $nameUpper, $routeTemplateContent);
        $routeTemplateContent = str_replace('{{name}}', $name, $routeTemplateContent);
        $routeTemplateContent = str_replace('{{nameLower}}', $nameLower, $routeTemplateContent);

        if (file_put_contents($routesPath, $routeTemplateContent, FILE_APPEND) === false) {
            echo "Error adding route to Routes file.\n";
            exit(1);
        }

        echo "Controller, Service, and route generated successfully!\n";
    }

    /**
     * @param $args
     * @return void
     */
    public function execute($args) {
        if (count($args) < 3) {
            echo "Uso: php Make.php make <comando> <argumento>\n";
            exit(1);
        }

        $command = $args[1];
        $controler = @explode(':', $args[2]);
        $argument = $controler[0];
        $theme = isset($controler[1]) ? $controler[1] : 'web';

        if (method_exists($this, $command)) {
            $this->$command($argument, $theme);
        } else {
            echo "Comando não reconhecido.\n";
            exit(1);
        }
    }

    /**
     * @param $source
     * @param $destination
     * @return void
     */
    private function recursiveDirectoryCopy($source, $destination)
    {
        if (!is_dir($destination)) {
            mkdir($destination, 0777, true);
        }

        $dir = opendir($source);

        while (($file = readdir($dir)) !== false) {
            if ($file != '.' && $file != '..') {
                $sourceFile = $source . '/' . $file;
                $destinationFile = $destination . '/' . $file;
                $fileName = basename($file);

                if (is_dir($sourceFile)) {
                    $this->recursiveDirectoryCopy($sourceFile, $destinationFile);
                } else {
                    if (copy($sourceFile, $destinationFile)) {
                        echo "Arquivo '$fileName' copiado com sucesso!\n";
                    } else {
                        echo "Falha ao copiar o arquivo '$fileName'.\n";
                    }
                }
            }
        }

        closedir($dir);
    }
}

$composerCommands = new ComposerCommands();
$composerCommands->execute($argv);


