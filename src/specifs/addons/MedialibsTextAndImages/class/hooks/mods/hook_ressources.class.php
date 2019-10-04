<?php
namespace Addon\MedialibsTextAndImages;

/**
 * Gestion des ressources
 *
 * @author Antony de Medialibs <a.chauvire@medialibs.com>
 *
 * @date 2019-06-24 08:58
 */
class hook_ressources extends \Emajine_Hooks
{
    /**
     * Nom du bloc contenant l'image en dessous du texte
     */
    const PICTURE_DOWN_BLOCK    = 'pictureOnDown';
    /**
     * Nom de la position contenant l'image en dessous du texte
     */
    const PICTURE_DOWN_POSITON  = 'below';
    /**
     * Nom de la classe CSS à appliquer pour que le bloc ai une largeur fluide
     */
    const PICTURE_FLUID_WIDTH   = 'item-fluid';
    /**
     * Nom de la classe CSS à appliquer pour que le bloc ai une largeur de 100%
     */
    const PICTURE_FULL_WIDTH    = 'w100';
    /**
     * Nom de la position contenant l'image dans le texte avec un alignement gauche
     */
    const PICTURE_LEFT_POSITON  = 'posLeft';
    /**
     * Nom de la position contenant l'image dans le texte avec un alignement droite
     */
    const PICTURE_RIGHT_POSITON = 'posRight';
    /**
     * Nom du bloc contenant l'image au dessus du texte
     */
    const PICTURE_TOP_BLOCK     = 'pictureOnTop';
    /**
     * Nom de la position contenant l'image au dessus du texte
     */
    const PICTURE_TOP_POSITON   = 'above';

    /**
     * Modification de l'affichage du contenu d'un bloc de Saytup (après le comportement standard)
     *
     * @param int                      $blocId     Identifiant du bloc
     * @param Modelixe                 $mx         Le template du bloc
     * @param array                    $config     Les données de la configution du bloc
     * @param Content_Elements_Factory $blocObject L'objet bloc
     *
     * @return string|null
     */
    public function modifyContentBlocAfterStandard($blocId, $mx, $config, $blocObject)
    {
        // Récupère la propriété de l'objet modeliXe contenant les données des blocks
        $datas = $mx->data;
        // Tableau contenant les blocs images et texte d'un bloc Paragraphe de Saytup
        $blocks = $datas['blocks']['textPicture'][0]['blocks']['oneColumn'][0]['blocks'];
        // Dans le cas où il s'agit d'un bloc texte sans image
        if(strlen($config['images']) == 0) {
          // Ne modifie rien
          return null;
        // Dans le cas où le bloc possède une image positionnée au dessus du texte
        } elseif ($this->contains($config['position'], self::PICTURE_TOP_POSITON)) {
          // Met à jour les classes des blocs
          return \em_mx::write($this->updateBlockCssClass($mx, self::PICTURE_TOP_BLOCK, $blocks, self::PICTURE_FULL_WIDTH));
        // Dans le cas où le bloc possède une image positionnée au dessous du texte
        } elseif ($this->contains($config['position'], self::PICTURE_DOWN_POSITON)) {
          // Met à jour les classes des blocs
          return \em_mx::write($this->updateBlockCssClass($mx, self::PICTURE_DOWN_BLOCK, $blocks, self::PICTURE_FULL_WIDTH));
        // Dans le cas où le bloc possède une image positionnée dans le texte avec un alignement gauche
        } elseif ($this->contains($config['position'], self::PICTURE_LEFT_POSITON)) {
          // Met à jour les classes des blocs
          return \em_mx::write($this->updateBlockCssClass($mx, self::PICTURE_TOP_BLOCK, $blocks, self::PICTURE_FLUID_WIDTH));
        // Dans le cas où le bloc possède une image positionnée dans le texte avec un alignement droit
        } elseif ($this->contains($config['position'], self::PICTURE_RIGHT_POSITON)) {
          // Met à jour les classes des blocs
          return \em_mx::write($this->updateBlockCssClass($mx, self::PICTURE_TOP_BLOCK, $blocks, self::PICTURE_FLUID_WIDTH));
        }
        return null;
    }

    /**
     * Vérifie si une chaîne de caractères contient une sous-chaîne de caractères
     *
     * @param  string $string La chaîne de caractères dans laquelle rechercher
     * @param  string $search La sous-chaîne de caractères à rechercher
     *
     * @return boolean        True si la chaîne a été trouvée sinon False
     */
    private function contains($string, $search)
    {
      return (strpos($string, $search) === false) ? false : true;
    }

    /**
     * Met à jour les classes CSS du bloc au niveau de l'objet modeliXe
     *
     * @param  modeliXe   $mx         L'objet à manipuler
     * @param  string     $position   Clé du tableau pour la récupération des classes CSS du bloc
     * @param  array      $blocks     Tableau contenant les blocs images et texte d'un bloc Paragraphe de Saytup
     * @param  string     $addClass   Nom de la classe CSS a ajouter aux classes CSS existantes
     *
     * @return modeliXe   L'objet permettant de générer le code HTML du bloc
     */
    private function updateBlockCssClass($mx, $position, $blocks, $addClass)
    {
      $pictureClass = $blocks[$position][0]['attributes']['class'];
      $textClass = $blocks['text'][0]['attributes']['class'];
      $mx->data['blocks']['textPicture'][0]['blocks']['oneColumn'][0]['blocks'][$position][0]['attributes']['class'] = $pictureClass . ' ' . $addClass;
      $mx->data['blocks']['textPicture'][0]['blocks']['oneColumn'][0]['blocks']['text'][0]['attributes']['class'] = $textClass . ' ' . $addClass;
      return $mx;
    }
}
