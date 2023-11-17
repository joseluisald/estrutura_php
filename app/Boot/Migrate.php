<?php
    // Defina a conexão com o banco de dados
    $dbHost = "seu_host";
    $dbName = "seu_banco_de_dados";
    $dbUser = "seu_usuario";
    $dbPass = "sua_senha";

    try {
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Erro na conexão com o banco de dados: " . $e->getMessage());
    }

    // Obtenha a lista de arquivos de migração na pasta "app/Migrations"
    $migrationFiles = glob(__DIR__ . '/../Migrations/*.php');

    foreach ($migrationFiles as $migrationFile) {
        // Inclua o arquivo de migração
        require $migrationFile;

        // Obtenha o nome da classe de migração
        $className = pathinfo($migrationFile, PATHINFO_FILENAME);

        // Crie uma instância da classe de migração
        $migration = new $className($pdo);

        // Execute a migração
        $migration->up();
    }

    echo "Migrações concluídas com sucesso." . PHP_EOL;
