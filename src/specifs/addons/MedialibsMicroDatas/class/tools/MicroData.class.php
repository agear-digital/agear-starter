<?php
namespace Addon\MedialibsMicroDatas;

/**
 * La classe MicroData permet de transformer une valeur brute en une structure HTML de micro-données
 *
 * @author Antony de Medialibs <a.chauvire@medialibs.com>
 *
 * @since 2019-10-08
 */
class MicroData
{
  /**
   * L'id de l'élément traité
   * @var string
   */
  private $id;

  /**
   * Le contexte de traitement
   * @var string
   */
  private $context;
  
  /**
   * Le type de données
   * @var string
   */
  private $type;

  /**
   * Le valeur d'origine
   * @var string
   */
  private $value;
  
  /**
   * Constructeur
   */
  public function __construct($type, $value, $id, $context)
  {
    $this->type = $type;
    $this->value = $value;
    $this->id = $id;
    $this->context = $context; 
  }
  
  /**
   * Formate une donnée avec des micro-données
   */
  public function format()
  {
    if($this->type == 'date') {
      return $this->formatDate();
    } elseif ($this->type == 'rating') {
      return $this->formatRating();
    }
  }
  
  protected function formatDate()
  {
    $datetime = "";
    $html = '<time datetime="' . $datetime . '">' . $this->value . '</time>';
    if($this->context == 'blog') {
      $datetime = $this->getPostDate();
      $html = '<time itemprop="datePublished" content="'. $datetime . '" datetime="' . $datetime . '">' . $this->value . '</time>';
    }
    return $html;
  }

  protected function formatRating()
  {
    $datas = explode('/', $this->value);
    $html = '<span itemprop="ratingValue">' . $datas[0] . '</span>/<span itemprop="bestRating">' . $datas[1] . '</span>';
    return $html;
  }

  protected function getPostDate()
  {
    $query = 'SELECT publication_date FROM blog_posts WHERE article_id = ' . $this->id;
    return \em_db::one($query);
  }
}