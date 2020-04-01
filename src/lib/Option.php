<?php
namespace cokery\lib;

class Option
{
    /**
     * check the os is windows or linux
     *
     * @return string windows / linux
     */
    public static function os()
    {
        if (strtoupper(substr(PHP_OS,0,3))==='WIN') {
            return $os = 'windows';
        }else{
            return $os = 'linux';
        }
    }
}