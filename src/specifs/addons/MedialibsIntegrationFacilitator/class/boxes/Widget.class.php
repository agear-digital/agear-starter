<?php
namespace Addon\MedialibsIntegrationFacilitator;

/**
 * La classe Widget permet de générer le rendu d'un widget
 *
 * @author Antony de Medialibs <prestation@medialibs.com>
 *
 * @since 2019-11-08
 */
class Widget
{
  /**
   * Le nom d'une classe associée au widget
   */
  private $cssClass = '';

  /**
   * L'id du widget
   */
  private $id = '';

  /**
   * Affiche le contenu du widget
   * 
   * @param string $cssClass Une classe associée au widget
   */
  public function display($cssClass) {

    $this->cssClass = $cssClass;
    $this->id = $this->getId();

    // Si la classe est vide, la balise MX n'affiche rien
    if(empty($cssClass) || empty($this->id)) {
      return '';
    }

    // Identifiant de la rubrique en cours
    $idHeading = $GLOBALS['rubrique']->Cid;

    // Si le widget ne doit pas s'affiche dans la rubrique, la balise MX n'affiche rien
    if(!$this->isAvailable($idHeading)) {
      return '';
    }

    $widget = \Emajine_API::load('Emajine_Widget');
    $widget->setId($this->id);
    return $widget->display();
  }

  /**
   * Récupère l'identifiant du widget en fonction du nom d'une de ses classes
   */
  protected function getId()
  {
    $query = 'SELECT id_box FROM boxes WHERE css LIKE \'%' . $this->cssClass . '%\'';
    return \em_db::one($query);
  }

  /** 
   * Récupère un tableau contenant les id des rubriques dans lesquelles le widget ne doit pas s'afficher
  */
  protected function getExcludedHeadings()
  {
    $query = 'SELECT rubriques_exept FROM boxes_rubrique WHERE id_box = ' . $this->id;
    return explode('_', \em_db::one($query));
  }

  /**
   * Détermine si le widget est disponible pour la rubrique en cours
   */
  protected function isAvailable($idHeading)
  {
    $isAvailable = true;
    $excludedHeadings = $this->getExcludedHeadings();
    foreach($excludedHeadings as $heading) {
      if($heading == $idHeading) {
        $isAvailable = false;
        break;
      }
    }
    return $isAvailable;
  }
}