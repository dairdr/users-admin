Users Admin Webapp
========================

Webapp para la administración de usuarios, grupos y roles.


Escructura del poryecto
------------------------

El proyecto esta relizado bajo la estructura de Symfony 2.7, contiene los siguientes directorios:

  * src: reside el código de la lógica del negocio.

  * app: contiene la configuración genral y específica de cada bundle, tambien contiene la cache
  y archivos para ejecutar comandos de tareas rutinarias al momento de del desarrollo y producción.

  * bin: archivos compilados

  * vendor: librerias y deppendencias de symfony y de los bundles desarrollados.

  * web: carpeta publica expuesta para el inicio de toda la app, incluye los assets y archivos estáticos.


El directorio src contien los bundles necesarios, los cuales son:
  * AdminBundle: contiene la lógica del administrador para el super admin del sistema.
  * UserBundle: maneja la parte del usuario cliente y agente, vistas, modelos y controladores.


Librerias usadas (Adicinalmente de las dependencias propias de Symfony 2.7)
----------------------------------------------------------------------------

[1]:  "sonata-project/admin-bundle" crea la mayor parte de la lógica administrativa de la aplicación
es fácilemnte configuable y extendible.

[2]:  "friendsofsymfony/facebook-bundle" es requerida para la autenticación con Facebook Connect,
es de los frameworks más sencillos para realizar esta tarea, aunque ya esta deprecada.

