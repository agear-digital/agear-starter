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
    $this->writeDatas($mx, $idArticle);
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
    //$this->writeDatas($mx, $idArticle);   
	}

	/**
	 * Modification des billets à mettre en avant dans le widget blog
	 *
	 * @param array $post Identifiants des billets mis en avant
	 *
	 * @return null
	 */
	/*public function changeHighlightedPosts(&$post)
	{

  }*/
  
  /**
   * Retourne la date de modification d'un billet de blog
   *
   * @param int $id
   * @return string La date de modification au format 2019-10-08
   */
  protected function getModifiedDate($id)
  {
    $query = 'SELECT date_modi FROM blog_posts WHERE article_id = ' . $id;
    return date('Y-m-d', \em_db::one($query));
  }

  /**
   * Ecrit les données dans le template
   *
   * @param modeliXe $mx
   * @param int $idArticle
   * @return void
   */
  protected function writeDatas($mx, $idArticle)
  {
    \em_mx::text($mx, 'date.post_element_id', $idArticle);
    \em_mx::text($mx, 'date.post_modified_date', $this->getModifiedDate($idArticle));
    \em_mx::text($mx, 'jsonld', $this->newsArticle->getJSONLD());
  }
}