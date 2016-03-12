<?php

namespace Buzz\Test\Client;
use Buzz\Message\Request;
use Buzz\Client\Cid;
use Buzz\Browser;

class CidTest extends \PHPUnit_Framework_TestCase
{
    public function testAddCidByLib()
    {
        $request = new Request();
        // Add Cid to headers if not present
        Cid::processRequest($request);
        $cid = $request->getHeader('Cid');
        // Assert that the header was actually added
        $this->assertNotNull($cid);
    }

    public function testAddExplicitCid()
    {
        $request = new Request();
        $headers = array(
            'Cid' => '123'
        );
        $request->setHeaders($headers);
        Cid::processRequest($request);
        $cid = $request->getHeader('Cid');
        $this->assertEquals($cid, "123");
    }

    public function testGetRequestWithoutCid()
    {
        $browser = new Browser();
        $response = $browser->get('http://127.0.0.1:8080/server.php');
        $this->assertEquals($response->getStatusCode(), 200);
    }

    public function testGetRequestWithCid()
    {
        $browser = new Browser();
        $headers = array(
            'Cid' => '123'
        );
        $response = $browser->get('http://127.0.0.1:8080/server.php', $headers);
        $this->assertEquals($response->getStatusCode(), 200);
    }
}
