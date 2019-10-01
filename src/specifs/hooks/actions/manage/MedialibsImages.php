<?php
/**
 * MedialibsImages
 *
 * 
 *
 * @author Medialibs
 *
 * @date 2018-07-12
 */

require_once \em_misc::getSpecifPath() . '/addons/MedialibsImages/class/tools/interface/InterfaceScreen.class.php';

class MedialibsImages
{
	public function start()
	{
		$is = new Addon\MedialibsImages\InterfaceScreen();
		$is->start();
	}
}