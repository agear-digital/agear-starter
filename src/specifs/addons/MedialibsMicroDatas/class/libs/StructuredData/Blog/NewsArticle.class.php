<?php
namespace Addon\MedialibsMicroDatas;

require_once \em_misc::getClassPath() . '/core/Emajine/Blog/ArticleRessourceDb.php';
require_once \em_misc::getClassPath() . '/core/Emajine/Blog/AuthorDb.php';
require_once \em_misc::getClassPath() . '/core/Emajine/Blog/PostsDb.php';
require_once \em_misc::getClassPath() . '/mods/rubriques/publicationMethod/getPosts.class.php';
require_once \em_misc::getSpecifPath() . 'addons/MedialibsMicroDatas/class/libs/Ressources/Medias/Image.class.php';

/**
 * La classe StructuredData_Blog_NewsArticle permet d'obtenir les données structurées d'un billet de blog
 *
 * @author Antony de Medialibs <a.chauvire@medialibs.com>
 *
 * @date 2019-10-11 09:45
 */
class StructuredData_Blog_NewsArticle
{
  /**
   * Le nom de la variable dans la table config stockant le logo de l'organisation qui publie les actualités
   */
  const NEWS_PUBLISHER_LOGO = 'newsPublisherLogo';
  /**
   * Le nom de la variable dans la table config stockant le nom de l'organisation qui publie les actualités
   */
  const NEWS_PUBLISHER_NAME = 'newsPublisherName';
  
  protected $emajineBlogArticle; 
  protected $emajineBlogPost;
  protected $emajineBlogPostAuthor;  
  protected $postId;
  protected $postImage;
  protected $publisherLogo;
  protected $publisherLogoHeight;
  protected $publisherLogoWidth;
  protected $publisherLogoUrl;
  protected $publisherName;

  public function __construct($postId)
  {
      $this->postId = $postId;
      $this->getPostData();
      $this->getPostArticle();
      $this->getPostAuthor();
      $this->setPostImage();
      $this->setPublisherName();
      $this->setPublisherLogo();
  }

  public function getJSONLD()
  {
    // Chemin vers le template du script JSON-LD
    $template = \em_misc::getSpecifPath() . 'addons/MedialibsMicroDatas/templates/structured_blog_news_article.html';
    // Initialisation du moteur de template
    $mx = \em_mx::initMx($template);
    // Ecriture des données dans le template
    \em_mx::text($mx, 'url', \em_misc::getUrlWithDomain(\getPosts::getPostDetailUrl($this->postId, $this->emajineBlogPost->getLabel())));
    \em_mx::text($mx, 'headline', $this->emajineBlogPost->getLabel());
    \em_mx::text($mx, 'dateModified', date('Y-m-d H-i-s', $this->emajineBlogPost->getDateModi()));
    \em_mx::text($mx, 'datePublished', $this->emajineBlogPost->getPublicationDate());
    \em_mx::text($mx, 'publisherName', $this->publisherName);
    \em_mx::text($mx, 'publisherLogoUrl', $this->publisherLogo->getAbsoluteURL());
    \em_mx::text($mx, 'publisherLogoWidth', $this->publisherLogo->getWidth());
    \em_mx::text($mx, 'publisherLogoHeight', $this->publisherLogo->getHeight());
    \em_mx::text($mx, 'description', json_encode($this->emajineBlogArticle->getShortDescription(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE));
    \em_mx::text($mx, 'authorName', $this->emajineBlogPostAuthor->getSurname() . ' ' . $this->emajineBlogPostAuthor->getName());
    \em_mx::text($mx, 'imageUrl', $this->postImage->getAbsoluteURL());
    \em_mx::text($mx, 'imageWidth', $this->postImage->getWidth());
    \em_mx::text($mx, 'imageHeight', $this->postImage->getHeight());
    // Retourne le script JSON-LD
    return \em_mx::write($mx);
  }

  /**
   * Récupère les données de la ressource Article utilisée par le billet de blog
   *
   * @return void
   */
  protected function getPostArticle()
  {
    $emajineBlogArticleDb = new \Emajine_Blog_ArticleRessourceDb();
    $this->emajineBlogArticle = $emajineBlogArticleDb->one($this->postId);
  }

  /**
   * Récupère les données de l'auteur du billet de Blog
   *
   * @return void
   */
  protected function getPostAuthor()
  {
    $emajineBlogAuthorDb = new \Emajine_Blog_AuthorDb();
    $this->emajineBlogPostAuthor = $emajineBlogAuthorDb->one($this->emajineBlogPost->getAuthorId());
  }

  /**
   * Récupère les données du billet de Blog
   *
   * @return void
   */
  protected function getPostData()
  {
    $emajineBlogPostDb = new \Emajine_Blog_PostsDb();
    $this->emajineBlogPost = $emajineBlogPostDb->readByArticleId($this->postId);
  }

  /**
   * Renseigne l'image du billet de blog
   *
   * @return void
   */
  protected function setPostImage()
  {
    $this->postImage = new Ressources_Medias_Image($this->emajineBlogArticle->getPicture());
  }

  /**
   * Renseigne le nom de la société publiant l'article
   *
   * @return void
   */
  protected function setPublisherName()
  {
    $this->publisherName = \em_db::one('SELECT value FROM config WHERE varname = \'' . self::NEWS_PUBLISHER_NAME . '\'');
  }

  /**
   * Renseigne le logo de la société publiant l'article
   *
   * @return void
   */
  protected function setPublisherLogo()
  {
    $media = \em_db::one('SELECT value FROM config WHERE varname = \'' . self::NEWS_PUBLISHER_LOGO . '\'');
    $this->publisherLogo = new Ressources_Medias_Image($media);
  }
}