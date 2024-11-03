<?php
class EncryptionUtility
{
    private $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function encryptId($id)
    {
        $cipher = "aes-256-cbc";
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext = openssl_encrypt($id, $cipher, $this->key, $options = 0, $iv);
        return base64_encode($iv . $ciphertext);
    }

    public function decryptId($encryptedId)
    {
        $cipher = "aes-256-cbc";
        $data = base64_decode($encryptedId);
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = substr($data, 0, $ivlen);
        $ciphertext = substr($data, $ivlen);
        return openssl_decrypt($ciphertext, $cipher, $this->key, $options = 0, $iv);
    }
}
