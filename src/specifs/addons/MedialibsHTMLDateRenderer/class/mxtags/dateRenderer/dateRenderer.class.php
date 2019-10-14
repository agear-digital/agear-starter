<?php
namespace Addon\MedialibsHTMLDateRenderer;

require_once \em_misc::getSpecifPath() . 'addons/MedialibsHTMLDateRenderer/class/libs/DateRenderer.class.php';

/**
 * La balise MX permet de modifier le rendu HTML d'une date passée en paramètre
 *
 * @author Antony de Medialibs <a.chauvire@medialibs.com>
 *
 * @date 2019-10-14
 */
class mxDateRenderer
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
      $dateRenderer = new DateRenderer($this->getTagParam('type'), $this->getTagParam('value'), $this->getTagParam('elementid'), $this->getTagParam('context'));  
      return $dateRenderer->format();
    }
}
