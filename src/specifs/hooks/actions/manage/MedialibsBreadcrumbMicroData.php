<?php
/**
 * MedialibsBreadcrumbMicroData
 *
 * 
 *
 * @author Medialibs
 *
 * @date 2018-07-12
 */

require_once \em_misc::getSpecifPath() . '/addons/MedialibsBreadcrumbMicroData/class/tools/interface/InterfaceScreen.class.php';

class MedialibsBreadcrumbMicroData
{
	public function start()
	{
		$is = new Addon\MedialibsBreadcrumbMicroData\InterfaceScreen();
		$is->start();
	}
}