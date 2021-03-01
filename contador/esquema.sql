CREATE TABLE IF NOT EXISTS visitas(
    fecha VARCHAR(10) NOT NULL,
    ip VARCHAR(255) NOT NULL,
    pagina VARCHAR(255) NOT NULL,
    url VARCHAR(255) NOT NULL
);

ALTER TABLE visitas ADD INDEX indice_fecha (fecha);
