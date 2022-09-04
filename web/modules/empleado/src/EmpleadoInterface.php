<?php

namespace Drupal\empleado;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining an empleado entity type.
 */
interface EmpleadoInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

  /**
   * Gets the empleado creation timestamp.
   *
   * @return int
   *   Creation timestamp of the empleado.
   */
  public function getCreatedTime();

  /**
   * Sets the empleado creation timestamp.
   *
   * @param int $timestamp
   *   The empleado creation timestamp.
   *
   * @return \Drupal\empleado\EmpleadoInterface
   *   The called empleado entity.
   */
  public function setCreatedTime($timestamp);

}
