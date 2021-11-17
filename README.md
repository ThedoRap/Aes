# Aes

基于 openssl 扩展的 AES 加解密 支持  ECB , CBC , CFB , OFB

    <?php
    use Aes\Aes;
    
    $data = "这个是要加密的字符串";
    $key = "123456";
    $iv = "123456";

    //配置
    $Aes = Aes::config($key, $iv);

    //加密
    $encrypted = $Aes->encrypt($data);
    //解密
    $decrypted = $Aes->decrypt($encrypted);
