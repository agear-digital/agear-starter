<?php
namespace Addon\MedialibsMicroDatas;

require_once \em_misc::getSpecifPath() . 'addons/MedialibsMicroDatas/class/tools/MicroData.class.php';

/**
 * Gestion de la balise MX "La balise MX permet de transformer une valeur brute en une structure HTML utilisant des micro-données (date, note ...)"
 *
 * @author Antony de Medialibs <a.chauvire@medialibs.com>
 *
 * @since 2019-10-08
 */
class mxMicroDatas
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
      $microData = new MicroData($this->getTagParam('type'), $this->getTagParam('value'), $this->getTagParam('elementid'), $this->getTagParam('context'));  
      return $microData->format();
    }
}
