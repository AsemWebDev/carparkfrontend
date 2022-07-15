<?php

namespace App\Service;

use DateTime;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AvailabilityService
{
    const MAX_SPACES = 10;

    private HttpClientInterface $client;
    private string $apiUrl;

    public function __construct(HttpClientInterface $client, ParameterBagInterface $parameterBag)
    {
        $this->client = $client;
        $this->apiUrl = $parameterBag->get('api_url');
    }

    public function getAvailability(DateTime $fromDate, DateTime $toDate): array
    {
        $response = $this->client->request(
            'GET',
            $this->apiUrl . '/get-availability',
            [
                'query' => [
                    'from' => $fromDate->format('Y-m-d'),
                    'to' => $toDate->format('Y-m-d'),
                ],
            ]
        );

        $responseContent = json_decode($response->getContent(), true);
        return $this->formatResponse($responseContent['availableSpaces']);
    }

    public function formatResponse(array $data): array
    {
        foreach ($data as $key => $item) {
            if ($item == 0) {
                $pre = 'no';
            } elseif ($item == self::MAX_SPACES) {
                $pre = 'all';
            } else {
                $pre = $item;
            }

            $data[$key] = $pre . ' free space' . ($item > 1 ? 's' : '');
        }

        return $data;
    }
}