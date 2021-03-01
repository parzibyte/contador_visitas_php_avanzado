<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de visitas - By Parzibyte</title>
    <link rel="stylesheet" href="https://unpkg.com/bulma@0.9.1/css/bulma.min.css">
</head>

<body>
    <nav class="navbar is-warning" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="https://parzibyte.me/blog">
                <img alt="" src="https://raw.githubusercontent.com/parzibyte/ejemplo-mern/master/src/img/parzibyte_logo.png" style="max-height: 80px" />
            </a>
            <button class="navbar-burger is-warning button" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </button>
        </div>
        <div class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item" href="dashboard.php">Dashboard</a>
            </div>
            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                        <a target="_blank" rel="noreferrer" href="https://parzibyte.me/l/fW8zGd" class="button is-primary">
                            <strong>Soporte y ayuda</strong>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", () => {
            const boton = document.querySelector(".navbar-burger");
            const menu = document.querySelector(".navbar-menu");
            boton.onclick = () => {
                menu.classList.toggle("is-active");
                boton.classList.toggle("is-active");
            };
        });
    </script>
    <?php
    include_once "funciones.php";
    $hoy = fechaHoy();
    $visitasYVisitantes = obtenerConteoVisitasYVisitantesDeHoy();
    $paginas = obtenerPaginasVisitadasEnFecha($hoy);
    ?>
    <section class="section">
        <div class="columns">
            <div class="column is-one-third ">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            Estadísticas de hoy (<?php echo $hoy ?>)
                        </p>

                    </header>
                    <div class="card-content">
                        <div class="content">
                            <div class="field is-grouped is-grouped-multiline">
                                <div class="control">
                                    <div class="tags has-addons">
                                        <span class="tag is-success is-large">Visitas</span>
                                        <span class="tag is-info is-large"><?php echo $visitasYVisitantes->visitas ?></span>
                                    </div>
                                </div>
                                <div class="control">
                                    <div class="tags has-addons">
                                        <span class="tag is-warning is-large">Visitantes</span>
                                        <span class="tag is-info is-large"><?php echo $visitasYVisitantes->visitantes ?></span>
                                    </div>
                                </div>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Página</th>
                                        <th>Visitas</th>
                                        <th>Visitantes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($paginas as $pagina) { ?>
                                        <tr>
                                            <td><a target="_blank" href="<?php echo $pagina->url ?>"><?php echo $pagina->pagina ?></a></td>
                                            <td><?php echo $pagina->conteo_visitas ?></td>
                                            <td><?php echo $pagina->conteo_visitantes ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <footer class="card-footer">
                        <small class="mx-2 my-2">By parzibyte</small>
                    </footer>
                </div>
            </div>
            <div class="column">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            Estadísticas de hoy (<?php echo $hoy ?>)
                        </p>

                    </header>
                    <div class="card-content">
                        <div class="content">
                            <div class="field is-grouped is-grouped-multiline">
                                <div class="control">
                                    <div class="tags has-addons">
                                        <span class="tag is-success is-large">Visitas</span>
                                        <span class="tag is-info is-large"><?php echo $visitasYVisitantes->visitas ?></span>
                                    </div>
                                </div>
                                <div class="control">
                                    <div class="tags has-addons">
                                        <span class="tag is-warning is-large">Visitantes</span>
                                        <span class="tag is-info is-large"><?php echo $visitasYVisitantes->visitantes ?></span>
                                    </div>
                                </div>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Página</th>
                                        <th>Visitas</th>
                                        <th>Visitantes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($paginas as $pagina) { ?>
                                        <tr>
                                            <td><a target="_blank" href="<?php echo $pagina->url ?>"><?php echo $pagina->pagina ?></a></td>
                                            <td><?php echo $pagina->conteo_visitas ?></td>
                                            <td><?php echo $pagina->conteo_visitantes ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <footer class="card-footer">
                        <small class="mx-2 my-2">By parzibyte</small>
                    </footer>
                </div>
            </div>
        </div>

    </section>
</body>

</html>