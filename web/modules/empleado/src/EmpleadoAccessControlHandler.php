<?php

namespace Drupal\empleado;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Defines the access control handler for the empleado entity type.
 */
class EmpleadoAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {

    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view empleado');

      case 'update':
        return AccessResult::allowedIfHasPermissions($account, ['edit empleado', 'administer empleado'], 'OR');

      case 'delete':
        return AccessResult::allowedIfHasPermissions($account, ['delete empleado', 'administer empleado'], 'OR');

      default:
        // No opinion.
        return AccessResult::neutral();
    }

  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermissions($account, ['create empleado', 'administer empleado'], 'OR');
  }

}
