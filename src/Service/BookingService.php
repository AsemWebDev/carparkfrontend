<?php

namespace App\Service;

use DateTime;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BookingService
{
    private HttpClientInterface $client;
    private string $apiUrl;
    private AvailabilityService $availabilityService;

    public function __construct(
        HttpClientInterface $client,
        ParameterBagInterface $parameterBag,
        AvailabilityService $availabilityService
    )
    {
        $this->client = $client;
        $this->apiUrl = $parameterBag->get('api_url');
        $this->availabilityService = $availabilityService;
    }

    public function Book(string $username, DateTime $fromDate, DateTime $toDate): array
    {
        $response = $this->client->request(
            'POST',
            $this->apiUrl . '/book',
            [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'query' => [
                    'username' => $username,
                    'from' => $fromDate->format('Y-m-d'),
                    'to' => $toDate->format('Y-m-d'),
                ],
            ]
        );

        $responseContent = json_decode($response->getContent(), true);

        if (array_key_exists('availability', $responseContent) && count($responseContent['availability'] ) > 0) {
            $responseContent['availability'] = $this->availabilityService->formatResponse(
                $responseContent['availability']
            );
        }

        return [
            'message' => $responseContent['message'],
            'availability' =>  $responseContent['availability'] ?? [],
        ];
    }
}
