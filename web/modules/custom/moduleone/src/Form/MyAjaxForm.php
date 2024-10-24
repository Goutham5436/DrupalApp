<?php


namespace Drupal\moduleone\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\RedirectCommand;

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

         // Email field
        $form['email'] = [
            '#type' => 'email',
            '#title' => $this->t('Email'),
            '#required' => FALSE,
        ];


       /* $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
            //This is to call a AJAX submit (which would redirect to output page to display 'hello @name'
              //without page reloading )
              '#ajax' => [
                'callback' => '::ajaxSubmit',
            ], 
        ]; */

        // Submit button
        $form['actions']['submit'] = [
           '#type' => 'submit',
           '#value' => $this->t('Submit'),
        ];

        return $form;

      }

  /*  // Does the AJAX redirecting to output page.
      public function ajaxSubmit(array &$form, FormStateInterface $form_state) { 
        $name1 = $form_state->getValue('name');
        $response = new AjaxResponse();
        $url = \Drupal\Core\Url::fromRoute('moduleone_ajax_form.output_page', ['name' => $name1]);
        $response->addCommand(new RedirectCommand($url->setAbsolute(TRUE)->toString()));
        return $response;
      } */

      public function submitForm(array &$form, FormStateInterface $form_state) {
        //Get submitted value
        $name = $form_state->getValue('name');
        $email = $form_state->getValue('email');

       //print the value 
       // $this->messenger()->addMessage($this->t('The name you entered is: @name', ['@name' => $name]));

        //Save data into database.
        $connection = Database::getConnection();
        $connection->insert('my_custom_form_data')
          ->fields([
            'name' => $name,
            'email' => $email,
          ])
          ->execute();
        
        // Display a message after saving the data to database or form submission
        $this->messenger()->addMessage($this->t('Your data has been saved.'));

      }
}





