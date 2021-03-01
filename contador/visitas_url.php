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
*/ ?><?php include_once "encabezado.php"; ?>
<?php
if (!isset($_GET["url"])) {
    exit("No hay URL");
}
$url = urldecode($_GET["url"]);
include_once "funciones.php";

$hoy = fechaHoy();
list($inicio, $fin) = fechaInicioYFinDeMes();
if (isset($_GET["inicio"])) {
    $inicio = $_GET["inicio"];
}
if (isset($_GET["fin"])) {
    $fin = $_GET["fin"];
}
$visitasYVisitantes = obtenerConteoVisitasYVisitantesDePaginaEnRango($inicio, $fin, $url);
$visitasYVisitantes = obtenerConteoVisitasYVisitantesEnRango($hoy, $hoy);
$visitantes = obtenerVisitantesDePaginaEnRango($inicio, $fin, $url);
$visitas = obtenerVisitasDePaginaEnRango($inicio, $fin, $url);
?>
<section class="section">
    <div class="columns">
        <div class="column">

            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">
                        Estadísticas para <?php echo $url ?> entre <?php echo $inicio ?> y <?php echo $fin ?>
                    </p>
                </header>
                <div class="card-content">
                    <div class="content">
                        <a class="button is-info mb-2" href="dashboard.php">
                            <i class="fa fa-arrow-left"></i>
                            &nbsp;
                            Volver</a>
                        <form action="visitas_url.php">
                            <input type="hidden" value="<?php echo $url ?>" name="url">
                            <div class="field is-grouped">
                                <p class="control is-expanded">
                                    <label>Desde: </label>
                                    <input class="input" type="date" name="inicio" value="<?php echo $inicio ?>">
                                </p>
                                <p class="control is-expanded">
                                    <label>Hasta: </label>
                                    <input class="input" type="date" name="fin" value="<?php echo $fin ?>">
                                </p>
                                <p class="control">
                                    <!--La etiqueta es invisible a propósito para que tome el espacio y alinee el botón-->
                                    <label style="color: white;">ª</label>
                                    <input type="submit" value="Filtrar" class="button is-success input">
                                </p>
                            </div>
                        </form>
                        <canvas id="grafica"></canvas>
                    </div>
                </div>
                <footer class="card-footer">
                    <small class="mx-2 my-2">By parzibyte</small>
                </footer>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    // Pasar variable de PHP a JS
    const visitantes = <?php echo json_encode($visitantes) ?>;
    const visitas = <?php echo json_encode($visitas) ?>;
    // Obtener una referencia al elemento canvas del DOM
    const $grafica = document.querySelector("#grafica");
    // Las etiquetas son las que van en el eje X. 
    // Podemos mapear  visitas o visitantes, ya que solo necesitamos las fechas
    const etiquetas = visitas.map(visita => visita.fecha);
    // Podemos tener varios conjuntos de datos
    const datosVisitas = {
        label: "Visitas",
        data: visitas.map(visita => visita.conteo),
        backgroundColor: 'rgba(237,78,136, 0.2)', // Color de fondo
        borderColor: 'rgba(237,78,136, 1)', // Color del borde
        borderWidth: 1, // Ancho del borde
    };
    const datosVisitantes = {
        label: "Visitantes",
        data: visitantes.map(visitante => visitante.conteo),
        backgroundColor: 'rgba(93,82,247, 0.2)', // Color de fondo
        borderColor: 'rgba(93,82,247,1)', // Color del borde
        borderWidth: 1, // Ancho del borde
    };

    new Chart($grafica, {
        type: 'line', // Tipo de gráfica
        data: {
            labels: etiquetas,
            datasets: [
                datosVisitas,
                datosVisitantes,
                // Aquí más datos...
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }],
            },
        }
    });
</script>
<?php include_once "pie.php" ?>