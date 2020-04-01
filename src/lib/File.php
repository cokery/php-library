<?php

namespace cokery\lib;

use SplFileInfo;
use cokery\lib\Directory;

/**
 * FileInterFace
 */
interface FileInterface
{
	public static function info($file);
	public static function create($file, $overwrite = false);
	public static function del($file);
	public static function move($file, $newFile, $overWrite = false, $bothSave = false);
	public static function duplicate($file, $newFile, $overWrite = false, $bothSave = false);
	public static function read($file, $writingMode = 'string');
	public static function write($file, $str, $overWrite = false);
	public static function transByte($size);
}

/**
 * File Class Library
 */
class File  implements FileInterface
{
	/**
	 * Get File Info Based On SplFileInfo
	 *
	 * @param String $file pathName
	 * @return void
	 */
	public static function info($file)
	{
		if (is_file($file) || is_dir($file)) {
			return new SplFileInfo($file);
		} else {
			return false;
		}

		// $path = 'D:\www\htdoc\php-library\src\lib\File.php';
		// $info->getBaseName(); 	// string(8) "File.php"
		// $info->getFileName(); 	// string(8) "File.php"
		// $info->getPathName(); 	// string(41) "D:\www\htdoc\php-library\src\lib\File.php"
		// $info->getPath();     	// string(32) "D:\www\htdoc\php-library\src\lib"
		// $info->getRealPath(); 	// string(41) "D:\www\htdoc\php-library\src\lib\File.php"
		// $info->getFileInfo(); 	// object
		// $info->getPathInfo(); 	// object
		// $info->getATime();    	// int(1585576426)
		// $info->getCTime();    	// int(1585571786)
		// $info->getMTime();    	// int(1585576422)
		// $info->getExtension();	// string(3) "php"
		// $info->getType();     	// string(4) "file"
		// $info->getSize();     	// int(335)
		// $info->getPerms();    	// int(33206)
		// $info->getOwner();    	// int(0)
		// $info->getGroup();    	// int(0)
		// $info->getInode();	 	// int(0)
		// $info->getLinkTarget();  // string(41) "D: \www\htdoc\php-library\src\lib\File.php"
		// $info->isDir();  		// bool(false)
		// $info->isFile(); 		// bool(true)
		// $info->isLink(); 		// bool(false)
		// $info->isReadable();     // bool(true)
		// $info->isWritable();     // bool(true)
		// $info->isExecutable();   // bool(false)
	}

	/**
	 * Create File
	 *
	 * @param String $file pathName
	 * @param boolean $overwrite false
	 * @return Boolean
	 */
	public static function create($file, $overwrite = false)
	{
		if (is_file($file)) {
			if ($overwrite == true) {
				// delete existed file
				Self::del($file);

				// create file
				return touch($file);
			} else {
				return false;
			}
		} else {
			// get file path
			$path = pathinfo($file)['dirname'];

			if (!is_dir($path)) {
				Directory::create($path);
			}

			// create file
			return touch($file);
		}
	}

	/**
	 * Delete File
	 *
	 * @param String $file pathName
	 * @return Boolean
	 */
	public static function del($file)
	{
		if (is_file($file)) {
			$res = unlink($file);
			clearstatcache();
			return $res;
		} else {
			return false;
		}
	}

	/**
	 * Move FIle
	 *
	 * @param String $file pathName
	 * @param String $newFile pathName
	 * @param boolean $overWrite false
	 * @param boolean $bothSave false
	 * @return void
	 */
	public static function move($file, $newFile, $overWrite = false, $bothSave = false)
	{
		$file    = Directory::transPath($file);
		$newFile = Directory::transPath($newFile);

		if (is_file($file)) {
			if (is_file($newFile)) {
				if ($overWrite == false) {
					// if you want to save the same file ,you should rename it
					if ($bothSave == true) {
						// get new BaseName = old filename_time.extension
						$newBaseName = pathinfo($file)['filename'] . '_' . time() . pathinfo($file)['extension'];
						// get new PathName
						$newPahName = pathinfo($newFile) . '/' . $newBaseName;
						// Rename File
						return rename($file, $newPahName);
					} else {
						return false;
					}
				} else {
					// delete existed $newFile
					self::del($newFile);

					return rename($file, $newFile);
				}
			} else {
				// get newFile path
				$newFilePath = pathinfo($newFile)['dirname'];

				if (is_dir($newFilePath)) {
					return rename($file, $newFile);
				} else {
					echo $newFilePath . PHP_EOL;
					// create file path
					Directory::create($newFilePath);
					die;

					return rename($file, $newFile);
				}
			}
		} else {
			return false;
		}
	}

