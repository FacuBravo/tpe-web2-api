<?php

require_once "config.php";

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), "+/", "-_"), "=");
}

class AuthHelper {
    public function getAuthHeaders() {
        $header = "";
        
        if (isset($_SERVER["HTTP_AUTHORIZATION"])) {
            $header = $_SERVER["HTTP_AUTHORIZATION"];
        }

        if (isset($_SERVER["REDIRECT_HTTP_AUTHORIZATION"])) {
            $header = $_SERVER["REDIRECT_HTTP_AUTHORIZATION"];
        }

        return $header;
    }

    public function createToken($payload) {
        $header = [
            "alg" => "HS256",
            "typ" => "JWT"
        ];

        $header = base64url_encode(json_encode($header));
        $payload = base64url_encode(json_encode($payload));

        $signature = hash_hmac("SHA256", "$header.$payload", JWT_KEY, true);
        $signature = base64url_encode($signature);

        $token = "$header.$payload.$signature";
        return $token;
    }

    public function verify($token) {
        $token = explode(".", $token);

        if (empty($token[0]) || empty($token[1]) || empty($token[2])) {
            return false;
        }

        $header = $token[0];
        $payload = $token[1];
        $signature = $token[2];

        $new_signature = hash_hmac("SHA256", "$header.$payload", JWT_KEY, true);
        $new_signature = base64url_encode($new_signature);

        if ($new_signature != $signature) {
            return false;
        }

        $payload = json_decode(base64_decode($payload));
        
        return $payload;
    }

    public function currentUser() {
        $auth = $this->getAuthHeaders();
        $auth = explode(" ", $auth);

        if ($auth[0] != "Bearer") {
            return false;
        }

        if (empty($auth[1])) {
            return false;
        }

        return $this->verify($auth[1]);
    }
}