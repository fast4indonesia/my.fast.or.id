<?php // vim:ts=4:sts=4:sw=4:et:

namespace PHPEncryptData;

class SimpleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Simple
     */
    private $_instance;
    private $_encryptionKey = 'nXA5gXtlOgHgxl6EZTfkfDmIzWaRqxZ1rq7DRNCIQ/Q=';
    private $_macKey = 'K9iPmOMowXUvcQTd7ehfcxvvHd4OtzyztQp+wuQwb6U=';

    public function setUp() {
        $this->_instance = new Simple($this->_encryptionKey, $this->_macKey);
    }

    public function testEncryptWithKnownIV() {
        $ciphertext = $this->_instance->encrypt('FooBar ', 'LQX9lyuvAf8N2yB0Xnv9O12Cv+d7MVpq');

        $this->assertSame(
            'MHxMUVg5bHl1dkFmOE4yeUIwWG52OU8xMkN2K2Q3TVZwcWw5MDVDS3YyZHc9PXw4MzcwZmc3dzkvUTA2WTY3bkJQQ09RPT0=',
            $ciphertext
        );
    }

    public function testDecryptKnownCiphertext() {
        $plaintext = $this->_instance->decrypt(
            'MHxMUVg5bHl1dkFmOE4yeUIwWG52OU8xMkN2K2Q3TVZwcWw5MDVDS3YyZHc9PXw4MzcwZmc3dzkvUTA2WTY3bkJQQ09RPT0='
        );

        $this->assertSame('FooBar ', $plaintext);
    }

    /**
     * @expectedException \RunTimeException
     * @expectedExceptionMessage Unknown construction
     */
    public function testUnknownConstructionThrowsException() {
        $this->_instance->decrypt(
            'cmpkLTI1Ni1obWFjLXNoYTI1Ni8xMjh8bEF1Q1U3ZnQ1dG5IUEtXUmpGMUlLVjRKNlY5L2VDR1FJaXNIWmZ1cU10YS8zZ0pnN0loSGd4dmFVWTZpc1J5UGNScSt4L3JRZm5QeFkvQTFYcVkybkE9PXw2TUJCQ0tCYlljK2FXTHBuazFNUVZXMmpNNUpuejVvSGZYbkRyaXlJTDlRPQ=='
        );
    }

    public function invalidCiphertextPartsData()
    {
        return array(
            'Too few parts' => array('cGFydDF8cGFydDI='), // 'part1|part2'
            'Too many parts' => array('cGFydDF8cGFydDJ8cGFydDN8cGFydDQ='), // 'part1|part2|part3|part4'
        );
    }

    /**
     * @dataProvider invalidCiphertextPartsData
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Invalid encoding
     */
    public function testDecryptingCiphertextWithWrongNumberOfPartsThrowsException($ciphertext) {
        $this->_instance->decrypt($ciphertext);
    }

    /**
     * Encrypts the same string with randomized IVs and flips a single bit of
     * the ciphertext.
     */
    public function invalidCiphertextData() {
        $this->setUp();
        $invalidCiphertexts = array();

        for ($x = 0; $x < 100; $x++) {
            $signedCiphertext = $this->_instance->encrypt('Randomize this with new IVs');
            $signedCiphertext = base64_decode($signedCiphertext);
            list($construction, $encodedCiphertext, $encodedSignature) = explode('|', $signedCiphertext);
            $ciphertext = base64_decode($encodedCiphertext);
            $randomByte = rand(1, strlen($ciphertext));
            $mask = str_repeat("\x00", $randomByte -1) . "\x01" . str_repeat("\x00", strlen($ciphertext) - $randomByte);

            // SANITY CHECK: If this mask is removed, this test should fail every 
            // single run because the ciphertext should match.
            $invalidCiphertext = $ciphertext ^ $mask;

            // printf("Ciphertext:         %s\n", bin2hex($ciphertext));
            // printf("Mask:               %s\n", bin2hex($mask));
            // printf("Invalid Ciphertext: %s\n", bin2hex($invalidCiphertext));

            $encodedInvalidCiphertext = base64_encode($invalidCiphertext);
            $invalidCiphertexts[] = array(base64_encode($construction . '|' . $encodedInvalidCiphertext . '|' . $encodedSignature));
        }

        return $invalidCiphertexts;
    }

    /**
     * @dataProvider invalidCiphertextData
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Invalid signature
     */
    public function testDecryptingInvalidCiphertextThrowsException($signedCiphertext) {
        $this->_instance->decrypt($signedCiphertext);
    }

    public function testEncryptedDataCanBeDecrypted() {
        $plaintext = 'Something';
        $ciphertext = $this->_instance->encrypt('Something');

        $this->assertSame($plaintext, $this->_instance->decrypt($ciphertext));
    }

    public function invalidKeyData() {
        return array(
            array(null),
            array(''),
            array('Foo'),
            array('0123456789ABCDF0123456789ABCDF'),
            array('0123456789ABCDF0123456789ABCDF0123456789ABCDEF'),
            array('3e5VO09Oslbw/sskJPdloizTQ/2iz8Icyo+VT3PxYW='),
        );
    }

    /**
     * @dataProvider invalidKeyData
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Encryption key must be
     */
    public function testInvalidEncryptionKeyThrowsException($invalidKey) {
        new Simple($invalidKey, $this->_macKey);
    }

    /**
     * @dataProvider invalidKeyData
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage MAC key must be
     */
    public function testInvalidMacKeySizeThrowsException($invalidKey) {
        new Simple($this->_encryptionKey, $invalidKey);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage IV must be exactly
     */
    public function testEncryptWithInvalidIvLengthThrowsException() {
        $this->_instance->encrypt('FooBar ', 'wrong-iv-length');
    }

    public function testDifferentIvGeneratedOnEachRun() {
        $expected = 20;
        $ivs = array();
        for ($i = 1; $i <= $expected; $i++) {
            $ivs[] = $this->_instance->generateIv();
        }

        $duplicatesRemoved = array_values($ivs);

        $this->assertCount($expected, $duplicatesRemoved);
    }
}
