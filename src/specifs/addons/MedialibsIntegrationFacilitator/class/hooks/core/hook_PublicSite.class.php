<?php
namespace Addon\MedialibsIntegrationFacilitator;

/**
 * Affichage menu pour le responsive
 *
 * @author Antony de Medialibs <a.chauvire@medialibs.com>
 *
 * @date 2019-05-06 12:11
 */
class hook_PublicSite extends \Emajine_Hooks
{
  /**
	 * Intervention après la génération de la page
	 *
	 * @param string $content Données affichées
	 * @param string $context Contexte de la génération
	 *                        	echoAndExit = Appelé lors d'un em_output::echoAndExit()
	 *                        	webograf	= Affichage du Webo Graph
	 *                        	standard 	= Affichage standard
	 *                        	closed 		= Affichage du site fermé
	 *
	 * @return null
	 */
	public function afterPageGeneration(&$content, $context)
	{
    if($context != 'standard') {
      return null;
    }

    // Inclusion de la libraire qui gère la detection des appareils
    require_once \em_misc::getSpecifPath() . 'addons/MedialibsIntegrationFacilitator/class/mobile/MobileDetect.class.php';
    $detect = new MobileDetect();
    if ( $detect->isMobile() ) {
      // Déplace les menus dans un même conteneur
      $array = explode('##@@@##', $content);
      $submenu = $array[1];
      $menu = $array[3];
      $content = $array[0] . '' . $array[2] . '' . $array[4];
      $content = str_replace('##$$$##', $menu . '' . $submenu, $content);

      if ( $detect->isTablet() ) {
        // Supprime les tags spéciaux
        $content = str_replace('##is-desktop##', '', $content);
      } else {
        // Ajoute une classe à l'élément HTML
        $content = str_replace('##is-desktop##', 'is-mobile', $content);
      }
    } else {
      // Supprime les tags spéciaux
      $content = str_replace('##@@@##', '', $content);
      $content = str_replace('##$$$##', '', $content);

      // Ajoute une classe à l'élément HTML
      $content = str_replace('##is-desktop##', 'is-desktop', $content);
    }
	}
}
