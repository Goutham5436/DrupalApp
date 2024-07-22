<?php

/**
 * @file 
 * Testing to display Hello World
 */

namespace Drupal\moduleone\Controller;

use Drupal\Core\Controller\ControllerBase;

class FirstController extends ControllerBase {

    public function moduleone() {
      return [
        '#type' => 'markup',
        '#markup' => t('Hello World, 
                            god bless everyone'),
      ];

    }


}