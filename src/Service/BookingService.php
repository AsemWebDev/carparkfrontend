<?php

namespace App\Service;

use DateTime;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BookingService
{
    private HttpClientInterface $client;
    private string $apiUrl;

    public function __construct(HttpClientInterface $client, ParameterBagInterface $parameterBag)
    {
        $this->client = $client;
        $this->apiUrl = $parameterBag->get('api_url');
    }

    public function Book(string $username, DateTime $fromDate, DateTime $toDate): string
    {
        $response = $this->client->request(
            'POST',
            $this->apiUrl . '/book',
            [
                'query' => [
                    'username' => $username,
                    'from' => $fromDate->format('Y-m-d'),
                    'to' => $toDate->format('Y-m-d'),
                ],
            ]
        );

        $responseContent = json_decode($response->getContent(), true);
        return $this->formatResponse($responseContent['availableSpaces']);
        //return 'Your parking space is booked successfully';
    }

}