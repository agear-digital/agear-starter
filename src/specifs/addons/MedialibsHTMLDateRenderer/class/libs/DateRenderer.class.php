<?php
namespace Addon\MedialibsHTMLDateRenderer;

/**
 * La classe DateRenderer permet de transformer une date en une structure HTML optimisée
 *
 * @author Antony de Medialibs <a.chauvire@medialibs.com>
 *
 * @date 2019-10-0814
 */
class DateRenderer
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

  /**
   * Transforme une chaîne représentant une date en une structure HTML optimisée pour les dates
   *
   * @return string Une structure HTML optimisée pour les dates
   */
  protected function formatDate()
  {
    $datetime = "";
    if($this->context == 'blog') {
      $datetime = $this->getPostDate();
    }
    $html = '<time datetime="' . $datetime . '">' . $this->value . '</time>';
    return $html;
  }

  /**
   * Retourne la date de publication d'un billet de blog
   *
   * @return void
   */
  protected function getPostDate()
  {
    $query = 'SELECT publication_date FROM blog_posts WHERE article_id = ' . $this->id;
    return \em_db::one($query);
  }
}