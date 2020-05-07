<?php
namespace Addon\MedialibsPlaceholderManager;
/**
 * Gère l'affichage du placeholder dans les formulaires des articles (contacter nous) côté front
 *
 * @author Eric de Medialibs <eric@medialibs.com>
 *
 * @date 2019-11-29 09:59
 */
class hook_form extends \Emajine_Hooks
{
	const PLACEHOLDER_FIELD_NAME = 'specif_field_placeholder';
	const INPUT_AREA_TYPE = 'area';

	/**
	 * Intervention lors de l'initialisation du formulaire
	 *
	 * @param int $formID Identifiant du formulaire
	 *
	 * @return null
	 */
	public function onInit($formID)
	{
		unset($_SESSION[\em_misc::getUserId() . '_formId']);
		if (!empty($formID)) {
			$_SESSION[\em_misc::getUserId() . '_formId'] = $formID;
		}
	}

	/**
	 * Récuperer les détails de chaque input du formulaire
	 * 
	 * @param int $idForm
	 * @param 
	 * 
	 * @return array
	 */
	private function getInputsDetails($formId, $idStructure = null)
	{
		//  name@=@Name@!@value@=@NOM@!@specif_field_placeholder@=@xxx111@!@size@=@@!@maxlength@=@@!@style@=@@!@information@=@
		$globalDataStructured = array();
		if (!is_null($idStructure)) {
			$structure = \em_db::one('SELECT structure FROM ressource_form_structure WHERE id_structure = ' . $idStructure);

			$structureElement = explode('@!@', $structure);
			return $this->generateStructuredData($structureElement);
		} 
		$structures = \em_db::assoc('SELECT id_structure, structure FROM ressource_form_structure WHERE id_form = ' . $formId);
		foreach ($structures as $idStructure => $structure) {
			$structureElement = explode('@!@', $structure);
			$globalDataStructured[$idStructure] = $this->generateStructuredData($structureElement);
		}
		return $globalDataStructured;
	}

	/**
	 * Parser le string contenant les details d'input
	 * 
	 * @param string
	 * 
	 * @return array
	 */ 
	private function generateStructuredData($structureElement)
	{
		$globalDataStructured = array();
		foreach ($structureElement as $element) {
				$fieldNameAndValue = explode('@=@', $element);
				$dataStructured[$fieldNameAndValue[0]] = $fieldNameAndValue[1];
			}
		return $dataStructured;
	}

	/**
	 * Intervention sur un champ du formulaire après la génération standard
	 * 
	 * Affichage du placeholder dans les ressources form (formumaire de contact) côté front
	 *
	 * @param Modelixe $mx        Template
	 * @param string   $fieldType Le type de champ
	 * @param string   $fieldName Le nom du champ
	 *
	 * @return null
	 */
	public function changeFormFieldAfterStandard($mx, $fieldType, $fieldName)
	{
		if (!\em_misc::isPublicSite()) {
			unset($_SESSION[\em_misc::getUserId() . '_formId']);
			return;
		}
		if (!isset($_SESSION[\em_misc::getUserId() . '_formId'])) {
			return;
		}
		$formDetails = $this->getInputsDetails($_SESSION[\em_misc::getUserId() . '_formId']);
		foreach ($formDetails as $idStructure => $formDetail) {
			// remplacement des caractères accentué en vide
			$inputFieldNameFromDb = preg_replace("/[^a-zA-Z_]/", "", strtolower(str_replace(' ', '_', $formDetail['name'])));
			if ($fieldName == $inputFieldNameFromDb || 'field' . $idStructure == $fieldName) {
				\em_mx::attr($mx, 'placeholder', $formDetail[self::PLACEHOLDER_FIELD_NAME]);
			}
		}
	}

	/**
	 * Modification des champs de formulaire à afficher
	 * 
	 * Récupération des placeholders des champs de type area et date
	 *
	 * @param int $formID Identifiant du formulaire
	 * @param array $formFields Champs courants
	 *
	 * @return array
	 */
	public function getFormFields($formID, &$formFields)
	{
		// Récupération des placeholder pour les formulaires de type area ou date
		$fieldsInput = array();
		foreach ($formFields as $formField) {
			$inputType = explode('!', $formField['fields_input'])[0];
			if (empty($formField['id']) || $inputType == 'text') {
				continue;
			}
			$fieldsInput[$formField['id']]['fields_name']  = explode('!', $formField['fields_input'])[1];
			$fieldsInput[$formField['id']]['fields_input'] = $formField['fields_input'];
			$fieldsInput[$formField['id']]['inputType']    = $inputType;
		}
		$placeholders = array();
		foreach ($fieldsInput as $key => $fieldInput) {
			$idStructure = intval(str_replace('field', '', $key));
			$placeholders[$fieldInput['fields_name']]['placeholder'] = $this->getInputsDetails(null, $idStructure)[self::PLACEHOLDER_FIELD_NAME];
			$placeholders[$fieldInput['fields_name']]['inputType'] = $fieldInput['inputType'];
		}
		// session qui sera utilisé dans le js specifs/addons/MedialibsPlaceholderManager/class/hooks/core/hook_PublicSite.class.php
		$_SESSION['placeholdersFields'] = $placeholders;
	}
}