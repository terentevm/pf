<?php

namespace tm\auth;

/**
 * Implemetns jwt authorisation
 */

 class JWT
 {
    private $header;
    private $payload = [];
    private $signature;

    private $secretKey = 'fsdf7f99sdf9-sd9f898ds-g8fdg78-74353d&$^%1';

    public function __construct($payload) {
        $this->header = [
            'type' => 'jwt',
            'alg' => 'HS256'
        ];

        $this->payload = $payload;
    }

    public function createToken() {
        $header_enc = $this->base64UrlEncode(json_encode($this->header));
        $payload_enc = $this->base64UrlEncode(json_encode($this->payload));
        $dataEncoded = "$header_enc.$payload_enc";
 
        $rawSignature = \hash_hmac('sha256', $dataEncoded, $this->secretKey, true);
 
        $signatureEncoded = $this->base64UrlEncode($rawSignature);
 
        // Delimit with second period (.)
        $jwt = "$dataEncoded.$signatureEncoded";
 
        return $jwt;
    }

    public function verifyJWT(string $jwt): bool
    {
        list($headerEncoded, $payloadEncoded, $signatureEncoded) = explode('.', $jwt);
     
        $dataEncoded = "$headerEncoded.$payloadEncoded";
     
        $signature = $this->base64UrlDecode($signatureEncoded);
     
        $rawSignature = \hash_hmac('sha256', $dataEncoded, $this->secretKey, true);
     
        return \hash_equals($rawSignature, $signature);
    }

    private function base64UrlEncode(string $data): string {
        $urlSafeData = strtr(base64_encode($data), '+/', '-_');
 
        return rtrim($urlSafeData, '='); 
    } 
 
    private function base64UrlDecode(string $data): string {
        $urlUnsafeData = strtr($data, '-_', '+/');
 
        $paddedData = str_pad($urlUnsafeData, strlen($data) % 4, '=', STR_PAD_RIGHT);
 
        return base64_decode($paddedData);
    }
 
 }