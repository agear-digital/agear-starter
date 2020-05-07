<?php
/**
 * MedialibsPlaceholderManager
 *
 * 
 *
 * @author Medialibs
 *
 * @date 2018-07-12
 */

require_once \em_misc::getSpecifPath() . '/addons/MedialibsPlaceholderManager/class/tools/interface/InterfaceScreen.class.php';

class MedialibsPlaceholderManager
{
	public function start()
	{
		$is = new Addon\MedialibsPlaceholderManager\InterfaceScreen();
		$is->start();
	}
}