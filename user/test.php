<?php
    $config = array(
        "digest_alg" => "sha512",
        "private_key_bits" => 2048,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    );
    // 生成密钥对
    $res = openssl_pkey_new($config);
    
    // 获取私钥
    openssl_pkey_export($res, $private_key);
    
    // 获取公钥
    $public_key = openssl_pkey_get_details($res);
    $public_key = $public_key['key'];
    echo($public_key);
    echo($private_key);
    echo("===\n");
    $data = 'Hello RSA2';
    
    // 使用公钥加密数据
    openssl_public_encrypt($data, $encrypted, $public_key);
    
    // 将加密后的数据转换为Base64编码的字符串
    $base64_encrypted = base64_encode($encrypted);
    
    // 使用私钥解密数据
    openssl_private_decrypt(base64_decode($base64_encrypted), $decrypted, $private_key);
    
    echo $decrypted; // 输出：Hello RSA2
?>