# Plataforma Digital Educativa Preescolar con Realidad Aumentada

Esta plataforma web está diseñada para proporcionar una experiencia educativa interactiva para niños en edad preescolar, incorporando elementos de realidad aumentada para hacer el aprendizaje más atractivo y efectivo.

## Características Principales

- Sistema de niveles educativos preescolares
- Integración de Realidad Aumentada
- Interfaz amigable para niños
- Sistema de seguimiento de progreso
- Contenido educativo interactivo

## Requisitos del Sistema

- XAMPP (PHP 7.4 o superior)
- MySQL
- Navegador web moderno con soporte para WebGL
- Cámara web para funcionalidades de RA

## Instalación

1. Clonar o descargar este repositorio en la carpeta htdocs de XAMPP
2. Importar la base de datos desde el archivo `database/educa_ar.sql`
3. Configurar la conexión a la base de datos en `config/database.php`
4. Acceder a la plataforma a través de `http://localhost/PG1`

## Estructura del Proyecto

```
PG1/
├── assets/
│   ├── css/
│   ├── js/
│   ├── images/
│   └── models/ (modelos 3D para RA)
├── config/
│   └── database.php
├── includes/
│   ├── header.php
│   └── footer.php
├── levels/
│   ├── level1.php
│   ├── level2.php
│   └── level3.php
├── ar/
│   └── ar_engine.php
├── index.php
└── README.md
```

## Tecnologías Utilizadas

- PHP
- MySQL
- HTML5
- CSS3
- JavaScript
- AR.js (para Realidad Aumentada)
- Three.js (para gráficos 3D)

## Contribución

Este es un proyecto en desarrollo. Las contribuciones son bienvenidas.

## Licencia

Este proyecto está bajo la Licencia MIT. 