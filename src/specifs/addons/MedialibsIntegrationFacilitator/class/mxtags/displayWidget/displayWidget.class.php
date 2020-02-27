<?php
namespace Addon\MedialibsIntegrationFacilitator;

require_once(\em_misc::getSpecifPath().'/addons/MedialibsIntegrationFacilitator/class/boxes/Widget.class.php');

/**
 * La balise displayWidget permet d'afficher un widget à n'importe quel endroit d'un template
 *
 * @author Antony de Medialibs <prestation@medialibs.com>
 *
 * @since 2019-11-08
 */
class mxDisplayWidget
{
    /**
     * Constructeur
     */
    public function __construct()
    {}
    /**
     * Initialisation de l'emplacement du dossier specifs
     *
     * @param string $path Emplacement des développements
     *
     * @return null
     */
    public function setDevPath($path)
    {
        $this->devPath = $path;
    }
    /**
     * Récupération de l'emplacement du dossier specifs
     *
     * @return string
     */
    public function getDevPath()
    {
        return $this->devPath;
    }
    /**
     * Initialisation des attribus de la balise spécifique
     *
     * @param string $attributName Nom de l'attribut
     * @param string $attributValue Valeur de l'attribut
     *
     * @return null
     */
    public function setTagParams($attributName, $attributValue)
    {
        $varname = '_tagParam' . ucFirst($attributName);
        $this->$varname = $attributValue;
    }
    /**
     * Récupération de la valeur définie pour un attribut de la balise
     *
     * @param string $attributName Nom de l'attribut
     *
     * @return string
     */
    public function getTagParam($attributName)
    {
        $varname = '_tagParam' . ucFirst($attributName);
        if (isset($this->$varname)) {
            return $this->$varname;
        }
        return '';
    }
    /**
     * Gestion de la balise. La méthode retourne le contenu de celle-ci.
     *
     * Si start retourne 'test' alors la balise prendra comme valeur 'test'
     *
     * @return string
     */
    public function start()
    {
      $lang = \em_misc::getLang();
      $tag = 'class' . $lang;
      $widget = new Widget();
      return $widget->display($this->getTagParam($tag));
    }
}
