<?php
/*

  ____          _____               _ _           _       
 |  _ \        |  __ \             (_) |         | |      
 | |_) |_   _  | |__) |_ _ _ __ _____| |__  _   _| |_ ___ 
 |  _ <| | | | |  ___/ _` | '__|_  / | '_ \| | | | __/ _ \
 | |_) | |_| | | |  | (_| | |   / /| | |_) | |_| | ||  __/
 |____/ \__, | |_|   \__,_|_|  /___|_|_.__/ \__, |\__\___|
         __/ |                               __/ |        
        |___/                               |___/         
    
____________________________________
/ Si necesitas ayuda, contáctame en \
\ https://parzibyte.me               /
 ------------------------------------
        \   ^__^
         \  (oo)\_______
            (__)\       )\/\
                ||----w |
                ||     ||
Creado por Parzibyte (https://parzibyte.me).
------------------------------------------------------------------------------------------------
Si el código es útil para ti, puedes agradecerme siguiéndome: https://parzibyte.me/blog/sigueme/
Y compartiendo mi blog con tus amigos
También tengo canal de YouTube: https://www.youtube.com/channel/UCroP4BTWjfM0CkGB6AFUoBg?sub_confirmation=1
------------------------------------------------------------------------------------------------
*/ ?>
<?php

function fechaInicioYFinDeMes()
{

    $inicio = date("Y-m-01");
    $fin = date("Y-m-t");
    return [$inicio, $fin];
}
function fechaHoy()
{
    return date("Y-m-d");
}
/*
Nota: está limitado a solo traer los 10 primeros registros, ordenados por las veces que se visitaron
*/
function obtenerPaginasVisitadasEnFecha($fecha)
{
    $consulta = "SELECT COUNT(*) AS conteo_visitas, count(distinct ip) as conteo_visitantes, url, pagina
    from visitas where fecha = ?
    group by url, pagina
    ORDER BY conteo_visitas DESC
    LIMIT 10;";
    $bd = obtenerConexion();
    $sentencia = $bd->prepare($consulta);
    $sentencia->execute([$fecha]);
    return $sentencia->fetchAll();
}

function obtenerConteoVisitasYVisitantesDePaginaEnRango($fechaInicio, $fechaFin, $url)
{
    return (object)[
        "visitantes" => obtenerConteoVisitantesDePaginaEnRango($fechaInicio, $fechaFin, $url),
        "visitas" => obtenerConteoVisitasDePaginaEnRango($fechaInicio, $fechaFin, $url),
    ];
}
function obtenerConteoVisitantesDePaginaEnRango($fechaInicio, $fechaFin, $url)
{
    $bd = obtenerConexion();
    $sentencia = $bd->prepare("SELECT COUNT(DISTINCT ip) AS conteo FROM visitas WHERE fecha >= ? AND fecha <= ? AND url = ?");
    $sentencia->execute([$fechaInicio, $fechaFin, $url]);
    return $sentencia->fetchObject()->conteo;
}

function obtenerConteoVisitasDePaginaEnRango($fechaInicio, $fechaFin, $url)
{
    $bd = obtenerConexion();
    $sentencia = $bd->prepare("SELECT COUNT(*) AS conteo FROM visitas WHERE fecha >= ? AND fecha <= ? AND url = ?");
    $sentencia->execute([$fechaInicio, $fechaFin, $url]);
    return $sentencia->fetchObject()->conteo;
}
function obtenerVisitantesDePaginaEnRango($fechaInicio, $fechaFin, $url)
{
    $bd = obtenerConexion();
    $sentencia = $bd->prepare("SELECT fecha, COUNT(DISTINCT ip) AS conteo FROM visitas WHERE fecha >= ? AND fecha <= ? AND url = ? GROUP BY fecha");
    $sentencia->execute([$fechaInicio, $fechaFin, $url]);
    return $sentencia->fetchAll();
}
function obtenerVisitasDePaginaEnRango($fechaInicio, $fechaFin, $url)
{
    $bd = obtenerConexion();
    $sentencia = $bd->prepare("SELECT fecha, COUNT(*) AS conteo FROM visitas WHERE fecha >= ? AND fecha <= ? AND url = ? GROUP BY fecha");
    $sentencia->execute([$fechaInicio, $fechaFin, $url]);
    return $sentencia->fetchAll();
}

