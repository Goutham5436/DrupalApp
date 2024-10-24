<?php

namespace Drupal\moduleone\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;

class AjaxFormController extends ControllerBase {

    /* // This  is to out the data on output.page url.
       public function output($name1) {
        return [
            '#markup' => $this->t('Hello @name!', ['@name' => $name1 ]),
        ];
    } */

    // Display data from database
    public function displayData() {
        // Get database connection 
        $connection = Database::getConnection();

        // Query the data from the custom table
        $query = $connection->select('my_custom_form_data', 'm')
          ->fields('m', ['id', 'name', 'email'])
          ->execute();
        
          $rows = [];
          foreach ($query as $record) {
            $rows[] = [
              'id' => $record->id,
              'name' => $record->name,
              'email' => $record->email,
            ];
          }

          // Render the data in a table
          $header = [
            $this->t('ID'),
            $this->t('Name'), 
            $this->t('Email'),        
          ];

          $output = [
            '#type' => 'table',
            '#header' => $header,
            '#rows' => $rows,
            '#empty' => $this->t('No data found.'),
          ];
      
          return $output;
    }


}