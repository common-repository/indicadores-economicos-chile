=== Indicadores Económicos Chile ===
Contributors:
Donate link: hhttps://ko-fi.com/mushroom47
Tags: indicadores, Chile, Economía, UF, Dolar
Requires at least: 4.0
Tested up to: 6.5.2
Stable tag: 1.1.0
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Muestra mediante un shortcode los Indicadores económicos actualizados en Chile.

== Description ==

Este plugin te permite mostrar en tu sitio web de WordPress los indicadores económicos actualizados de Chile a través de un shortcode fácil de usar. Podrás insertar estos indicadores en cualquier página o entrada con solo utilizar el shortcode correspondiente.

Características:

1. Muestra los indicadores económicos más relevantes de Chile: uf, dolar, euro, ipc, utm, ivp, imacec, tpm, dolar intercambio y bitcoin.
2. Personaliza la apariencia de los indicadores con los parámetros class e id.
3. Obtén datos actualizados diariamente de la API REST de Mindicador.cl.

== Installation ==

1. Sube la carpeta 'indicadores-economicos-chile' al directorio `/wp-content/plugins/` o instálalo directamente desde el panel de administración de WordPress en "Plugins".
2. Activa el plugin a través del menú 'Plugins' en WordPress.
3. Utiliza el shortcode correspondiente en tus páginas o entradas para mostrar los indicadores económicos.

== Modo de uso ==

Para mostrar los indicadores económicos, utiliza el siguiente shortcode en tus páginas o entradas:
[indicadores]

Parámetros del shortcode:

1. divisa: Opcional. Indica el indicador que deseas mostrar. Las opciones disponibles son: uf, dolar, euro, ipc, utm, ivp, imacec, tpm, dolar intercambio y bitcoin.
2. nombre: Opcional. Si se establece como true, muestra el nombre del indicador junto al valor.
3. class: Opcional. Asigna una clase CSS para personalizar el estilo del indicador.
4. id: Opcional. Asigna un ID único al elemento del indicador.

Ejemplo:
`[indicadores divisa="dolar" nombre="true" class="valor_dolar" id="id_dolar"]`


== Preguntas frecuentes ==

= ¿Puedo personalizar la apariencia de los indicadores? =
Sí, puedes personalizar la apariencia de los indicadores utilizando los parámetros class e id del shortcode.


= ¿Cómo puedo mostrar un indicador específico? =
Para mostrar un indicador específico, utiliza el parámetro divisa del shortcode. Por ejemplo, para mostrar el valor del dólar, utiliza el siguiente shortcode:
`[indicadores_chile divisa="dolar"]`

Las divisas aceptadas son:
uf, dolar, euro, ipc, utm, ivp, imacec, tpm, dolar intercambio y bitcoin.

= ¿De dónde se obtienen los datos?
Los datos se obtienen de la API REST de Mindicador.cl, que ofrece información actualizada diariamente sobre los indicadores económicos de Chile.

== Changelog ==

= 1.0.0 =
*Release Date - 17 January 2024*

*Plugin "Indicadores Económicos Chile"! ¡Disfruta de los indicadores económicos actualizados en tu sitio web!

=1.1.0=
*Actualización*
Se agregan las divisas UTM y BITCOIN.

== Upgrade Notice ==


== Capturas de pantalla ==

1. Vista de cómo quedaría en el sitio los indicadores
2. Página de detalles del plugin, ubicada en Herramientas>Indicadores
3. Ejemplo de Shortcode usando Gutenberg



== Other Notes ==
 
¡Gracias por usar el plugin "Indicadores Económicos Chile"! Si tienes sugerencias o encuentras algún problema, por favor contáctame a través de mi sitio web [hectorvaldes.dev](https://hectorvaldes.dev).

== License ==

Este plugin está licenciado bajo GPL-2.0+.

## Política de Privacidad

Este plugin utiliza la API de [Mindicador.cl](https://www.mindicador.cl) para obtener datos económicos de Chile. Te recomendamos revisar la política de privacidad de Mindicador.cl para comprender cómo se manejan los datos.

**Enlace a la Política de Privacidad:** [Política de Privacidad](https://indicadores-economicos-chile.netlify.app/#/privacy-policy)

Asegúrate de revisar y cumplir con las políticas de privacidad tanto de tu propio servicio como del servicio de terceros que estás utilizando en tu plugin. Esto ayuda a proporcionar a los usuarios la información necesaria sobre cómo se manejan los datos y contribuye a la transparencia en el uso del plugin.
