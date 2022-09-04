<?php

namespace Drupal\modulo_empleado\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Renderer;

class RegistroForm extends FormBase {

  public function getFormId() {
    return 'registro_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

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

  public function my_form_builder_callback(array &$form, FormStateInterface $form_state) {
    $form_state
      ->set('page_values', [
        'nombre' => $form_state->getValue('nombre'),
        'edad' => $form_state->getValue('edad'),
        'genero' => $form_state->getValue('genero'),
      ])
      ->set('page_num', 2)
      ->setRebuild(TRUE);
  }

  public function submitPageOne(array &$form, FormStateInterface $form_state){
    $response = new AjaxResponse();
    $response->addCommand(new ReplaceCommand('#ajax_form', $form));

    return $response;
  }

  public function pageTwo(array $form, FormStateInterface $form_state) {
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

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $page_values = $form_state->get('page_values');
    ksm($form_state->getValue('empresa'), $form_state->getValue('tiempo_laborado'),$form_state->getValue('salario'), $page_values );
//    $this->messenger()->addMessage($this->t('The form has been submitted. name="@first @last", address="@address". city="@city"', [
//      '@first' => $page_values['first_name'],
//      '@last' => $page_values['last_name'],
//      '@address' => $page_values['address'],
//      '@city' => $page_values['city'],
//    ]));
  }



}
