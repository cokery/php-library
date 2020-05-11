<?php

namespace cokery\lib;

class Arr
{
    /**
     *  无限级遍历
     *  $data   原始数组，必须包含id，pid
     *  $pid    父级id
     * @return array
     */
    function tree($data, $pid)
    {
        $tree = array();
        foreach ($data as $k => $v) {
            if ($v['pid'] == $pid) {
                $v['child'] = $this->tree($data, $v['id']);
                $tree[] = $v;
                unset($data[$k]);
            }
        }
        return $tree;
    }

    /**
     *  递归
     *  $data   原始数组，必须包含id，pid
     *  $pid    父级id
     * @return array
     */
    function digui($data, $pid)
    {
        $arr = array();

        foreach ($data as $key => $d) {
            if ($d['pid'] == $pid) {
                $arr[] = $d;
                $arr = array_merge($arr, $this->digui($data, $d['id']));
            }
        }

        return $arr;
    }
}
