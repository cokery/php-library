<?php

namespace cokery\lib;

use SplFileInfo;

class File extends SplFileInfo
{
	protected $file;
	public function __construct(string $path)
	{
		parent::__construct($path);

		// // $path = 'D:\www\htdoc\php-library\src\lib\File.php';
		
		// $file->getBaseName(); // string(8) "File.php"
		// $file->getFileName(); // string(8) "File.php"
		// $file->getPathName(); // string(41) "D:\www\htdoc\php-library\src\lib\File.php"
		// $file->getPath();     // string(32) "D:\www\htdoc\php-library\src\lib"
		// $file->getRealPath(); // string(41) "D:\www\htdoc\php-library\src\lib\File.php"
		// $file->getFileInfo(); // object
		// $file->getPathInfo(); // object
		// $file->getATime();    // int(1585576426)
		// $file->getCTime();    // int(1585571786)
		// $file->getMTime();    // int(1585576422)
		// $file->getExtension();// string(3) "php"
		// $file->getType();     // string(4) "file"
		// $file->getSize();     // int(335)
		// $file->getPerms();    // int(33206)
		// $file->getOwner();    // int(0)
		// $file->getGroup();    // int(0)
		// $file->getInode();	 // int(0)
		// $file->getLinkTarget();  // string(41) "D: \www\htdoc\php-library\src\lib\File.php"
		// $file->isDir();  // bool(false)
		// $file->isFile(); // bool(true)
		// $file->isLink(); // bool(false)
		// $file->isReadable();     // bool(true)
		// $file->isWritable();     // bool(true)
		// $file->isExecutable();   // bool(false)

		// Get File FullPathName
		$this->file = $this->getPathname();
	}

	public function create($overwrite = false)
	{
		if (is_file($this->file)) {
			// 解析路径
			// ****没有的话需要创建文件路径

			if ($overwrite == true) {
				// **** 删除原始文件

				// 新建文件
				return touch($file);
			} else {
				return false;
			}
		} else {
			return touch($file);
		}
	}

	public function delete()
	{
		
	}

	public function rename()
	{
		
	}

	public function move()
	{
		
	}

	public function copy()
	{
		
	}
}
