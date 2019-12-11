<?php
namespace App\Traits;

trait RandomStringable
{
    private $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    private $strLength = 10;

    /**
     * randomString https://stackoverflow.com/questions/4356289/php-random-string-generator/31107425#31107425
     * @return string random string
     */
	public function randomString()
	{
    	$pieces = [];
    	$max = mb_strlen($this->keyspace, '8bit') - 1;
    	for ($i = 0; $i < $this->strLength; ++$i) {
        	$pieces []= $this->keyspace[random_int(0, $max)];
    	}
    	return implode('', $pieces);
	}
}
