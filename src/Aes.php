<?php
/**
 * @author ThedoRap||Reaper <a@0oo.ren>
 */

namespace Aes;

/**
 * 基于 openssl 扩展的 AES 加解密
 *
 * 支持  ECB , CBC , CFB , OFB
 * 兼容 openssl 命令行
 */
class Aes
{
    /**
     * @param string $method 加解密方法，可通过openssl_get_cipher_methods()获得
     */
    protected $method;

    /**
     * @param string $key 加解密的密钥
     */
    protected $key;

    /**
     * @param string $iv iv偏移量，ecb模式不用填写
     */
    protected $iv;

    /**
     * @param string $options 数据格式选项
     * 可填：
     * 0
     * OPENSSL_RAW_DATA=1
     * OPENSSL_ZERO_PADDING=2
     * OPENSSL_NO_PADDING=3
     */
    protected $options;


    /**
     * 初始化
     * @param string $key 密钥
     * @param string $iv iv偏移量
     * @param string $method 加解密算法
     * @param int $options 数据格式选项
     * @return object
     */
    public static function config($key = "123456", $iv = "123456", $method = "aes-256-cbc", $options = 0)
    {
        $Aes = new Aes();
        $Aes->method = $method;
        $Aes->iv = $iv;
        $Aes->key = $key;
        $Aes->options = $options;
        return $Aes;
    }

    /**
     * 加密
     * @param string $data
     * @return string
     */
    public function encrypt($data)
    {
        $encrypted = openssl_encrypt($this->pkcsPadding($data, rand(100, 999)), $this->method, $this->key, 0, $this->iv);
        return base64_encode($encrypted);
    }

    /**
     * 解密
     *
     * @param string $data
     * @return string
     */
    public function decrypt($data)
    {
        $base64 = openssl_decrypt(base64_decode($data), $this->method, $this->key, 0, $this->iv);
        return $this->unPkcsPadding($base64);
    }

    /**
     * 删除补全
     *
     * @param $str
     * @return string
     */
    private function unPkcsPadding($str)
    {
        $len = strlen($str) - 1;
        return str_replace($str{$len}, '', $str);
    }

    /**
     * 补全
     * 128-255 为 八进制 ASCII码
     *
     * @param $str
     * @param $blocksize
     * @return string
     */
    private function pkcsPadding($str, $blocksize)
    {
        $pad = $blocksize - (strlen($str) % $blocksize);
        return $str . str_repeat(chr(rand(128, 255)), $pad);
    }

}
