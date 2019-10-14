<?php
namespace Addon\MedialibsMicroDatas;

/**
 * Gestion de la balise MX "La balise MX permet de transformer une valeur brute en une structure HTML utilisant des micro-données (date, note ...)"
 *
 * @author Antony de Medialibs <a.chauvire@medialibs.com>
 *
 * @since 2019-10-08
 */
function getSpecifTagMicroDatas($value)
{
	$objectName = 'Addon\\MedialibsMicroDatas\\mxMicroDatas';
	\em_misc::loadPHP(__DIR__ . '/microDatas.class.php', $objectName);
	$obj = new $objectName();
	preg_match_all('/([a-z]*)="([^"]*)"/', $value[2], $matches, PREG_SET_ORDER);
	foreach ($matches as $params) {
		$obj->setTagParams($params[1], $params[2]);
	}
	$obj->setDevPath($path);
	return $obj->start();
}
