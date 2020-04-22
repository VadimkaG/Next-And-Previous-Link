<?php
namespace Drupal\nextprevblock;

use Drupal\Core\Url;
use \Drupal\Core\Template\Attribute;

/**
 * Twig extension
 * @author Vadimka
 */
class TwigExtension extends \Twig_Extension {

  public function getFunctions() {
    return [
      new \Twig_SimpleFunction('getNextPrevById', [$this, 'nextprev_func']),
      new \Twig_SimpleFunction('getNextById',     [$this, 'next_func']),
      new \Twig_SimpleFunction('getPrevById',     [$this, 'prev_func'])
    ];
  }
  /**
   * Запросить элемент кнопки "next" для node
   * @param $nid - Идентификатор node
   * @param $name - Имя ссылки
   */
  public function next_func( $nid, $ntype, $name = "" ) {
    $theme = [
      "#theme" => "nextpre"
    ];

    // Добавляем кнопку next
    $next = $this->generateNextPrevious($nid,$ntype,$name);
    if ($next) {
      $theme['#next'] = $next;
    }

    return $theme;
  }
  /**
   * Запросить элемент кнопоки "prev" для node
   * @param $nid - Идентификатор node
   * @param $name - Имя ссылки
   */
  public function prev_func( $nid, $ntype, $name = "" ) {
    $theme = [
      "#theme" => "nextpre"
    ];

    // Добавляем кнопку prev
    $prev = $this->generateNextPrevious($nid,$ntype,$name,'prev');
    if ($prev) {
      $theme['#prev'] = $prev;
    }

    return $theme;
  }
  /**
   * Запросить элемент кнопок для node
   * @param $nid - Идентификатор node
   * @param $name_prev - Имя ссылки prev
   * @param $name_next - Имя ссылки next
   */
  public function nextprev_func( $nid, $ntype, $name_prev = "", $name_next = "" ) {
    $theme = [
      "#theme" => "nextpre"
    ];

    // Добавляем кнопку prev
    $prev = $this->generateNextPrevious($nid,$ntype,$name_prev,'prev');
    if ($prev) {
      $theme['#prev'] = $prev;
    }

    // Добавляем кнопку next
    $next = $this->generateNextPrevious($nid,$ntype,$name_next);
    if ($next) {
      $theme['#next'] = $next;
    }

    return $theme;
  }

  /**
   * Lookup the next or previous node.
   *
   * @param string $current_nid
   *   Get current page node id.
   * @param string $direction
   *   Default value is "next" and other value come from
   *   generatePrevious() and generatePrevious().
   *
   * @return array
   *   Find the alias of the next node.
   */
  private function generateNextPrevious($current_nid, $ntype, $title, $direction = 'next') {
    $comparison_opperator = '>';
    $sort = 'ASC';

    if ($direction === 'prev') {
      $comparison_opperator = '<';
      $sort = 'DESC';
    }

    // Lookup 1 node younger (or older) than the current node.
    $query = \Drupal::entityTypeManager()->getStorage('node');
    $query_result = $query->getQuery();
    $next = $query_result->condition('nid', $current_nid, $comparison_opperator)
      ->condition('type', $ntype)
      ->condition('status', 1)
      ->sort('nid', $sort)
      ->range(0, 1)
      ->execute();

    // If this is not the youngest (or oldest) node.
    if (!empty($next) && is_array($next)) {
      $next = array_values($next);
      $next = $next[0];

      // Find the alias of the next node.
      $nid = $next;
      $url = Url::fromRoute('entity.node.canonical', ['node' => $nid], []);
      return [
        'url' => "/".$url->getInternalPath(),
        'title' => $title,
        'attributes' => new Attribute(['class' => ['nextpre__btn'], 'href' => "/".$url->getInternalPath()])
      ];
    }

    return false;
  }

}
