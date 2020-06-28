<?php

    define('TOKEN_EXPIRED', 'ERR_TOKEN_EXPIRED');
    define('TOKEN_INVALID', 'ERR_TOKEN_INVALID');
    define('TOKEN_VALID', 'TOKEN_VALID');
    
    function generate_token($payload, $expiry, $secret) {
        
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload['exp'] = $expiry;
        $payload = json_encode($payload);
        
        $base64_header = rtrim(base64_encode($header), '=');
        $base64_payload = rtrim(base64_encode($payload), '=');
        $signature = hash_hmac('sha256', $base64_header . "." . $base64_payload, $secret, true);
        $base64_signature = rtrim(base64_encode($signature), '=');
        
        $jwt = $base64_header . "." . $base64_payload . "." . $base64_signature;
        return $jwt;
    }
    
    function validate_token($token, $secret) {
        
        $data = explode('.', $token);
        $base64_header = $data[0];
        $base64_payload = $data[1];
        $base64_signature = $data[2];
        
        $header = base64_decode($base64_header);
        $payload = base64_decode($base64_payload);
        
        $payload_array = json_decode($payload, true);
        $token_expiry = $payload_array['exp'];
        if(time() > $token_expiry) {
            return TOKEN_EXPIRED;
        }
        
        $signature = base64_decode($base64_signature);
        $expected_signature = hash_hmac('sha256', $base64_header . "." . $base64_payload, $secret, true);
        
        $is_valid = hash_equals($expected_signature, $signature);
        if ($is_valid) {
            return TOKEN_VALID;
        } else {
            return TOKEN_INVALID;
        }
    }
    
    function validate_token_with_payload($token, $secret) {
        
        $data = explode('.', $token);
        $base64_header = $data[0];
        $base64_payload = $data[1];
        $base64_signature = $data[2];
        
        $header = base64_decode($base64_header);
        $payload = base64_decode($base64_payload);
        
        $payload_array = json_decode($payload, true);
        $token_expiry = $payload_array['exp'];
        if(time() > $token_expiry) {
            return TOKEN_EXPIRED;
        }
        
        $signature = base64_decode($base64_signature);
        $expected_signature = hash_hmac('sha256', $base64_header . "." . $base64_payload, $secret, true);
        
        $is_valid = hash_equals($expected_signature, $signature);
        if ($is_valid) {
            return $payload_array;
        } else {
            return TOKEN_INVALID;
        }
    }
