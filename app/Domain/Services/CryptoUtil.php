<?php

namespace App\Domain\Services;

class CryptoUtil {
    private string $key;
    private string $cipher = 'aes-256-cbc';

    public function __construct(string $key) {
        if (strlen($key) !== 32) {
            throw new \Exception("La clave debe tener exactamente 32 caracteres para AES-256-CBC.");
        }
        $this->key = $key;
    }

    public function encrypt(string $data): string {
        $ivLength = openssl_cipher_iv_length($this->cipher);
        $iv = openssl_random_pseudo_bytes($ivLength);
        $encrypted = openssl_encrypt($data, $this->cipher, $this->key, 0, $iv);

        // Devuelve IV + datos encriptados, codificados en base64
        return base64_encode($iv . $encrypted);
    }

    public function decrypt(string $data): string {
        $data = base64_decode($data);
        $ivLength = openssl_cipher_iv_length($this->cipher);

        $iv = substr($data, 0, $ivLength);
        $encryptedData = substr($data, $ivLength);

        return openssl_decrypt($encryptedData, $this->cipher, $this->key, 0, $iv);
    }
}
