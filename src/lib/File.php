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
	public static function delete($file);
	public static function move($file, $newFile, $overWrite = false);
	public static function copy($file, $newFile, $overWrite = false);
	public static function rename($file, $newFileName, $overWrite = false);
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
	 * @param String $file
	 * @return void
	 */
	public static function info($file)
	{
		if (is_file($file)) {
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
	 * @param String $file
	 * @param boolean $overwrite
	 * @return Boolean
	 */
	public static function create($file, $overwrite = false)
	{
		if (is_file($file)) {
			if ($overwrite == true) {
				// delete existed file
				Self::delete($file);

				// create file
				return touch($file);
			} else {
				return false;
			}
		} else {
			// get file path
			$path = Self::info($file)->getPath();

			// create path
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
	 * @param String $file
	 * @return Boolean
	 */
	public static function delete($file)
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
	 * Move File
	 *
	 * @param String $file
	 * @param String $newFile
	 * @param boolean $overWrite
	 * @return void
	 */
	public static function move($file, $newFile, $overWrite = false)
	{
		$file    = Directory::transPath($file);
		$newFile = Directory::transPath($newFile);

		// check file
		if (is_file($file)) {
			// check newFile
			if (is_file($newFile)) {
				// check $overWrite
				if ($overWrite = false) {
					return false;
				} else {
					// delete existed $newFile
					self::delete($newFile);

					return rename($file, $newFile);
				}
			} else {
				// get file path
				$path = Self::info($file)->getPath();

				// check $path
				if (is_dir($path)) {
					return rename($file, $newFile);
				} else {
					// create file path
					Directory::create($path);

					return rename($file, $newFile);
				}
			}
		} else {
			return false;
		}
	}

	/**
	 * Copy File
	 *
	 * @param String $file
	 * @param String $newFile
	 * @param boolean $overWrite
	 * @return void
	 */
	public static function copy($file, $newFile, $overWrite = false)
	{
		$file    = Directory::transPath($file);
		$newFile = Directory::transPath($newFile);
		// check file
		if (is_file($file)) {
			// check new file
			if (is_file($newFile)) {
				// check $overWrite
				if ($overWrite = false) {
					return false;
				} else {
					self::delete($newFile);
					return copy($file, $newFile);
				}
			} else {
				// get file path
				$path = Self::info($file)->getPath();

				// check path
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
	 * Rename File
	 *
	 * @param String $file
	 * @param String $newFileName
	 * @param boolean $overWrite
	 * @return void
	 */
	public static function rename($file, $newFileName, $overWrite = false)
	{
		$file = Directory::transPath($file);

		// check file
		if (is_file($file)) {
			// get file path
			$path = Self::info($file)->getPath();
			$newFile = $path . "/" . $newFileName;
			// check newFile
			if (is_file($newFile)) {
				if ($overWrite = false) {
					return false;
				} else {
					self::delete($newFile);
					return rename($file, $newFile);
				}
			} else {
				return rename($file, $newFile);
			}
		} else {
			return false;
		}
	}

	/**
	 * Read File
	 *
	 * @param String $file
	 * @param String $writingMode
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
				$file = file($file);
				$arr = array();
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
	 * @param String $file
	 * @param String $str
	 * @param boolean $overWrite
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
	 * @param [type] $size
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
}
