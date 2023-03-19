<?php

namespace App;

use App\Entity\Crawler\Publisher;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ApiClient
{
    private array $options;

    public function __construct(private readonly HttpClientInterface $httpClient, array $options)
    {
        $this->options = $this->resolveOptions($options);
    }

    public function readPublisher(Uuid $id)
    {
        return $this->get('publishers/' . $id)->toArray();
    }

    public function createPublisher(Publisher $publisher)
    {
        return $this->post('publishers/', [
            'json' => $publisher,
        ]);
    }

    public function updatePublisher(Publisher $publisher)
    {
        return $this->patch('publishers/' . $publisher->getId(), [
            'json' => $publisher,
        ]);
    }

    public function deletePublisher(Publisher $publisher)
    {
        return $this->delete('publishers/' . $publisher->getId());
    }

    public function getPublishers(array $query = []): array
    {
        return $this->get('publishers', ['query' => $query])->toArray();
    }

    private function get(string $path, array $query): ResponseInterface
    {
        return $this->httpClient->request('GET', $path, [
            'base_uri' => $this->options['api_baseurl'],
        ]);
    }

    private function post(string $url, array $options): ResponseInterface
    {
        return $this->request('POST', $url, $options);
    }

    private function patch(string $url, array $options): ResponseInterface
    {
        return $this->request('PATCH', $url, $options);
    }

    private function delete(string $url, array $options = []): ResponseInterface
    {
        return $this->request('DELETE', $url, $options);
    }

    private function request(string $method, string $url, array $options): ResponseInterface
    {
        return $this->httpClient->request(
            $method,
            $url,
            [
                'base_uri' => $this->options['api_baseurl'],
                'headers' => [
                    'Accept: */*',
                    'Authorization: Bearer ' . $this->options['api_bearer_token'],
                ],
            ] + $options
        );
    }

    private function resolveOptions(array $options): array
    {
        return (new OptionsResolver())
            ->setRequired('api_baseurl')
            ->setAllowedTypes('api_baseurl', 'string')
            ->setRequired('api_bearer_token')
            ->setAllowedTypes('api_bearer_token', 'string')
            ->resolve($options);
    }
}
