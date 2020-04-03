<?php

namespace cokery\lib;

class Str
{


    /**
     * 身份证号码末位校验
     *
     * @param string $idcard
     * @return void
     */
    function idcard_validate($idcard)
    {
        //  查看身份证校验码是否正确
        if (strlen($idcard) == 18) {
            $sum =
                substr($idcard, 0, 1) * 7 +
                substr($idcard, 1, 1) * 9 +
                substr($idcard, 2, 1) * 10 +
                substr($idcard, 3, 1) * 5 +
                substr($idcard, 4, 1) * 8 +
                substr($idcard, 5, 1) * 4 +
                substr($idcard, 6, 1) * 2 +
                substr($idcard, 7, 1) * 1 +
                substr($idcard, 8, 1) * 6 +
                substr($idcard, 9, 1) * 3 +
                substr($idcard, 10, 1) * 7 +
                substr($idcard, 11, 1) * 9 +
                substr($idcard, 12, 1) * 10 +
                substr($idcard, 13, 1) * 5 +
                substr($idcard, 14, 1) * 8 +
                substr($idcard, 15, 1) * 4 +
                substr($idcard, 16, 1) * 2;

            switch ($sum % 11) {
                case "0":
                    $last = "1";
                    break;
                case "1":
                    $last = "0";
                    break;
                case "2":
                    $last = "X";
                    break;
                case "3":
                    $last = "9";
                    break;
                case "4":
                    $last = "8";
                    break;
                case "5":
                    $last = "7";
                    break;
                case "6":
                    $last = "6";
                    break;
                case "7":
                    $last = "5";
                    break;
                case "8":
                    $last = "4";
                    break;
                case "9":
                    $last = "3";
                    break;
                case "10":
                    $last = "2";
                    break;
            }

            if (substr($idcard, 17, 1) == $last) {
                return true;
            } else {
                return false;
            }
        }
    }



    /**
     *数字金额转换成中文大写金额的函数
     *String Int $num 要转换的小写数字或小写字符串
     *return 大写字母
     *小数位为两位
     **/
    function get_amount($num)
    {
        $c1 = "零壹贰叁肆伍陆柒捌玖";
        $c2 = "分角元拾佰仟万拾佰仟亿";
        //  小数点保留2位
        $num = round($num, 2);
        $num = $num * 100;
        if (strlen($num) > 10) {
            return "数据太长，没有这么大的钱吧，检查下";
        }
        $i = 0;
        $c = "";
        while (1) {
            if ($i == 0) {
                $n = substr($num, strlen($num) - 1, 1);
            } else {
                $n = $num % 10;
            }
            $p1 = substr($c1, 3 * $n, 3);
            $p2 = substr($c2, 3 * $i, 3);
            if ($n != '0' || ($n == '0' && ($p2 == '亿' || $p2 == '万' || $p2 == '元'))) {
                $c = $p1 . $p2 . $c;
            } else {
                $c = $p1 . $c;
            }
            $i = $i + 1;
            $num = $num / 10;
            $num = (int) $num;
            if ($num == 0) {
                break;
            }
        }
        $j = 0;
        $slen = strlen($c);
        while ($j < $slen) {
            $m = substr($c, $j, 6);
            if ($m == '零元' || $m == '零万' || $m == '零亿' || $m == '零零') {
                $left = substr($c, 0, $j);
                $right = substr($c, $j + 3);
                $c = $left . $right;
                $j = $j - 3;
                $slen = $slen - 3;
            }
            $j = $j + 3;
        }

        if (substr($c, strlen($c) - 3, 3) == '零') {
            $c = substr($c, 0, strlen($c) - 3);
        }
        if (empty($c)) {
            return "零元整";
        } else {
            return $c . "整";
        }
    }
}
