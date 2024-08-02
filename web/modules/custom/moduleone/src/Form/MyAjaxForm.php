<?php

namespace Drupal\moduleone\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
Use Drupal\Core\Ajax\RedirectCommand;

class MyAjaxForm extends FormBase {
    public function getFormId() {
        return 'my_ajax_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
      $form['name'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Enter your name'),
        '#required' => TRUE,
      ];

      $form['actions']['#type'] = 'actions';
      $form['actions']['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Submit Here'),
        '#ajax' => [
            'callback' => '::ajaxSubmit',
        ],
      ];

      return $form;
    }

    public function ajaxSubmit(Array &$form, FormStateInterface $form_state) {
        $name = $form_state->getValue('name');
        $response = new AjaxResponse();
        $url = \Drupal\Core\Url::fromRoute('moduleone_ajax_form.output_page', ['name' => $name]);
        $response->addCommand(new RedirectCommand($url->toString()));
        return $response;
    } 

    public function submitForm(Array &$form, FormStateInterface $form_state) {
        //this function can be left empty since the form is submited via Ajax.
    }
}