<?php

namespace Drupal\Tests\modulo_empleado\Unit;

use Drupal\Core\Config\Config;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\FormState;
use Drupal\Core\StringTranslation\TranslationInterface;
use Drupal\modulo_empleado\Form\RegistroForm;
use Drupal\Tests\UnitTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophecy\ObjectProphecy as ObjectProphecyAlias;

class RegistroFormTest extends UnitTestCase {

  private ObjectProphecy|TranslationInterface $translationInterfaceMock;

  private ObjectProphecyAlias $configFactoryMock;

  private ObjectProphecyAlias|Config $configMock;

  private RegistroForm $form;

  public function setUp(): void {

    $this->translationInterfaceMock = $this->prophesize(TranslationInterface::class);
    $this->configMock = $this->prophesize(Config::class);

    $this->configMock->get('custom_property')->willReturn([
      'label' => 'Empleados'
    ]);

    $this->configFactoryMock = $this->prophesize(ConfigFactoryInterface::class);
    $this->configFactoryMock->getEditable('modulo_empleado.settings')->willReturn($this->configMock);

    $this->form = new RegistroForm($this->configFactoryMock->reveal());
    $this->form->setStringTranslation($this->translationInterfaceMock->reveal());
  }

  public function testFormId() {
    $this->assertEquals('registro_form', $this->form->getFormId());
  }

  public function testBuildForm() {
    $form = [];
    $form_state = new FormState();

    $retForm = $this->form->buildForm($form, $form_state);

    $this->assertEquals( 'item', $retForm['description']['#type']);
    $this->assertEquals( 'textfield', $retForm['nombre']['#type']);
    $this->assertEquals( 'number', $retForm['edad']['#type']);
    $this->assertEquals( 'select', $retForm['departamento']['#type']);
    $this->assertEquals( 'select', $retForm['ciudad']['#type']);

    $this->assertEquals(['callback' => '::submitPageOne'], $retForm['next']['#ajax']);
  }

}
