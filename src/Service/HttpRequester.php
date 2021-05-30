<?php declare(strict_types=1);

namespace App\Service;

class HttpRequester
{
    /**
     * @var string
     */
    private $response;

    public function sendRequest(string $url): HttpRequester
    {
        $headers = [
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($result === false) {
            throw new Exception($error ?? 'Unknown error');
        }

        $this->response = $result;

        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }
}
