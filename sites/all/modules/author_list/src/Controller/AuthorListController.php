<?php
namespace Drupal\author_list\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
use Drupal\user\Entity\User;
use Drupal\Core\Session\AccountInterface;
/**
 * Class AuthorListController.
 *
 * @package Drupal\author_list\Controller
 */
class AuthorListController extends ControllerBase {
    
  /**
   * Display.
   *
   * @return string
   *   Return Hello string.
   */
  public function display() { 
    
    $header_table = array(
      'id'=>    t('SrNo'),
      'author_name' => t('Author Name'),
    );
    
    $ids = \Drupal::entityQuery('user')
    ->condition('status', 1)
    ->execute();
    $users = User::loadMultiple($ids); 
      foreach($users as $user) {
        $username = $user->get('name')->value; 
        $uid = $user->get('uid')->value;
        $node_id = Url::fromUserInput('/author_view/node_view/'.$uid);
        $userlist[$uid] = $username;
        $rows[] = array(
          'id' => \Drupal::l($uid, $node_id),
          'username' => \Drupal::l($username, $node_id),  
        );  
      }
    $form['table'] = [
            '#type' => 'table',
            '#header' => $header_table,
            '#rows' => $rows,
            '#empty' => t('No users found'),
        ];
        return $form;
   }

  public function node_view($cid) {
    
    $header_table = array(
      'nid'=>    t('Node ID'),
      'title' => t('Title'),
    );
    
    
    // $current_path = \Drupal::service('path.current')->getPath();
    // $path_explode = explode('/',$current_path);
    // $author_id = end($path_explode);
    $author_id = $cid;
    
    $query = \Drupal::database()->select('node_field_data', 'n');
    $query->fields('n', ['title','nid']);
    $query->condition('n.uid', $author_id);
    $results = $query->execute()->fetchAll();

    foreach($results as $result) { 
      $title = $result->title; 
      $nid = $result->nid;
      $node_content = Url::fromUserInput('/node/'.$nid);
      
      $rows[] = array(
        'nid' => $nid,
        'title' => \Drupal::l($title, $node_content),  
      );  
    }

    $form['table'] = [
            '#type' => 'table',
            '#header' => $header_table,
            '#rows' => $rows,
            '#empty' => t('No users found'),
        ];
        return $form;
  }
}