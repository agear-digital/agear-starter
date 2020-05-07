<?php
namespace Addon\MedialibsPlaceholderManager;

/**
 * Classe utilitaire pour les formulaires 
 *
 * @author Eric de Medialibs <eric@medialibs.com>
 *
 * @date 2019-12-03 16:16
 */
class FormTools extends \Emajine_Hooks
{
	/**
     * Récupère l'index d'un champ par rapport à son name
     *
     * @param string $name
     * @param Emajine_Form $form
     *
     * @return int
     */
    public static function getIndexByName($name, $form)
    {
        foreach ($form->CDatasFormulaire as $key => $input) {
            if ($input['fields_input']['name'] == $name) {
                return $key;
            }
        }
    }
}