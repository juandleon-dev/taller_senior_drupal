<?php

namespace Drupal\empleado\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the empleado entity edit forms.
 */
class EmpleadoForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {

    $entity = $this->getEntity();
    $result = $entity->save();
    $link = $entity->toLink($this->t('View'))->toRenderable();

    $message_arguments = ['%label' => $this->entity->label()];
    $logger_arguments = $message_arguments + ['link' => render($link)];

    if ($result == SAVED_NEW) {
      $this->messenger()->addStatus($this->t('New empleado %label has been created.', $message_arguments));
      $this->logger('empleado')->notice('Created new empleado %label', $logger_arguments);
    }
    else {
      $this->messenger()->addStatus($this->t('The empleado %label has been updated.', $message_arguments));
      $this->logger('empleado')->notice('Updated new empleado %label.', $logger_arguments);
    }

    $form_state->setRedirect('entity.empleado.canonical', ['empleado' => $entity->id()]);
  }

}
