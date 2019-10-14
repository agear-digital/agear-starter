<?php
namespace Addon\MedialibsSaytupMicroDataConfigurator;
/**
 * Création du formulaire de configuration desn données structurées des actualités
 *
 * @author Antony de Medialibs <a.chauvire@medialibs.com>
 */
class NewsArticleForm
{
	/**
   * Ajoute les champs du formulaire de configuration desn données structurées des actualités
   *
   * @param Emajine_Form $form
   * @return void
   */
	public function addFields($form)
	{
    // Description de l'écran
    $form->addElement('description', 'Paramétrez dans cette section les informations concernant l\'organisation publiant les actualités');
		// Ajout d'un fieldset
		$form->addElement('fieldset', 'Données structurées');
		// Ajout du champ Nom de l'organisation
		$form->addElement(
			'text',
			'newsPublisherName',
			'Nom de l\'organisation',
			array('placeholder' => 'Le nom de la société publiant les actualités'),
			true
    );
    // Ajout d'un champ de type ressource
		$form->addElement(
			'iRes',
			'newsPublisherLogo',
			'Logo de l\'organisation',
      array('ressource' => 'media'),
      true,
      '<div class=\'description\'>Le logo doit être de forme rectangulaire, et non carrée. <br />
      Le logo doit rentrer dans un rectangle de 60 x 600 pixels, et avoir exactement 60 pixels de hauteur (préférable) ou 600 pixels de largeur.<br />
      <a href="https://developers.google.com/search/docs/data-types/article#logo-guidelines" target="_blank">Consultez les guidelines Google</a>
      </div>'
		);
	}
}
