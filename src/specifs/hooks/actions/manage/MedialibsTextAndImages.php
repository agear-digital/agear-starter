<?php
/**
 * MedialibsTextAndImages
 *
 * 
 *
 * @author Medialibs
 *
 * @date 2018-07-12
 */

require_once \em_misc::getSpecifPath() . '/addons/MedialibsTextAndImages/class/tools/interface/InterfaceScreen.class.php';

class MedialibsTextAndImages
{
	public function start()
	{
		$is = new Addon\MedialibsTextAndImages\InterfaceScreen();
		$is->start();
	}
}