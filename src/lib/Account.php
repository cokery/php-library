<?php

namespace cokery\lib;

class Arr
{
    public function login($username, $password, $captcha = null)
    {
        // 校验
        // 是否已登录
        //  获取IP地址，并给定默认值
        // 验证
    }

    public function register($username, $password, $captcha = null, $invitation = null)
    {
        // 校验
        // 是否已存在
        //  获取IP地址，并给定默认值
        //  新增 用户
        //  判断是否为邀请注册
    }

    public function logout()
    {
    }
}
