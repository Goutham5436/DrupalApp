<?php

/**
 * @file 
 * Testing to display Hello World
 */

namespace Drupal\moduleone\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Node\Entity\Node;

class FirstController extends ControllerBase {

    /**Lines  18 - 26 are code for dependency injection. */
    protected $entityQuery;

    public function __construct(EntityTypeManagerInterface $entity_query) { //$entity_query is another variable which is type hinted with queryFactroy
        $this->entityQuery = $entity_query;
    }

    public static function create(ContainerInterface $container) {
        return new static ($container->get('entity_type.manager'));
    }

    public function moduleone() {
      $render_array = [
        'Hello_world' => [
          '#type' => 'markup',
          '#markup' => t('Hello World, 
                            god bless everyone'),
          ],
        ];  

      //query to get all published pages
    // $query = \Drupal::entityQuery('node'); //this is a static method. 

      $query = $this->entityQuery->getStorage('node')->getQuery();
      
      //dump($this->entityQuery->getStorage('node')->getQuery()->accessCheck(TRUE)->condition('status',1)->condition('type','pag')->execute());

      $nids = $query
        ->accessCheck(TRUE)
        ->condition('type','page')
        ->condition('status',1)
        ->execute();
     

    //Load the nodes
      $nodes = Node::loadMultiple($nids);

      
    //Prepare contents to be displayed.
      $output = [];
      foreach ($nodes as $node) {
        // $title = $node -> getTitle();
        // $body = $node -> get('Body') -> value;
        // $output .= '<h2>' .$title . '</h2>';
        // $output .= '<p' . $body . '</p>';
        //dump($node->getTitle());
        $output[] = [
            '#markup' => '<h2>' . $node->getTitle() . '</h2><p>' . $node->body->value . '</p>',
        ];
    }

    //dump($output);
      $render_array['basic_page'] = [
        '#theme' => 'item_list',
        '#items' => $output,
      ];
      
      //return the combine render array
      return $render_array;
    }


}