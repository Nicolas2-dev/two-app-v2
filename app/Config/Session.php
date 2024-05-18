<?php
/**
 * Two - Session
 *
 * @author  Nicolas Devoy
 * @email   nicolas@nicodev.fr 
 * @version 1.0.0
 * @date    15 Fevrier 2023
 */

return array(

    // Le pilote de session utilisé pour stocker les données de session.
    // pris en charge : 'fichier', 'base de données' ou 'cookie'.
    'driver' => 'file',  

    /**
     * La configuration du pilote de session de base de données.
     */

    // La table de base de données hébergeant les données de session.
    'table'      => 'sessions', 
    
    // Le nom de connexion à la base de données utilisé par le pilote.
    'connection' => null,       
 
    /**
     * Durée de vie de la session.
     */

    // Nombre de minutes pendant lesquelles la session est autorisée à rester inactive avant son expiration.
    'lifetime'      => 180,  

    // Si vous voulez qu'ils expirent immédiatement à la fermeture du navigateur, définissez-le.
    'expireOnClose' => false,   

    /**
     * La configuration du pilote de session de fichiers.
     */

    // File Session Handler - où les fichiers de session peuvent être stockés.
    'files'    => STORAGE_PATH .'framework' .DS .'sessions', 

    // Option utilisée par le Garbage Collector, pour supprimer les fichiers de session bloqués.
    'lottery' => array(2, 100), 

    // Configuration des cookies.
    'cookie'  => PREFIX .'session',
    'path'    => '/',
    'domain'  => null,
    'secure'  => false,
);
