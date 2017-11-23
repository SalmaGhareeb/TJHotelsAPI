<?php

namespace Tests\AppBundle\Controller\API;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class HotelControllerTest extends WebTestCase
{


    public function testSearchResponse()
    {
        $client = static::createClient();
        $client->request('GET', '/api/hotels');

        $response = $client->getResponse();
        $this->assertJsonResponse($response);
        $this->assertHTTPOKStatusCode($response);
    }

    /**
     * @param Response $response
     */
    public function assertHTTPOKStatusCode(Response $response)
    {
        $this->assertEquals(
            200,
            $response->getStatusCode(),
            $response->getContent()
        );
    }

    /**
     * @param Response $response
     * @param int $statusCode
     */
    protected function assertJsonResponse(Response $response, $statusCode = 200)
    {
        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );
    }

}