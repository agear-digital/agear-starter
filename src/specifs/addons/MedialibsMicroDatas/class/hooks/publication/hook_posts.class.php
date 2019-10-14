<?php
namespace Addon\MedialibsMicroDatas;

require_once \em_misc::getSpecifPath() . 'addons/MedialibsMicroDatas/class/libs/StructuredData/Blog/NewsArticle.class.php';

/**
 * Gestion de la publication de billets de blog
 *
 * @author Antony de Medialibs <a.chauvire@medialibs.com>
 *
 * @date 2019-10-08 14:57
 */
class hook_posts extends \Emajine_Hooks
{
  
  protected $newsArticle;

	/**
	 * Modification de la fiche détaillé d'un billet de blog
	 *
	 * @param modelixe $mx        Le template utilisé
	 * @param int      $idArticle Identifiant de l'article
	 *
	 * @return null
	 */
	public function beforeDisplayPostDetail($mx, $idArticle)
	{
    $this->newsArticle = new StructuredData_Blog_NewsArticle($idArticle);
    \em_mx::text($mx, 'jsonld', $this->newsArticle->getJSONLD());
	}

	/**
	 * Modification de la fiche résumé d'un billet de blog
	 *
	 * @param modelixe $mx        Le template utilisé
	 * @param int      $idArticle Identifiant de l'article
	 * @param string   $mxPrefix  Bloc mx dans lequel sont insérées les données résumées (cas d'une mise en avant)
	 *
	 * @return null
	 */
	public function beforeDisplayPostResume($mx, $idArticle, $mxPrefix = null)
	{
    \em_mx::text($mx, 'date.post_element_id', $idArticle);
	}
}