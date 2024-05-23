<?php
/**
 * Two - Bootstrap
 *
 * @author  Nicolas Devoy
 * @email   nicolas@nicodev.fr 
 * @version 1.0.0
 * @date    15 Fevrier 2023
 */

use App\Models\Option;
use Two\Support\Facades\Cache;
use Two\Support\Facades\Config;

//--------------------------------------------------------------------------
// Load The Options
//--------------------------------------------------------------------------

// if (CONFIG_STORE === 'database') {

//     // Retrieve the Option items, caching them for 24 hours.
//     $options = Cache::remember('system_options', 1440, function () {
//         return Option::all();
//     });

//     // Setup the information stored on the Option instances into Configuration.
//     foreach ($options as $option) {
//         $key = $option->getConfigKey();

//         Config::set($key, $option->value);
//     }
// }

// // If the CONFIG_STORE is not in 'files' mode, go Exception.
// else if (CONFIG_STORE !== 'files') {
//     throw new InvalidArgumentException('Invalid Config Store type.');
// }

//--------------------------------------------------------------------------
// Personnalisation de l'étape de démarrage
//--------------------------------------------------------------------------
