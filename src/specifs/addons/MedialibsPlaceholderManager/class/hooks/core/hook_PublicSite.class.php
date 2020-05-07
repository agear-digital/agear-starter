<?php
namespace Addon\MedialibsPlaceholderManager;
/**
 * Classe qui gère l'affichage des placeholders pour les champs de type area et date
 *
 * @author Eric de Medialibs <eric@medialibs.com>
 *
 * @date 2019-12-04 17:00
 */
class hook_PublicSite extends \Emajine_Hooks
{
	/**
	 * Intervention après la génération de la page
	 * 
	 * Ajout du script js qui gère les placeholders pour les formulaires articles
	 *
	 * @param string $content Données affichées
	 * @param string $context Contexte de la génération
	 *                        	echoAndExit = Appelé lors d'un em_output::echoAndExit()
	 *                        	webograf	= Affichage du Webo Graph
	 *                        	standard 	= Affichage standard
	 *                        	closed 		= Affichage du site fermé
	 *
	 * @return null
	 */
	public function afterPageGeneration(&$content, $context)
	{
		/* session pour les placeholders des formulaires articles et profiles défini dans
		specifs/addons/MedialibsPlaceholderManager/class/hooks/acces/hook_user.class.php
		specifs/addons/MedialibsPlaceholderManager/class/hooks/ressource/hook_form.class.php
		*/
		if (!isset($_SESSION['placeholdersFields'])) {
			return;
		}
		$content = str_replace('</body>', '<script type="text/javascript">' . $this->getJs($_SESSION['placeholdersFields']) . '</script></body>', $content);
	}

	/**
	 * Récuperer le js qui gère les placeholdes
	 * 
	 * @param array data
	 * 
	 * @return string
	 */ 
	private function getJs($data)
	{
		$js = '(function() {';
		foreach ($data as $inputName => $inputData) {
			if ($inputData['inputType'] == 'area') {
				$inputType = 'textarea';
			} elseif ($inputData['inputType'] == 'date' || $inputData['inputType'] == 'pass') {
				$inputType = 'input';
			}
			$js .= '$("'. $inputType .'[name=\'' . $inputName .  '\']").attr("placeholder", "' . $inputData['placeholder'] . '");';
		}
		return $js . '})();';
	}
}