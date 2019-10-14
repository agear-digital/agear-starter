<?php
/**
 * MedialibsHTMLDateRenderer
 *
 * 
 *
 * @author Medialibs
 *
 * @date 2018-07-12
 */

require_once \em_misc::getSpecifPath() . '/addons/MedialibsHTMLDateRenderer/class/tools/interface/InterfaceScreen.class.php';

class MedialibsHTMLDateRenderer
{
	public function start()
	{
		$is = new Addon\MedialibsHTMLDateRenderer\InterfaceScreen();
		$is->start();
	}
}