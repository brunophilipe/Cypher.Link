<?php

define("kBPEncryptionAlgorithm", MCRYPT_RIJNDAEL_256);
define("kBPEncryptionMode", MCRYPT_MODE_CBC);

class Encryption
{
	public static function decrypt($blob, $key, $iv)
	{
		return rtrim(mcrypt_decrypt(kBPEncryptionAlgorithm, $key, $blob, kBPEncryptionMode, $iv), "\0\3");
	}

	public static function encrypt($blob, $key, $iv)
	{
		return rtrim(mcrypt_encrypt(kBPEncryptionAlgorithm, $key, $blob, kBPEncryptionMode, $iv), "\0\3");
	}

	public static function generateKey()
	{
		$ks = mcrypt_get_key_size(kBPEncryptionAlgorithm, kBPEncryptionMode);
		return openssl_random_pseudo_bytes($ks);
	}

	public static function generateIV()
	{
		return mcrypt_create_iv(mcrypt_get_iv_size(kBPEncryptionAlgorithm, kBPEncryptionMode), MCRYPT_RAND);
	}

	public static function generateRandomString($length = 8) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
}