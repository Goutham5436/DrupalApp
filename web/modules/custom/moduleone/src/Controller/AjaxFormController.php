<?php

namespace Drupal\moduleone\Controller;

use Drupal\Core\Controller\ControllerBase;

class AjaxFormController extends ControllerBase {
    public function output($name) {
        return[
            '#markup' => $this->t('hello @name!',['@name' => $name]),
        ];
    }
}