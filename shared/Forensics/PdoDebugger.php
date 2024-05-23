<?php
/**Pdo Debugger
 * 
 * @author  Nicolas Devoy
 * @email   nicolas@nicodev.fr 
 * @version 1.0.0
 * @date    15 Fevrier 2023
 */
namespace Shared\Forensics;

/**
 * Classe PdoDebugger
 *
 * Émule l'instruction PDO SQL d'une manière extrêmement simple
 */
class PdoDebugger
{
    /**
     * Renvoie la chaîne SQL émulée
     *
     * @param $rawSql
     * @param $parameters
     * @return mixed
     */
    static public function show($rawSql, $parameters)
    {
        $keys = array();
        $values = $parameters;

        foreach ($parameters as $key => $value) {

            // vérifier si des paramètres nommés (':param') ou des paramètres anonymes ('?') sont utilisés
            if (is_string($key)) {
                $keys[] = '/:'.$key.'/';
            } else {
                $keys[] = '/[?]/';
            }

            // amener le paramètre dans un format lisible par l'homme
            if (is_numeric($value)) {
                $values[$key] = intval($value);
            } elseif (is_string($value)) {
                $values[$key] = "'" . $value . "'";
            } elseif (is_array($value)) {
                $values[$key] = implode(',', $value);
            } elseif (is_null($value)) {
                $values[$key] = 'NULL';
            }
        }

        $rawSql = preg_replace($keys, $values, $rawSql, 1, $count);

        return $rawSql;
    }
}
