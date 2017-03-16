<?php

declare(strict_types=1);

namespace App\Components;

use Nette;
use Tracy\Debugger;

class FileStorage extends Nette\Application\UI\Control
{

	private $dir;

	public function __construct($dir)
	{
		$this->dir = $dir;
	}

	/**
	 * Smazání souborů a složek
	 * @param $routeFile
	 * @param $folderDelete
	 */
	public function deleteDirectory($routeFile)
	{
		$this->deleteFiles($routeFile);

		return;
	}

	private function deleteFiles($routeFile)
	{
		$files = glob($routeFile . '/*');
		foreach ($files as $file) {
			is_dir($file) ? $this->deleteFiles($file) : unlink($file);
		}
		// ošetření kdyby cesta byla prázdná
		if (is_dir($routeFile."/")) rmdir($routeFile."/");
	}

	/**
	 * Kontrola a tvorba složek
	 * @param $path
	 */
	public function createDirectory($path)
	{
		$folders = array_filter(array_filter(explode("/", $path)));
		$newPath = $this->dir;
		foreach ($folders as $folder) {
			debugger::fireLog($folder);
			$newPath = $this->checkPath($newPath . "/" . $folder);
		}
	}

	/**
	 * Kontrola cesty
	 * @param $path
	 * @return mixed
	 */
	public function checkPath($path)
	{
		if (!is_dir($path)) {
			mkdir($path);
		}

		return $path;
	}

	//TODO chtělo by to sjednotit, aby adresace byla na jednom místě
	public function getUserPhotoDir($userId, $wwwDir = false)
	{
		$path ="/images/user/{$userId}_user/userPhoto";
		$allPath = $this->dir . $path;
		if (!is_dir($allPath)) $this->createDirectory($path); //TODO v ostrém provozu netřeba
		return $wwwDir ? $allPath : $path;
	}

	public function getUserDir($userId)
	{
		$path = "/images/user/{$userId}_user";
		if (!is_dir($this->dir . $path)) $this->createDirectory($path); //TODO v ostrém provozu netřeba
		return $path;
	}

	public function getDir()
	{
		return $this->dir;
	}
}