<?php

namespace cokery\lib;

use cokery\lib\File;
use cokery\lib\Option;

class Directory
{
    public static function info($path)
    {
        return File::info($path);
    }

    /**
     * Create Directory
     *
     * @param String $path path
     * @param Int $mode 0777
     * @return void
     */
    public static function create($path, $mode = 0777)
    {
        if (is_null($path) || $path == "" || is_dir($path)) {
            return false;
        } else {
            // StandardizePath
            $path = self::standardizePath($path);

            $tmp = '';
            // check OS
            if (Option::os() == 'windows') {
                $arr = explode('\\', $path);
            } else {
                $arr = explode('/', $path);
            }

            foreach ($arr as $str) {
                $tmp .= $str . '/';
                $tmp . PHP_EOL;
                if (!is_dir($tmp)) {
                    return mkdir($tmp, $mode);
                }
            }
        }
    }

    /**
     * Delete Directory
     *
     * @param String $path path
     * @return void
     */
    public static function del($path)
    {
        // check $path
        if (is_dir($path)) {
            // StandardizePath
            $path = self::standardizePath($path);

            if ($handle = opendir($path)) {
                while (($file = readdir($handle)) !== false) {
                    if ($file == "." or $file == "..") continue;
                    $file = $path . DIRECTORY_SEPARATOR . $file;
                    //  表示$file是$path
                    if (is_dir($file)) {
                        self::del($file);
                    } else {
                        unlink($file);
                    }
                }
                closedir($handle);
                // 删除空文件夹
                return rmdir($path);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Move Directory
     * 
     * @param String $folder with path
     * @param String $newFolder  with path
     * @param boolean $overWrite
     * @return boolean
     */
    public static function move($folder, $newFolder, $overWrite = false)
    {
        $folder    = self::standardizePath($folder);
        $newFolder = self::standardizePath($newFolder);

        if (is_dir($folder)) {
            if (!is_dir($newFolder)) {
                self::create($newFolder);
            }
    
            // 文件操作
            if ($dirHandle = opendir($folder)) {
                while (false !== ($file = readdir($dirHandle))) {
                    if ($file == '.' || $file == '..') {
                        continue;
                    }

                    if (!is_dir($folder . $file)) {
                        File::move($folder . $file, $newFolder . $file, $overWrite);
                    } else {
                        self::move($folder . $file, $newFolder . $file, $overWrite);
                    }
                }
                closedir($dirHandle);
                return rmdir($folder);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 复制文件夹
     *
     * @param String $folder
     * @param String $newFolder
     * @param boolean $overWrite
     * @return boolean
     */
    public static function copy($folder, $newFolder, $overWrite = false)
    {
        // 规范化路径
        self::standardizePath($folder);
        self::standardizePath($newFolder);

        if (!is_dir($folder)) {
            return false;
        }
        if (!file_exists($newFolder)) {
            self::create($newFolder);
        }
        $dirHandle = opendir($folder);
        while (false !== ($file = readdir($dirHandle))) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (!is_dir($folder . $file)) {
                File::duplicate($folder . $file, $newFolder . $file, $overWrite);
            } else {
                self::copy($folder . $file, $newFolder . $file, $overWrite);
            }
        }
        return closedir($dirHandle);
    }

    /**
     * 重命名文件夹
     *
     * @param String $folder PathName
     * @param String $newName
     * @param boolean $overWrite
     * @return boolean
     */
    public static function rename($folder, $newName, $overWrite = false)
    {
        // 规范化路径
        self::standardizePath($folder);

        if (is_dir($folder)) {
            $dir = pathinfo($folder, PATHINFO_DIRNAME);   // 获取文件路径
            $newFolder = $dir . "/" . $newName;       // 拼接新文件路径

            if (is_dir($newFolder)) {
                if ($overWrite = false) {
                    return false;
                } else {
                    self::del($newFolder);        // 删除已存在的新文件
                    return rename($folder, $newFolder);     // 重命名文件
                }
            } else {
                return rename($folder, $newFolder);         // 重命名文件
            }
        } else {
            return false;
        }
    }


    /**
     * 返回目录字节大小
     *
     * @param String $folder
     * @param boolean $trans
     * @return String
     */
    public static function getSize($folder, $trans = true)
    {
        // 检查文件夹是否存在
        if (is_dir($folder)) {
            // 打开文件句柄
            if ($handle = opendir($folder)) {
                // 初始化文件夹大小
                $size = 0;
                // 循环计算文件夹大小
                while (false !== ($file = readdir($handle))) {

                    if ($file == "." or $file == "..") continue;

                    // 子目录文件拼接
                    $file = $folder . "/" . $file;

                    // 子目录文件类型判断
                    if (is_dir($file)) {
                        echo $size += self::getSize($file) . "<br >";
                    } else {
                        echo $size += filesize($file) . "<br >";
                    }
                }
                closedir($handle);

                // 字节大小转换开关
                if ($trans) {
                    return File::transByte($size);
                } else {
                    return $size;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 返回目录所在磁盘空间大小
     *
     * @param String $folder
     * @param boolean $trans
     * @return String
     */
    public static function getDiskSize($folder, $trans = true)
    {
        if (is_dir($folder)) {
            // 获取磁盘大小
            $size = disk_total_space($folder);
            // 字节大小转换
            if ($trans) {
                return File::transByte($size);
            } else {
                return $size;
            }
        }
    }

    /**
     * 返回目录所在磁盘剩余空间大小
     *
     * @param String $folder
     * @param boolean $trans
     * @return String
     */
    public static function getFreeSize($folder, $trans = true)
    {
        if (is_dir($folder)) {
            // 获取磁盘大小
            $size = disk_free_space($folder);
            // 字节大小转换
            if ($trans) {
                return File::transByte($size);
            } else {
                return $size;
            }
        }
    }

    public static function transPath($path)
    {
        if (Option::os() == 'windows') {
            return str_replace('\\', DIRECTORY_SEPARATOR,  $path);
        }
    }

    public static function standardizePath($path)
    {
        $path = self::transPath($path);
        if (Option::os() == 'windows') {
            return substr($path, -1) == '/' ? $path : $path . '\\';
        }else{
            return substr($path, -1) == '/' ? $path : $path . '/';
        }

    }
}
