# PHP-JWT
A little PHP util to generate and validate JSON Web Tokens (JWTs)


### Generate token
```php
require 'jwt.php';
  
$payload = array(
  'id' => '1001',
  'email' => 'chahat@hexoncode.com');
        
$expiry = time() + (3 * 3600);
$secret = 'somesecretkey';
        
$token = generate_token($payload, $expiry, $secret);
echo $token;
```

### Validate token
```php
$result = validate_token($token, $secret);
echo $result;
```

### Response codes
| Response          | Reason                                    |
| :---------------- |:----------------------------------------- |
| ERR_TOKEN_EXPIRED | Token has expired                         |
| ERR_TOKEN_INVALID | Token is invalid (signature didn't match) |
| TOKEN_VALID       | Token is valid and active                 |
