<?php

namespace App\Tests\Statistics;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\TestCase;

class StatisticsTest extends TestCase
{
    private string $APP_URL = "http://nginxcontainer/condor";

    public function testGetStatistics()
    {
        // User login
        $token = $this->loginUser();

        // Arrange
        $client = new Client();
        $response = $client->request('GET', $this->APP_URL . "/v1/fetch", [
            'headers' => [
                'Authorization' => "Bearer $token"
            ]
        ]);

        // Act
        $statusCode = $response->getStatusCode();
        $responseBody = (string) $response->getBody();
        $decodedResponseBody = json_decode($responseBody, true);

        // Assert
        $this->assertEquals(200, $statusCode);

        $this->assertJson($responseBody);
        $this->assertTrue(is_array($decodedResponseBody));
        $this->assertArrayHasKey('data', $decodedResponseBody);
        $this->assertArrayHasKey('type', $decodedResponseBody);
        $this->assertArrayHasKey('message', $decodedResponseBody);
        $this->assertTrue(is_array($decodedResponseBody['data']));
        $this->assertTrue(is_string($decodedResponseBody['type']));
        $this->assertTrue(is_string($decodedResponseBody['message']));
        $this->assertEquals('Statistics returned successfully.', $decodedResponseBody['message']);
    }

    public function testGetStatisticsForPeriod()
    {
        // User login
        $token = $this->loginUser();

        // Arrange
        $client = new Client();
        $response = $client->request(
            'GET',
            $this->APP_URL . "/v1/fetch?type=period&startDate=2022-05-05&endDate=2022-06-06",
            [
                'headers' => [
                    'Authorization' => "Bearer $token"
                ]
            ]
        );

        // Act
        $statusCode = $response->getStatusCode();
        $responseBody = (string) $response->getBody();
        $decodedResponseBody = json_decode($responseBody, true);

        // Assert
        $this->assertEquals(200, $statusCode);

        $this->assertJson($responseBody);
        $this->assertTrue(is_array($decodedResponseBody));
        $this->assertArrayHasKey('data', $decodedResponseBody);
        $this->assertArrayHasKey('type', $decodedResponseBody);
        $this->assertArrayHasKey('message', $decodedResponseBody);
        $this->assertTrue(is_array($decodedResponseBody['data']));
        $this->assertTrue(is_string($decodedResponseBody['type']));
        $this->assertTrue(is_string($decodedResponseBody['message']));
        $this->assertEquals('Statistics returned successfully.', $decodedResponseBody['message']);
    }

    public function testGetStatisticsForPeriodStartOrEndDateNotProvided()
    {
        try {
            // User login
            $token = $this->loginUser();

            // Arrange
            $client = new Client();
            $response = $client->request('GET', $this->APP_URL . "/v1/fetch?type=period", [
                'headers' => [
                    'Authorization' => "Bearer $token"
                ]
            ]);
        } catch (ClientException $e) {
            // Act
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $responseBody = (string) $response->getBody();
            $decodedResponseBody = json_decode($responseBody, true);

            // Assert
            $this->assertEquals(422, $statusCode);

            $this->assertJson($responseBody);
            $this->assertTrue(is_array($decodedResponseBody));
            $this->assertArrayHasKey('error', $decodedResponseBody);
            $this->assertArrayHasKey('message', $decodedResponseBody);
            $this->assertTrue(is_bool($decodedResponseBody['error']));
            $this->assertTrue(is_string($decodedResponseBody['message']));
            $this->assertEquals(
                'Please provide start date and end date query parameters.',
                $decodedResponseBody['message']
            );
        }
    }

    public function testGetStatisticsNotLoggedIn()
    {
        try {
            // Arrange
            $client = new Client();
            $response = $client->request('GET', $this->APP_URL . "/v1/fetch");
        } catch (ClientException $e) {
            // Act
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $responseBody = (string) $response->getBody();
            $decodedResponseBody = json_decode($responseBody, true);

            // Assert
            $this->assertEquals(401, $statusCode);

            $this->assertJson($responseBody);
            $this->assertTrue(is_array($decodedResponseBody));
            $this->assertArrayHasKey('error', $decodedResponseBody);
            $this->assertArrayHasKey('message', $decodedResponseBody);
            $this->assertTrue(is_bool($decodedResponseBody['error']));
            $this->assertTrue(is_string($decodedResponseBody['message']));
            $this->assertEquals(
                'You need to login for this action.',
                $decodedResponseBody['message']
            );
        }
    }

    private function loginUser(): string
    {
        // Arrange
        $client = new Client();

        $response = $client->request('POST', $this->APP_URL . "/v1/login", [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'json' => [
                'username' => 'gagiiiii'
            ]
        ]);

        $responseBody = (string) $response->getBody();
        $decodedResponseBody = json_decode($responseBody);

        return $decodedResponseBody->token;
    }
}
