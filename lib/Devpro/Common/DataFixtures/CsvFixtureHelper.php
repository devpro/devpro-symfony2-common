<?php

namespace Devpro\Common\DataFixtures;

use Devpro\Common\Exception\DevproUtilitiesBundleException;

/**
 * Csv fixture helper.
 *
 * @author Bertrand THOMAS <bertrand@devpro.fr>
 */
class CsvFixtureHelper
{
  /**
   * Créer les entités à partir d'un fichier CSV.
   *
   * @param string $model classe de l'entité
   * @param array $fields champs
   * @param string $file_path chemin du fichier
   * @return array
   * @throws DevproUtilitiesBundleException si le fichier ne peut pas être lu
   * @static
   */
  public static function createEntities($model, $fields, $file_path)
  {
    // lecture du fichier texte
    $lines = static::readFile($file_path);

    $entities = array();

    // récupération des en-têtes
    $headers = explode(';', $lines[0]);
    array_walk($headers, create_function('&$val', '$val = str_replace(\'_\', \'\', $val);')); // suppression des _
    for ($i = 1; $i < count($lines); $i++) {
      // mapping des valeurs avec le nom de la colonne
      $tab = array_combine($headers, explode(';', $lines[$i]));
      $m = new $model();
      foreach ($fields as $field) {
        // appel du setter du champ
        call_user_func(array($m, 'set' . ucfirst($field)), $tab[$field]);
      }
      $entities[] = $m;
    }

    return $entities;
  }

  /**
   * Read file and return array of lines.
   *
   * @param string $file_path
   * @return array
   * @throws DevproUtilitiesBundleException if file cannot be read
   * @static
   */
  protected static function readFile($file_path)
  {
    $lines = file($file_path, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
    if ($lines === false) {
      throw new DevproUtilitiesBundleException('File "%s" cannot be read', $file_path);
    }
    return $lines;
  }
}
