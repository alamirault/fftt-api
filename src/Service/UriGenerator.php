<?php declare(strict_types=1);

namespace Alamirault\FFTTApi\Service;

final class UriGenerator implements UriGeneratorInterface
{
    private const FFTT_URL = 'http://www.fftt.com/mobile/pxml/';
    /**
     * @readonly
     * @var string
     */
    private $id;
    /**
     * @readonly
     * @var string
     */
    private $password;
    public function __construct(string $id, string $password)
    {
        $this->id = $id;
        $this->password = $password;
    }

    /**
     * @param string $path
     * @param mixed[] $parameters
     * @param string|null $queryParameter
     */
    public function generate($path, $parameters = [], $queryParameter = null): string
    {
        $time = round(microtime(true) * 1000);
        $hashedKey = hash_hmac('sha1', (string) $time, md5($this->password));

        $uri = self::FFTT_URL.$path.'.php?serie='.$this->id.'&tm='.$time.'&tmc='.$hashedKey.'&id='.$this->id;

        if ($queryParameter) {
            $uri .= '&'.$queryParameter;
        }

        foreach ($parameters as $key => $value) {
            $uri .= '&'.$key.'='.$value;
        }

        return $uri;
    }
}
