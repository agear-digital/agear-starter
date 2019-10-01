<?php
namespace Addon\MedialibsBreadcrumbMicroData;

/**
 * Modification des micro-données du fil d'Ariane
 *
 * @author Antony de Medialibs <a.chauvire@medialibs.com>
 *
 * @date 2019-04-09 09:10
 */
class hook_navigation extends \Emajine_Hooks
{

  /**
   * Modification de l'affichage d'un item du breadcrumb
   *
   * Si la méthode retourne une chaine de caractère, celle-ci remplacera l'élément standard
   *
   * @param array  $breadcrumb Tableau des élément du breadcrumb
   * @param int    $place      Place de l'élément courrant dans le breadcrumb
   * @param string $url        Lien vers la page de l'élément
   * @param string $text       Texte de l'élément
   *
   * @return string | null
   */
  public function editBreadcrumElementNew($breadcrumb, $place, &$url, &$text)
  {
    // La meta position commence à 1 et non à 0
    $order = $place+1;
    return '<a class="breadcrumb-item txtNone" itemtype="https://schema.org/Thing" itemprop="item" href="'. $url .'"><span itemprop="name">'. $text .'</span></a><meta itemprop="position" content="'. $order .'" />';
  }
}
