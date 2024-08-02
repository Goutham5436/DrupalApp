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
use Drupal\moduleone\services\DateFormatter;
use Drupal\moduleone\services\StringLength;

class FirstController extends ControllerBase {

    /**Lines  18 - 26 are code for dependency injection. */
    protected $entityQuery;
    protected $dateFormatterStamp;
    protected $stringLengthOne;

    public function __construct(EntityTypeManagerInterface $entity_query,DateFormatter $date_formatter,StringLength $string_length) { //$entity_query is another variable which is type hinted with queryFactroy
        $this->entityQuery = $entity_query;
        $this->dateFormatterStamp = $date_formatter;
        $this->stringLengthOne = $string_length;
    }

    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('entity_type.manager'),
            $container->get('moduleone.date_formatter'),
            $container->get('moduleone.string_length'),
        );
    }

    public function moduleone() {
    //   $render_array = [
    //     'Hello_world' => [
    //       '#type' => 'markup',
    //       '#markup' => t('Hello World, 
    //                         god bless everyone'),
    //       ],
    //     ];  
      $msg = 'this is text written in controller';
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
      $outputs = [];
      foreach ($nodes as $node) {
        // $title = $node -> getTitle();
        // $body = $node -> get('Body') -> value;
        // $output .= '<h2>' .$title . '</h2>';
        // $output .= '<p' . $body . '</p>';
        //dump($node->getTitle());
<<<<<<< HEAD
        $time = $node->getCreatedTime();
        $formatted_date = $this->dateFormatterStamp->dateFormatter($time);
        $stringLengthTwo = $this->stringLengthOne->stringlen($node->body->value);
        $outputs[] = [
          'title' => strip_tags($node->getTitle()),
          'body' => strip_tags($node->body->value),
          'timestamp' => $formatted_date,
          'stringbdy' => $stringLengthTwo,
        ];
        // dump($outputs);
=======
        $outputs[] = [
          'title' => strip_tags($node->getTitle()),
          'body' => strip_tags($node->body->value),
        ];
       // dump($outputs);
>>>>>>> b562d6b1 (custom twig template in Custom Module)
        
    }
      
      //return the combine render array
      return [
        '#theme' => 'moduleone_template',
        '#items' => $outputs,
        '#paragraph' => $msg,
      ];
    //   dump($output);
    }


}