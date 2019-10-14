<?php
/**
 * MedialibsMicroDatas
 *
 * 
 *
 * @author Medialibs
 *
 * @date 2018-07-12
 */

require_once \em_misc::getSpecifPath() . '/addons/MedialibsMicroDatas/class/tools/interface/InterfaceScreen.class.php';

class MedialibsMicroDatas
{
	public function start()
	{
		$is = new Addon\MedialibsMicroDatas\InterfaceScreen();
		$is->start();
	}
}