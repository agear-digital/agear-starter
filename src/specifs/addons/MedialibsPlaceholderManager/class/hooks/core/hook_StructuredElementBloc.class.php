<?php
namespace Addon\MedialibsPlaceholderManager;
require_once \em_misc::getSpecifPath() . 'addons/MedialibsPlaceholderManager/class/tools/FormTools.class.php';
/**
 * Classe qui gère l'ajout du texte du placeholder dans le e-majine 
 * 
 * Gestion des éléments en bloc (article, formulaire, diaporama, préformatés, ...)
 *
 * @author Eric de Medialibs <eric@medialibs.com>
 *
 * @date 2019-11-28 15:15
 */
class hook_StructuredElementBloc extends \Emajine_Hooks
{
	const CONTACT_FORM_TEXT_MANAGE_CLASS  = 'formText';
	const CONTACT_FORM_MAIL_MANAGE_CLASS  = 'formMail';
	const CONTACT_FORM_AREA_MANAGE_CLASS  = 'formArea';
	const CONTACT_FORM_DATE_MANAGE_CLASS  = 'formDate';
	const PROFIL_FORM_TEXT_MANAGE_CLASS   = 'profileText';
	const PROFIL_FORM_AREA_MANAGE_CLASS   = 'profileArea';
	const PROFIL_FORM_DATE_MANAGE_CLASS   = 'profileDate';
	const PROFIL_FORM_LOGIN_MANAGE_CLASS  = 'profileLogin';
	const PROFIL_FORM_PASSWD_MANAGE_CLASS = 'profilePassword';

	const PLACEHOLDER_LABEL = 'Texte indicatif par défaut';
	const PLACEHOLDER_PASSWD_VERIFY_LABEL = 'Texte indicatif du champ de confirmation de mot de passe';

	private static $formClassRequiredPlaceholder = array(
		self::CONTACT_FORM_TEXT_MANAGE_CLASS,
		self::CONTACT_FORM_MAIL_MANAGE_CLASS,
		self::CONTACT_FORM_AREA_MANAGE_CLASS,
		self::CONTACT_FORM_DATE_MANAGE_CLASS,
		self::PROFIL_FORM_TEXT_MANAGE_CLASS,
		self::PROFIL_FORM_AREA_MANAGE_CLASS,
		self::PROFIL_FORM_DATE_MANAGE_CLASS,
		self::PROFIL_FORM_LOGIN_MANAGE_CLASS,
		self::PROFIL_FORM_PASSWD_MANAGE_CLASS
	);
	const PLACEHOLDER_FIELD_NAME  		 = 'specif_field_placeholder';
	const PLACEHOLDER_PASSWD_VERIFY_NAME = 'specif_field_placeholder_pass_verify';

	/**
	 * Modification du formulaire de contact et de profil dans le manage
	 *
	 * @param string $className Type de bloc
	 * @param string $mode Type d'action "add" ou "edit"
	 * @param MediapublishForm $form Formulaire
	 *
	 * @return null
	 */
	public function completeGetFormDatas($className, $mode, &$form)
	{
		if (in_array($className, self::$formClassRequiredPlaceholder)) {
			$form->addElement('text', self::PLACEHOLDER_FIELD_NAME, self::PLACEHOLDER_LABEL, array());
			// changement de place du field
			$placeholderField = array($form->CDatasFormulaire[FormTools::getIndexByName(self::PLACEHOLDER_FIELD_NAME, $form)]);
            unset($form->CDatasFormulaire[FormTools::getIndexByName(self::PLACEHOLDER_FIELD_NAME, $form)]);
            array_splice($form->CDatasFormulaire, 3, 0, $placeholderField);
            if ($className == self::PROFIL_FORM_PASSWD_MANAGE_CLASS) {
				$form->addElement('text', self::PLACEHOLDER_PASSWD_VERIFY_NAME, self::PLACEHOLDER_PASSWD_VERIFY_LABEL, array());
				$form->addElement('description', $this->getJsVerifyPass());
            }
		}
	}

	/**
     * Récupère l'index d'un champ par rapport à son name
     *
     * @param string $name
     * @param Emajine_Form $form
     *
     * @return int
     */
    private function getIndexByName($name, $form)
    {
        foreach ($form->CDatasFormulaire as $key => $input) {
            if ($input['fields_input']['name'] == $name) {
                return $key;
            }
        }
    }

    /**
     * Gère le js pour le champ de confirmation de mot de passe
     * 
     * @return string
     */
    private function getJsVerifyPass()
    {
    	return '<script type="text/javascript">
    		$("#verify").change(function() { 
				if ($(this).is(":checked")) {
					$("#div' . self::PLACEHOLDER_PASSWD_VERIFY_NAME . '").show();
				} else {
					$("#' . self::PLACEHOLDER_PASSWD_VERIFY_NAME . 'id' . '").val("");
					$("#div' . self::PLACEHOLDER_PASSWD_VERIFY_NAME . '").hide();
				}
			});
    		</script>';
    }  
}