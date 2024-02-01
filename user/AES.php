<?php
echo (base64_decode(openssl_decrypt($_GET['raw'],"AES-128-ECB","CPTBTPTP",0,"114514")));
?>