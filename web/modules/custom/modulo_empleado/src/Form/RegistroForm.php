<?php

namespace Drupal\modulo_empleado\Form;

use Drupal;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class RegistroForm extends FormBase
{

  public function getFormId(): string {
    return 'registro_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {
    if ($form_state->has('page_num') && $form_state->get('page_num') == 2) {
      return $this->pageTwo($form, $form_state);
    }

    $form_state->set('page', 1);


    $form['description'] = [
      '#type' => 'item',
      '#title' => $this->t('Registrar empleado (Página 1)'),
    ];

    $form['#prefix'] = '<div id="ajax_form">';
    $form['#suffix'] = '</div>';

    $form['nombre'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Nombre'),
      '#description' => $this->t('Ingresa tu nombre.'),
      '#default_value' => $form_state->getValue('nombre', ''),
      '#required' => TRUE,
    ];

    $form['edad'] = [
      '#type' => 'number',
      '#title' => $this->t('Edad'),
      '#default_value' => $form_state->getValue('edad', ''),
      '#description' => $this->t('Ingresa tu edad.'),
      '#required' => TRUE,
    ];

    $form['settings']['genero'] = [
      '#type' => 'radios',
      '#title' => $this
        ->t('Género'),
      '#options' => [
        'M' => $this
          ->t('Masculino'),
        'F' => $this
          ->t('Femenino'),
      ],
    ];

    $form['departamento'] = [
      '#type' => 'select',
      '#title' => $this->t('Departamento'),
      '#empty_option' => $this->t('- Selecciona Departamento -'),
      '#options' => [
        'cundinamarca' => $this->t('Cundinamarca'),
        'antioquia' => $this->t('Antioquia'),
      ],
      '#ajax' => [
        'callback' => [$this, 'reloadCity'],
        'event' => 'change',
        'wrapper' => 'city-field-wrapper',
      ],
    ];

    $departamento = $form_state->getValue('departamento');

    $form['ciudad'] = [
      '#type' => 'select',
      '#title' => $this->t('City'),
      '#empty_option' => $this->t('- Selecciona Ciudad -'),
      '#options' => $this->obtenerCiudadPorDepartamento($departamento),
      '#prefix' => '<div id="city-field-wrapper">',
      '#suffix' => '</div>',
    ];

    $form['next'] = [
      '#type' => 'submit',
      '#button_type' => 'primary',
      '#value' => $this->t('Siguiente'),
      '#ajax' => [
        'callback' => '::submitPageOne',
      ],
      '#executes_submit_callback' => TRUE,
      '#submit' => [
        '::my_form_builder_callback'
      ],
    ];

    return $form;
  }

  public function reloadCity(array $form, FormStateInterface $form_state)
  {
    return $form['ciudad'];
  }


  protected function obtenerCiudadPorDepartamento($departamento)
  {
    $map = [
      'cundinamarca' => [
        'madrid' => $this->t('Madrid'),
        'tenjo' => $this->t('Tenjo'),
      ],
      'antioquia' => [
        'medellin' => $this->t('Medellin'),
        'rionegro' => $this->t('Rionegro'),
      ],
    ];

    return $map[$departamento] ?? [];
  }

  public function my_form_builder_callback(array &$form, FormStateInterface $form_state)
  {
    $form_state
      ->set('page_values', [
        'nombre' => $form_state->getValue('nombre'),
        'edad' => $form_state->getValue('edad'),
        'genero' => $form_state->getValue('genero'),
        'departamento' => $form_state->getValue('departamento'),
        'ciudad' => $form_state->getValue('ciudad'),
      ])
      ->set('page_num', 2)
      ->setRebuild(TRUE);
  }

  public function submitPageOne(array &$form, FormStateInterface $form_state)
  {
    $response = new AjaxResponse();
    $response->addCommand(new ReplaceCommand('#ajax_form', $form));

    return $response;
  }

  public function pageTwo(array $form, FormStateInterface $form_state)
  {
    $form['description'] = [
      '#type' => 'item',
      '#title' => $this->t('Registrar empleado (Página 2)'),
    ];

    $form['empresa'] = [
      '#type' => 'select',
      '#title' => $this
        ->t('Select element'),
      '#options' => [
        '1' => $this
          ->t('Bits Americas'),
        '2' => $this
          ->t('Google'),
        '3' => $this
          ->t('Facebook'),
      ],
    ];

    $form['tiempo_laborado'] = [
      '#type' => 'number',
      '#title' => $this->t('Tiempo Laborado'),
      '#description' => $this->t('Ingresa el tiempo que has laborado.'),
      '#required' => TRUE,
    ];

    $form['salario'] = [
      '#type' => 'number',
      '#title' => $this->t('salario'),
      '#description' => $this->t('Ingresa tu salario.'),
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#button_type' => 'primary',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state): void
  {
    $page_values = $form_state->get('page_values');

    $node = Drupal::entityTypeManager()->getStorage('empleado')->create([
      'type' => 'empleado'
    ]);
    $node->set('field_nombre', $page_values['nombre']);
    $node->set('field_edad',  $page_values['edad']);
    $node->set('field_genero',  $page_values['genero']);
    $node->set('field_departamento', $page_values['departamento']);
    $node->set('field_ciudad', $page_values['ciudad']);
    $node->set('field_empresa',  $form_state->getValue('empresa'));
    $node->set('field_tiempo_laborado', $form_state->getValue('tiempo_laborado'));
    $node->set('field_salario', $form_state->getValue('salario'));
    $node->save();

    $this->messenger()->addMessage($this->t('El empleado @nombre ha sido registrado', [
      '@nombre' => $page_values['nombre'],
    ]));
  }


}
