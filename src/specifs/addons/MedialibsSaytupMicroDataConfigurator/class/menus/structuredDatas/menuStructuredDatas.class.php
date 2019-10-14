<?php
namespace Addon\MedialibsSaytupMicroDataConfigurator;
require_once \em_misc::getSpecifPath() . 'addons/MedialibsSaytupMicroDataConfigurator/class/tools/form/NewsArticleForm.class.php';
require_once \em_misc::getClassPath() . '/core/Emajine_API/Emajine_2C.class.php';
/**
 * Gestion du menu Données structurées
 * 
 * La classe menuStructuredDatas permet de générer l'écran de configuration des données structurées
 * accessibles à partir de Référencement > Données structurées
 * 
 * @author Antony de Medialibs <a.chauvire@medialibs.com>
 *
 */
class menuStructuredDatas extends \Emajine_2C
{
  /**
   * Le nom de la variable dans la table config stockant le logo de l'organisation qui publie les actualités
   */
  const NEWS_PUBLISHER_LOGO = 'newsPublisherLogo';
  /**
   * Le nom de la variable dans la table config stockant le nom de l'organisation qui publie les actualités
   */
  const NEWS_PUBLISHER_NAME = 'newsPublisherName';

	/**
     * Les différentes zones
     *
     * @var array
     */
    public $_contenersZoneItems = array(
        'Actualités' => array(
            'first'  => array('label' => 'Configuration')
        )
    );

    /**
     * La zone à afficher par défaut
     *
     * @var string
     */
    public $_contenersZoneDefaultItem = 'first';

    /**
     * Retourne la description du 2C
     * Cette méthode est prévue pour être overloadé dans les classes enfants
     *
     * @return string
     */
    protected function getContentDescription()
    {
        return 'Ma description';
    }

    /**
     * First Item
     *
     * @return string
     */
    public function _first()
    {
		return $this->_getContentForm('generateNewsArticleForm', 'onSaveNewsArticleForm', 'getDefaultValueNewsArticleForm');
    }

     /**
     * Récupérer le template à afficher
     *
     * @return string
     */
    public function generateNewsArticleForm($form)
    {
      require_once \em_misc::getClassPath() . '/core/Emajine_Debug.class.php';
      \Emajine_Debug::forceVd();
      $newsArticleForm = new NewsArticleForm();
    	$newsArticleForm->addFields($form);
    }

    /**
     * Enregistrement des données à la validation du formulaire
     *
     * @return null
     */
    public function onSaveNewsArticleForm()
    {
      // Supprime les données existantes
      $this->deleteNewsStructuredDatasConfiguration();
      // Insère les nouvelles données
      $this->insertNewsStructuredDatasConfiguration();
    }

    /**
     * Récupération des données par défaut en base
     *
     * @return array
     */
    public function getDefaultValueNewsArticleForm()
    {
      return array(
        'newsPublisherLogo' => \em_db::one('SELECT value FROM config WHERE varname = \'' . self::NEWS_PUBLISHER_LOGO . '\''),
        'newsPublisherName' => \em_db::one('SELECT value FROM config WHERE varname = \'' . self::NEWS_PUBLISHER_NAME . '\'')
      );
    }

    /**
     * Supprime les données de configuration de l'organisation qui publie les actualités
     *
     * @return bool
     */
    protected function deleteNewsStructuredDatasConfiguration()
    {
      $query = 'DELETE FROM config WHERE varname = \'' . self::NEWS_PUBLISHER_LOGO . '\' OR varname = \'' . self::NEWS_PUBLISHER_NAME . '\'';
      return \em_db::exec($query); 
    }

    /**
     * Insert les données de configuration de l'organisation qui publie les actualités
     *
     * @return bool
     */
    protected function insertNewsStructuredDatasConfiguration()
    {
      $query = 'INSERT INTO config values (\'' . self::NEWS_PUBLISHER_LOGO . '\', \'' . $_POST['newsPublisherLogo'] . '\')';
      \em_db::exec($query);
      $query = 'INSERT INTO config values (\'' . self::NEWS_PUBLISHER_NAME . '\', \'' . $_POST['newsPublisherName'] . '\')';
      return \em_db::exec($query);
    }
}
