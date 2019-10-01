<?php
namespace Addon\MedialibsImages;

/**
 * MedialibsImages
 *
 * Master de la classe
 *
 * @author Medialibs
 *
 * @date 2019-09-17
 */

class MedialibsImages extends \Addons_Entity
{
  // singleton
  protected static $instance;

  /**
   * Récupération du singleton
   *
   * Permet d'instancier le singleton depuis les classes standards :
   *
   * @return  \Addon\MedialibsImages\MedialibsImages
   */
  static public function getInstance()
  {
    if (!self::$instance) {
      self::$instance = \Addons_Manager::getInstance()->getAddon(end(explode('\\', get_class($this))), true);
    }
    return self::$instance;
  }

  /**
   * Permet de lancer des actions spécifiques après installation de l'add-on
   *
   * @return  null
   */
  public function onInstallation()
  {

  }

  /**
   * Permet de lancer des actions spécifiques après désinstallation de l'add-on
   *
   * @return  null
   */
  public function onUninstallation()
  {

  }

  /**
   * Permet de lancer des actions spécifiques après l'activation de l'add-on
   *
   * @return  null
   */
  public function onEnable()
  {

  }

  /**
   * Permet de lancer des actions spécifiques après la désactivation de l'add-on
   *
   * @return  null
   */
  public function onDisable()
  {

  }

  /**
   * Permet de lancer des actions spécifiques avant l'export de l'add-on
   *
   * @return  null
   */
  public function onExport()
  {

  }

  /**
   * Vérifie l'activation de l'addons
   *
   * @return  boolean  true si l'add-on est actif
   */
  public function isEnabled()
  {
    return $this->status() == \Addons_Entity::STATUS_ACTIVE;
  }

  /**
   * Retourne le chemin de destination des images
   *
   * @return string
   */
  public function imagePath()
  {
    return '/images/addons/MedialibsImages/';
  }
}
