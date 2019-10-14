<?php
namespace Addon\MedialibsMicroDatas;

/**
 * La classe Ressources_Medias_Image permet d'obtenir les informations d'une ressource Image.
 * 
 * Elle permet de récupérer la largeur, la hauteur, l'url absolue et bien d'autres informations
 *
 * @author Antony de Medialibs <a.chauvire@medialibs.com>
 *
 * @date 2019-10-11 15:45
 */
class Ressources_Medias_Image
{
  protected $bddIdStorage;
  protected $id;
  protected $height;
  protected $mediaDatas;
  protected $width;

  public function __construct($bddIdStorage)
  {
      $this->bddIdStorage = $bddIdStorage;
      $this->id = explode('://', $this->bddIdStorage)[1];;
      $this->mediaDatas = getMediaDatas($this->getId());
      $this->setSize();
  }

  /**
   * Retourne l'url absolue de l'image
   *
   * @return void
   */
  public function getAbsoluteURL()
  {
    return \em_misc::getUrlWithDomain($this->getRelativeURL());
  }

  /**
   * Retourne le crédit photographique de l'image
   *
   * @return string
   */
  public function getCopyright()
  {
    return $this->mediaDatas['credits'];
  }

  /**
   * Retourne la date de création de la ressource image
   *
   * @param string $format
   * @return string
   */
  public function getCreationDate($format = 'Y/m/d')
  {
    return $this->getFormattedDate($format, $this->mediaDatas['date_crea']);
  }

  /**
   * Retourne la description de l'image
   *
   * @return string
   */
  public function getDescription()
  {
    return $this->mediaDatas['description'];
  }

  /**
   * Retourne l'extension du fichier image
   *
   * @return string
   */
  public function getFileExtension()
  {
    return $this->mediaDatas['extension'];
  }

  /**
   * Retourne le nom de fichier de l'image
   *
   * @return string
   */
  public function getFileName()
  {
    return $this->mediaDatas['path'];
  }

  /**
   * Retourne le poids du fichier image
   *
   * @return string
   */
  public function getFileSize()
  {
    return $this->mediaDatas['taille'];
  }

  /**
   * Retourne la hauteur de l'image
   *
   * @return int
   */
  public function getHeight()
  {
    return $this->height;
  }

  /**
   * Retourne l'id de la ressource Image
   *
   * @return string
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Retourne la date de modification de la ressource image
   *
   * @param string $format
   * @return string
   */
  public function getModificationDate($format = 'Y/m/d')
  {
    return $this->getFormatedDate($format, $this->mediaDatas['date_modi']);
  }

  /**
   * Retourne le nom de la ressource image
   *
   * @return string
   */
  public function getName()
  {
    return $this->mediaDatas['nom'];
  }

  /**
   * Retourne l'url relative de l'image
   *
   * @return string
   */
  public function getRelativeURL()
  {
    return getFileUrl($this->getId());
  }

  /**
   * Retourne la largeur de l'image
   *
   * @return int
   */
  public function getWidth()
  {
    return $this->width;
  }

  /**
   * Transforme une date au format Timestamp dans un format Date/Heure
   *
   * @param string $format
   * @param int    $date
   * @return void
   */
  protected function getFormatedDate($format, $date)
  {
    return date($format, $date);
  }

  /**
   * Renseigne les dimensions de l'image
   *
   * @return void
   */
  protected function setSize()
  {
    list($width, $height, $type, $attr) = getimagesize($this->getAbsoluteURL());
    $this->width = $width;
    $this->height = $height;
  }
}