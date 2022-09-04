<?php

namespace Drupal\empleado;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityViewBuilder;

/**
 * Provides a view controller for an empleado entity type.
 */
class EmpleadoViewBuilder extends EntityViewBuilder {

  /**
   * {@inheritdoc}
   */
  protected function getBuildDefaults(EntityInterface $entity, $view_mode) {
    $build = parent::getBuildDefaults($entity, $view_mode);
    // The empleado has no entity template itself.
    unset($build['#theme']);
    return $build;
  }

}
