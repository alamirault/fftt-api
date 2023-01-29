<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Service;

use Alamirault\FFTTApi\Exception\InternalServerErrorException;
use Alamirault\FFTTApi\Exception\InvalidRequestException;
use Alamirault\FFTTApi\Exception\InvalidResponseException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Psr\Http\Message\ResponseInterface;

final class FFTTClient implements FFTTClientInterface
{
    /**
     * @readonly
     * @var \GuzzleHttp\Client
     */
    private $client;
    /**
     * @readonly
     * @var \Alamirault\FFTTApi\Service\UriGenerator
     */
    private $uriGenerator;
    public function __construct(Client $client, UriGenerator $uriGenerator)
    {
        $this->client = $client;
        $this->uriGenerator = $uriGenerator;
    }
    /**
     * @param string $path
     * @param mixed[] $params
     * @param string|null $queryParameter
     */
    public function get($path, $params = [], $queryParameter = null): array
    {
        $uri = $this->uriGenerator->generate($path, $params, $queryParameter);
        try {
            $result = $this->send($uri);
        } catch (ClientException $ce) {
            /** @var ResponseInterface $response */
            $response = $ce->getResponse();
            throw new InvalidRequestException($uri, $response->getStatusCode(), $response->getBody()->getContents());
        } catch (ServerException $se) {
            $response = $se->getResponse();
            throw new InternalServerErrorException($uri, ($response2 = $response) ? $response2->getStatusCode() : null, ($getBody = ($response2 = $response) ? $response2->getBody() : null) ? $getBody->getContents() : null);
        }

        if (array_key_exists('0', $result)) {
            throw new InvalidResponseException($uri, $result);
        }

        return $result;
    }

    /**
     * @return array<mixed>
     */
    private function send(string $uri): array
    {
        $response = $this->client->request('GET', $uri);

        if (200 !== $response->getStatusCode()) {
            throw new \DomainException(sprintf('Request "%s" returns an error', $uri));
        }

        $content = $response->getBody()->getContents();

        // Lot of hacks due to ugly/buggy FFTT Api response format
        /** @var string $content */
        $content = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $content);
        $content = html_entity_decode($content);

        // Some requests have a different header than others, whose data must be correctly encoded
        if ($response->hasHeader('content-type') && 'text/html; charset=UTF-8' === $response->getHeader('content-type')[0]) {
            $content = mb_convert_encoding($content, 'ISO-8859-1', 'UTF-8');
        }

        $xml = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA);

        /** @var string $encoded */
        $encoded = json_encode($xml);

        /** @var array<mixed> $decoded */
        $decoded = json_decode($encoded, true);

        return $decoded;
    }
}
