/*composer require firebase/php-jwt */

<?php
require_once 'vendor/autoload.php';
use Firebase\JWT\JWT;

// Secret key for signing the tokens
$key = "your_secret_key";

// Function to create a JWT token
function createJWT($user) {
    global $key;

    $payload = [
        'iss' => "http://yourdomain.com",  // Issuer
        'aud' => "http://yourdomain.com",  // Audience
        'iat' => time(),                   // Issued at
        'exp' => time() + 3600,            // Expiration time
        'userData' => $user                // User data
    ];

    $jwt = JWT::encode($payload, $key);
    return $jwt;
}

// Function to validate the JWT token and return user data
function validateJWT($jwt) {
    global $key;
    try {
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        return $decoded;
    } catch (Exception $e) {
        // Error in token validation
        return null;
    }
}

// Example usage
$userData = ['userId' => 1, 'email' => 'user@example.com'];
$jwt = createJWT($userData);

echo "JWT: " . $jwt . "\n";

// Verifying the token
$decodedData = validateJWT($jwt);
if ($decodedData) {
    echo "Valid token: ";
    print_r($decodedData);
} else {
    echo "Invalid token";
}
?>
