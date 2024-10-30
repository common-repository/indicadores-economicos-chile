<?php
/*
*Plugin Name: Indicadores Económicos Chile
*Plugin URI: https://github.com/Mushroom0047/indicadores-economicos-chile-plugin-wp
*Description: Muestra mediante un shortcode los Indicadores económicos actualizados en Chile.
*Version: 1.1.0
*Author: Mushroom Dev 🍄
*Author URI: https://hectorvaldes.dev/
*Donate link: https://ko-fi.com/mushroom47
*Tags: indicadores, Chile, economía, uf, dolar, ipc
*Requires at least: 4.0
*Tested up to: 6.5.2
*Stable tag: 1.1.0
*License: GPLv2
*License URI: https://www.gnu.org/licenses/gpl-2.0.html
*Text Domain: indicadores-economicos-chile
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Salir si se accede directamente

global $indecochile_indicadores_data;

//! Función para obtener los datos de la API de mindicador.cl
function indecochile_obtener_datos_mindicador_api() {
    $indecochile_api_url = 'https://www.mindicador.cl/api';

    // Realizar la solicitud GET a la API
    $indecochile_response = wp_remote_get($indecochile_api_url);

    // Verificar si la solicitud fue exitosa
    if (is_wp_error($indecochile_response)) {
        // En caso de error al hacer la solicitud, registrar el error en el log
        error_log("Error al obtener datos de la API: " . $indecochile_response->get_error_message());
        // Informar al usuario de manera más específica sobre el problema
        return "Error al obtener datos de la API. Por favor, inténtalo de nuevo más tarde.";
    } else {
        // Si la solicitud fue exitosa, obtener y decodificar los datos JSON
        $indecochile_body = wp_remote_retrieve_body($indecochile_response);
        $indecochile_data = json_decode($indecochile_body);

         // Verificar si se obtuvieron datos válidos
         if ($indecochile_data) {
            global $indecochile_indicadores_data;
            // Almacenar los valores en las variables globales
            $indecochile_indicadores_data = array(
                'uf' => $indecochile_data->uf,
                'ivp' => $indecochile_data->ivp,
                'dolar' => $indecochile_data->dolar,
                'dolar intercambio' => $indecochile_data->dolar_intercambio,
                'euro' => $indecochile_data->euro,
                'ipc' => $indecochile_data->ipc,
                'utm' => $indecochile_data->utm,
                'imacec' => $indecochile_data->imacec,
                'tpm' => $indecochile_data->tpm,
                'bitcoin' => $indecochile_data->bitcoin,
            );

            return "Datos de la API almacenados correctamente.";
        } else {
            return "No se pudieron obtener datos válidos de la API.";
        }
    }
}

//! Función para el shortcode que mostrará los indicadores según el parámetro recibido
function indecochile_mostrar_indicador($indecochile_atributos) {
    if(extension_loaded('intl')){
        // Actualizar los datos de la API antes de mostrar el divisa solicitado
        indecochile_obtener_datos_mindicador_api();
        
        global $indecochile_indicadores_data;
        $indecochile_numberFormat = NumberFormatter::create('es_CL', NumberFormatter::CURRENCY);
        $indecochile_numberFormatUSD = NumberFormatter::create('en_US', NumberFormatter::CURRENCY);
        $value_temp;

        // Obtener el parámetro del shortcode
        $indecochile_atributos = shortcode_atts(array(
            'divisa' => '',
            'nombre' => false,
            'class' => '',
            'id' => '',
        ), $indecochile_atributos);

        // Verificar si se proporcionó un divisa válido y existe en los datos almacenados
        if (!empty($indecochile_atributos['divisa']) && isset($indecochile_indicadores_data[$indecochile_atributos['divisa']])) {
            // Verificar si los datos de la API están disponibles y el valor no es nulo
            if ($indecochile_indicadores_data !== null) {
                //Comprobamos valores con porcentaje
                if($indecochile_atributos['divisa'] === 'ipc' || $indecochile_atributos['divisa'] === 'imacec' || $indecochile_atributos['divisa'] === 'tpm'){
                    $indecochile_converted_value = $indecochile_indicadores_data[$indecochile_atributos['divisa']]->valor . '%';
                }else if($indecochile_atributos['divisa'] === 'bitcoin'){
                    $value_temp = $indecochile_indicadores_data[$indecochile_atributos['divisa']]->valor;
                    $indecochile_converted_value = $indecochile_numberFormatUSD->formatCurrency($value_temp, 'USD');
                }else{
                    $value_temp = $indecochile_indicadores_data[$indecochile_atributos['divisa']]->valor;
                    $indecochile_converted_value = $indecochile_numberFormat->formatCurrency($value_temp, 'CLP');
                }
                // Construir el elemento del párrafo con clase y ID
                $output = '<p';            
                if (!empty($indecochile_atributos['class'])) {
                    $output .= ' class="' . esc_attr($indecochile_atributos['class']) . '"';
                }
                if (!empty($indecochile_atributos['id'])) {
                    $output .= ' id="' . esc_attr($indecochile_atributos['id']) . '"';
                }
                $output .= '>';
                if($indecochile_atributos['nombre']){
                    $output .= '<span><b>'.$indecochile_indicadores_data[$indecochile_atributos['divisa']]->nombre.': '.'</b>'. $indecochile_converted_value .'</span>';
                }else{
                    $output .= $indecochile_converted_value;
                }
                $output .= '</p>';
                

                // Devolver el valor del divisa solicitado dentro del elemento con clase e ID
                return $output;
            } else {
                return "No se pudo obtener datos de la API.";
            }
        } else {
            return "divisa no válida o no encontrada.";
        }
    }else{
        return "Para poder usar el shortcode verifica que la extensión intl de PHP este activada.";
    }
}

// Función para añadir una página en Herramientas
function indecochile_agregar_pagina_herramientas() {
    add_submenu_page(
        'tools.php',             // Slug de la página padre (Herramientas)
        'Indicadores Económicos Chile',     // Título de la página
        'Indicadores Económicos Chile',     // Nombre en el menú
        'manage_options',        // Capacidad requerida para acceder
        'indicadores-económicos-chile-settings',   // Slug de la página
        'indecochile_indicadores_pagina'      // Función que mostrará la página
    );
}

// Función que mostrará el contenido de la página
function indecochile_indicadores_pagina() {
    if (!extension_loaded('intl')) {
        echo '<h2>**Para poder usar el shortcode verifica que la extensión intl este activada.**</h2>';
    } 
    echo <<<HTML
<div class="wrap">
    <h1>Indicadores Económicos Chile</h1>
    <p>Este plugin te permite obtener fácilmente mediante shortcode los indicadores económicos más utilizados en Chile.</p>
    <h2>Instrucciones de uso del shortcode <b>[indicadores]</b></h2>
    <p>El shortcode <b>[indicadores]</b> acepta los siguientes parámetros:</p>
    <ul style="list-style: inside;">
        <li><strong>divisa</strong>: Parámetro para indicar la divisa a mostrar. Los valores aceptados son:</li>
        <ul style="list-style: square; padding-left: 40px;">
            <li>uf</li>
            <li>dolar</li>
            <li>dolar intercambio</li>
            <li>euro</li>
            <li>ipc</li>
            <li>utm</li>
            <li>ivp</li>
            <li>imacec</li>
            <li>tpm</li>
            <li>bitcoin</li>
        </ul>
        <li><strong>nombre</strong>: Opcional. debe ser igual a "true" para mostrar el nombre de la divisa junto con su valor. Se agrega una etiqueta span que contiene el nombre de la divisa.</li>
        <li><strong>class</strong>: Opcional. Define una clase CSS para el elemento generado por el shortcode.</li>
        <li><strong>id</strong>: Opcional. Define un identificador único para el elemento generado por el shortcode.</li>
    </ul>
    <h2>¡Apoya mi trabajo!</h2>
    <p>Puedes apoyarme comprándome un café en <a href="https://ko-fi.com/mushroom47" target="_blank" rel="noopener noreferrer">Kofi</a>.</p>
    <p><a href="https://hectorvaldes.dev/" target="_blank" rel="noopener noreferrer">Developed by Mushroom Dev 🍄</a></p>
    
    <!-- Disclaimer y versión del plugin -->
    <p>Los datos son obtenidos diariamente de la API REST <a href="https://mindicador.cl/" target="_blank" rel="noopener noreferrer">mindicador.cl</a>.</p>
    <p>Versión del plugin: 1.1.0</p>
</div>
HTML;
}

// Registrar el shortcode
add_shortcode('indicadores', 'indecochile_mostrar_indicador');

// Acción para añadir la página al menú de Herramientas
add_action('admin_menu', 'indecochile_agregar_pagina_herramientas');
