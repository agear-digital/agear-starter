<?php
namespace Addon\MedialibsHTMLDateRenderer;

/**
 * Gestion de la balise MX "La balise MX permet de modifier le rendu HTML d\'une date passée en paramètre"
 *
 * @author [] <[]@medialibs.com>
 *
 * @since 2019-10-14
 */
function getSpecifTagDateRenderer($value)
{
	$objectName = 'Addon\\MedialibsHTMLDateRenderer\\mxDateRenderer';
	\em_misc::loadPHP(__DIR__ . '/dateRenderer.class.php', $objectName);
	$obj = new $objectName();
	preg_match_all('/([a-z]*)="([^"]*)"/', $value[2], $matches, PREG_SET_ORDER);
	foreach ($matches as $params) {
		$obj->setTagParams($params[1], $params[2]);
	}
	$obj->setDevPath($path);
	return $obj->start();
}
