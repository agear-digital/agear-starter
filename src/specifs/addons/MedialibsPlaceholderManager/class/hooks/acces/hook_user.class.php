<?php
namespace Addon\MedialibsPlaceholderManager;

/**
 * La classe permet d'afficher les placeholders lors de la création d'un compte
 * 
 * @author Eric de Medialibs <eric@medialibs.com>
 *
 * @date 2019-12-02 10:41
 */
class hook_user extends \Emajine_Hooks
{
	const FIELD_TEXT             	 	 = 'text';
	const FIELD_AREA             	 	 = 'area';
	const FIELD_DATE	         	 	 = 'date';
	const FIELD_PASSWD	         	 	 = 'pass';
	const FORM_PROFILE_ID        	 	 = 1;
	const PLACEHOLDER_FIELD_NAME 	 	 = 'specif_field_placeholder';
	const PLACEHOLDER_PASSWD_VERIFY_NAME = 'specif_field_placeholder_pass_verify';

	private static $fieldsNeedsJs 		 = array(self::FIELD_AREA, self::FIELD_DATE, self::FIELD_PASSWD);

	/**
	 * Modification du formulaire d'inscription pour afficher les placeholders
	 *
	 * @param object $form Objet de type formulaire
	 * @param array $datas Les données du formulaire
	 * @param string $actionType, contexte dans lequel est appelé le hook
	 *
	 * @return void
	 */
	public function modifySubscriptionForm($form, &$datas, $actionType = null)
	{
		$inputDetails = $this->getInputsDetails(self::FORM_PROFILE_ID);
		foreach ($form->CDatasFormulaire as $key => $input) {
			/* On cherche si la clé de l'input est dans la liste des champs du formulaire de profile
			et son placeholder n'est pas null*/
			if (in_array($input['fieldsID'], array_keys($inputDetails))
				&& (!is_null($fieldPlaceholder = $inputDetails[$input['fieldsID']][self::PLACEHOLDER_FIELD_NAME])
				// Champs pour la confirmation de mot de passe
				|| array_key_exists(self::PLACEHOLDER_PASSWD_VERIFY_NAME, $inputDetails[$input['fieldsID']]))) {
				// Si le champ est de type date || area, on inject son placeholder, son type et son name dans la session
				if (in_array($input['fields_input']['type'], self::$fieldsNeedsJs)) {
					$placeholders[$input['fieldsID']]['placeholder'] = $fieldPlaceholder;
					$placeholders[$input['fieldsID']]['inputType']   = $input['fields_input']['type'];
					// Si le placeholder de la confirmation de mot de passe est définie
					if (array_key_exists(self::PLACEHOLDER_PASSWD_VERIFY_NAME, $inputDetails[$input['fieldsID']])
						&& !empty($inputDetails[$input['fieldsID']][self::PLACEHOLDER_PASSWD_VERIFY_NAME])) {
						$fieldPswdVerifyPlaceholder = $inputDetails[$input['fieldsID']][self::PLACEHOLDER_PASSWD_VERIFY_NAME];
						$placeholders['passwd_verify']['placeholder']  = $fieldPswdVerifyPlaceholder;
						$placeholders[$input['fieldsID']]['inputType'] = $input['fields_input']['type'];
					}
					continue;
				}
				// Si le champ est de type text
				$form->CDatasFormulaire[$key]['fields_input']['placeholder'] = $fieldPlaceholder;
			}
		}
		$_SESSION['placeholdersFields'] = $placeholders;
	}

	/**
	 * Récuperer les détails de chaque input du formulaire de profil
	 * 
	 * @param int $profileId
	 * 
	 * @return array
	 */
	private function getInputsDetails($profileId)
	{
		/*  namefr@=@Nom@!@specif_field_placeholder@=@Anarana@!@informationfr@=@<p>Votre nom</p>@!@obligatory@=@1@!@subscription@=@1@!@emajineField@=@nom@!@nameen@=@@!@informationen@=@
		*/
		$structures = \em_db::assoc('SELECT '
					. 'CASE WHEN emajineField != "" THEN emajineField '
					. 'ELSE CONCAT_WS("_", "field", id_structure) END, '
					. 'params '
					. 'FROM profiles_structure '
					. 'WHERE id_profile = ' . $profileId);
		$dataStructured = array();
		$globalDataStructured = array();
		foreach ($structures as $key => $structure) {
			$structureElement = explode('@!@', $structure);
			foreach ($structureElement as $element) {
				$fieldNameAndValue = explode('@=@', $element);
				$dataStructured[$fieldNameAndValue[0]] = $fieldNameAndValue[1];
			}
			$globalDataStructured[$key] = $dataStructured;
			$dataStructured = array();
		}
		return $globalDataStructured;
	}
}