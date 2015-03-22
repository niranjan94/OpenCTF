<?php
require_once("MCrypt.php");
class Security {
	public static function encrypt($input, $key) {
		$size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
		$input = Security::pkcs5_pad($input, $size);
		$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
		$iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
		mcrypt_generic_init($td, $key, $iv);
		$data = mcrypt_generic($td, $input);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		$data = base64_encode($data);
		return $data;
	}

	private static function pkcs5_pad ($text, $blocksize) { 
		$pad = $blocksize - (strlen($text) % $blocksize); 
		return $text . str_repeat(chr($pad), $pad); 
	} 

	public static function decrypt($sStr, $sKey) {
		$decrypted= mcrypt_decrypt(
			MCRYPT_RIJNDAEL_128,
			$sKey, 
			base64_decode($sStr), 
			MCRYPT_MODE_ECB
		);
		$dec_s = strlen($decrypted); 
		$padding = ord($decrypted[$dec_s-1]); 
		$decrypted = substr($decrypted, 0, -$padding);
		return $decrypted;
	}

	public static function encryptURL($input, $key) {
		return urlencode(base64_encode(Security::encrypt($input,$key)));
	}
	public static function decryptURL($input, $key) {
		return Security::decrypt(base64_decode(urldecode($input)),$key);
	}

    public static function crypto_rand_secure($min, $max) {
        $range = $max - $min;
        if ($range < 0) return $min; // not so random...
        $log = log($range, 2);
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }

    public static function getSalt($length=32){
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        for($i=0;$i<$length;$i++){
            $token .= $codeAlphabet[Security::crypto_rand_secure(0,strlen($codeAlphabet))];
        }
        return $token;
    }
	public static function encryptQueryParam($param){
		$keySalt = SECRET_ENCRYPTION_KEY;
		return base64_encode(urlencode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($keySalt), $param, MCRYPT_MODE_CBC, md5(md5($keySalt)))));
	}
	public static function decryptQueryParam($param){
		$keySalt = SECRET_ENCRYPTION_KEY;
		return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($keySalt), urldecode(base64_decode($param)), MCRYPT_MODE_CBC, md5(md5($keySalt))), "\0");
	}
}
?>