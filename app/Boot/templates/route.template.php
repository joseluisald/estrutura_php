
/* {{nameUpper}} */
$router->group("{{nameLower}}")->namespace("App\Controllers\{{themeUcfirst}}");
$router->get("/", "{{name}}:index", "{{nameLower}}.index");