	/**
	 * duplicate File
	 *
	 * @param String $file pathName
	 * @param String $newFile pathName
	 * @param boolean $overWrite false
	 * @param boolean $bothSave false
	 * @return void
	 */
	public static function duplicate($file, $newFile, $overWrite = false, $bothSave = false)
	{
		$file    = Directory::transPath($file);
		$newFile = Directory::transPath($newFile);

		if (is_file($file)) {
			if (is_file($newFile)) {
				if ($overWrite == false) {
					// if you want to save the same file ,you should rename it
					if ($bothSave == true) {
						// get new BaseName = old filename_time.extension
						$newBaseName = pathinfo($file)['filename'] . '_' . time() . '.' . pathinfo($file)['extension'];
						// get new PathName
						$newPahName = pathinfo($newFile)['dirname'] . '/' . $newBaseName;
						// Rename File
						return copy($file, $newPahName);
					} else {
						return false;
					}
				} else {
					self::del($newFile);
					return copy($file, $newFile);
				}
			} else {
				// get file path
				$path = Self::info($file)->getPath();

				if (is_dir($path)) {
					return copy($file, $newFile);
				} else {
					// create path
					Directory::create($path);

					return copy($file, $newFile);
				}
			}
		} else {
			return false;
		}
	}

	/**
	 * Read File
	 *
	 * @param String $file pathName
	 * @param String $writingMode string
	 * @return void
	 */
	public static function read($file, $writingMode = 'string')
	{
		// check file
		if (is_file($file)) {
			// check writeMode
			if ($writingMode == 'string') {
				if (function_exists("file_get_contents")) {
					return file_get_contents($file);
				} else {
					$fp = fopen($file, "rb");
					$str = fread($fp, filesize($file));
					fclose($fp);
					return $str;
				}
			} elseif ($writingMode == 'array') {
				$arr = array();
				$file = file($file);
				foreach ($file as $value) {
					$arr[] = trim($value);
				}
				return $arr;
			}
		} else {
			return false;
		}
	}

	/**
	 * Write File
	 *
	 * @param String $file pathName
	 * @param String $str string
	 * @param boolean $overWrite false
	 * @return void
	 */
	public static function write($file, $str, $overWrite = false)
	{
		if (is_file($file)) {
			// 覆盖写入
			if ($overWrite == true) {
				if (function_exists("file_put_contents")) {
					file_put_contents($file, $str);
				} else {
					$fp = fopen($file, "wb");
					fwrite($fp, $str);
					fclose($fp);
				}
			} else {
				// 文末追加写入
				if (function_exists("file_put_contents")) {
					file_put_contents($file, $str, FILE_APPEND);
				} else {
					$fp = fopen($file, "a+");
					fwrite($fp, $str);
					fclose($fp);
				}
			}
		} else {
			return false;
		}
	}

	/**
	 * Trans Byte 
	 *
	 * @param Int $size
	 * @return void
	 */
	public static function transByte($size)
	{
		$i = 1;
		$arr = array(" B", " KB", " MB", " GB", " TB", " PB", " EB");

		while ($size > 1024) {
			$size /= 1024;
			$i++;
		}
		return round($size, 2) . $arr[$i - 1];
	}

	/**
	 * Search File
	 *
	 * @param String $file baseName (fileName)
	 * @return void
	 */
	public static function search($file)
	{
	}
}
