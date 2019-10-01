<?php
namespace Addon\MedialibsImages;

/**
 * Gestion du rendu HTML des images
 *
 * @author Antony de Medialibs <a.chauvire@medialibs.com>
 *
 * @date 2019-09-17 09:24
 */
class hook_ressources extends \Emajine_Hooks
{
  /**
   * Remplacement du système de construction de l'image
   *
   * @param int    $mediaId     Identifiant de l'image
   * @param string $path        Chemin de l'image
   * @param string $name        Le nom de l'image
   * @param string $img         La balise html img complète
   * @param bool   $isThumbnail Utilise-t-on l'image réduite
   *
   * @return null|string
   */
  public function replaceImgTag($mediaId, $path, $name, &$img, $isThumbnail)
  {
    // Ajoute l'attribut itemprop="image"
    return str_replace('>', ' itemprop="image">', $img);
  }
}