function obtenerConteoVisitasYVisitantesEnRango($fechaInicio, $fechaFin)
{
    return (object)[
        "visitantes" => obtenerConteoVisitantesEnRango($fechaInicio, $fechaFin),
        "visitas" => obtenerConteoVisitasEnRango($fechaInicio, $fechaFin),
    ];
}

function obtenerConteoVisitantesEnRango($fechaInicio, $fechaFin)
{
    $bd = obtenerConexion();
    $sentencia = $bd->prepare("SELECT COUNT(DISTINCT ip) AS conteo FROM visitas WHERE fecha >= ? AND fecha <= ?");
    $sentencia->execute([$fechaInicio, $fechaFin]);
    return $sentencia->fetchObject()->conteo;
}

function obtenerConteoVisitasEnRango($fechaInicio, $fechaFin)
{
    $bd = obtenerConexion();
    $sentencia = $bd->prepare("SELECT COUNT(*) AS conteo FROM visitas WHERE fecha >= ? AND fecha <= ?");
    $sentencia->execute([$fechaInicio, $fechaFin]);
    return $sentencia->fetchObject()->conteo;
}

function obtenerVisitantesEnRango($fechaInicio, $fechaFin)
{
    $bd = obtenerConexion();
    $sentencia = $bd->prepare("SELECT fecha, COUNT(DISTINCT ip) AS conteo FROM visitas WHERE fecha >= ? AND fecha <= ? GROUP BY fecha");
    $sentencia->execute([$fechaInicio, $fechaFin]);
    return $sentencia->fetchAll();
}
function obtenerVisitasEnRango($fechaInicio, $fechaFin)
{
    $bd = obtenerConexion();
    $sentencia = $bd->prepare("SELECT fecha, COUNT(*) AS conteo FROM visitas WHERE fecha >= ? AND fecha <= ? GROUP BY fecha");
    $sentencia->execute([$fechaInicio, $fechaFin]);
    return $sentencia->fetchAll();
}
function registrarVisita($pagina, $url)
{
    $fecha = date("Y-m-d");
    $ip = $_SERVER["REMOTE_ADDR"] ?? "";
    $bd = obtenerConexion();
    $sentencia = $bd->prepare("INSERT INTO visitas(fecha, ip, pagina, url) VALUES(?, ?, ?, ?)");
    return $sentencia->execute([$fecha, $ip, $pagina, $url]);
}

function obtenerVariableDelEntorno($key)
{
    if (defined("_ENV_CACHE")) {
        $vars = _ENV_CACHE;
    } else {
        $file = "env.php";
        if (!file_exists($file)) {
            throw new Exception("El archivo de las variables de entorno ($file) no existe. Favor de crearlo");
        }
        $vars = parse_ini_file($file);
        define("_ENV_CACHE", $vars);
    }
    if (isset($vars[$key])) {
        return $vars[$key];
    } else {
        throw new Exception("La clave especificada (" . $key . ") no existe en el archivo de las variables de entorno");
    }
}
function obtenerConexion()
{
    $password = obtenerVariableDelEntorno("MYSQL_PASSWORD");
    $user = obtenerVariableDelEntorno("MYSQL_USER");
    $dbName = obtenerVariableDelEntorno("MYSQL_DATABASE_NAME");
    $database = new PDO('mysql:host=localhost;dbname=' . $dbName, $user, $password);
    $database->query("set names utf8;");
    $database->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    return $database;
}
