<?php

namespace Drupal\migrate_mongo_source\Plugin\migrate\source;

use Drupal\migrate_plus\Plugin\migrate\source\SourcePluginExtension;
use MongoClient;

/**
 * Source for CSV files.
 *
 * @MigrateSource(
 *   id = "awesome_mongo"
 * )
 */

class AwesomeMongo extends SourcePluginExtension {
  /**
   * Prints the query string when the object is used as a string.
   *
   * @return string
   *   The query string.
   */
  public function __toString() {
    return $this->configuration['database'] . '.' . $this->configuration['collection'];
  }


  /**
   * {@inheritdoc}
   */
  protected function initializeIterator() {
    $client = new MongoClient();
    $db = $client->{$this->configuration['database']};
    $collection = $db->{$this->configuration['collection']};

    $iterator = $collection->find();
    return $iterator;
  }

  public function getIDs() {
    $ids = [];
    foreach ($this->configuration['key'] as $key => $value) {
      $ids[$key] = $value;
    }
    return $ids;
  }

  public function fields() {
    return $this->configuration['fields'];
  }
}
