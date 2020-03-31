<?php
namespace cokery\lib;

class Path
{
    public static function create($path,$mode = 0777)
    {
        if (is_null($path) || $path == "" || is_dir($path)) {
            return false;
        } else {
            // StandardizePath
            $path = self::standardizePath($path);

            $path = '';
            $arr = explode('/', $path);
            foreach ($arr as $str) {
                $path .= $str . '/';
                if (!file_exists($path)) {
                    return mkdir($path, $mode);
                }
            }
        }
    }

    public static function transPath($path)
    {
        return str_replace('\\', DIRECTORY_SEPARATOR,  $path);
    }

    public static function standardizePath($path)
    {
        $path = self::transPath($path);
        return substr($path, -1) == '/' ? $path : $path . '/';
    }
}