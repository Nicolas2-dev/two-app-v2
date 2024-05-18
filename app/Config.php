<?php
/**
 * Two - Config
 *
 * @author  Nicolas Devoy
 * @email   nicolas@nicodev.fr 
 * @version 1.0.0
 * @date    15 Fevrier 2023
 */

//--------------------------------------------------------------------------
// Config - la configuration globale chargée AVANT le démarrage de l'application Two.
//--------------------------------------------------------------------------


/**
 * Définissez le chemin d'accès au stockage.
 *
 * NOTE: dans une conception multi-tenant, chaque application doit avoir son stockage unique.
 */
define('STORAGE_PATH', BASEPATH .'storage' .DS);

/**
 * Définissez le préfixe global.
 *
 * PRÉFÉREZ être utilisé dans les appels de base de données ou le stockage des données de session, la valeur par défaut est 'Two_'
 */
define('PREFIX', 'Two_');