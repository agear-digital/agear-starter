<?php
namespace Addon\MedialibsIntegrationFacilitator;

/**
 * Gestion de la balise MX "La balise displayWidget permet d\'afficher un template à n\'importe quel endroit d\'un template"
 *
 * @author [] <[]@medialibs.com>
 *
 * @since 2019-11-08
 */
function getSpecifTagDisplayWidget($value)
{
	$objectName = 'Addon\\MedialibsIntegrationFacilitator\\mxDisplayWidget';
	\em_misc::loadPHP(__DIR__ . '/displayWidget.class.php', $objectName);
	$obj = new $objectName();
	preg_match_all('/([a-z]*)="([^"]*)"/', $value[2], $matches, PREG_SET_ORDER);
	foreach ($matches as $params) {
		$obj->setTagParams($params[1], $params[2]);
	}
	$obj->setDevPath($path);
	return $obj->start();
}
