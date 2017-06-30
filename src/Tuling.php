<?php


namespace Forgottener\Tuling;


use GuzzleHttp\Client;

class Tuling
{

    private $key;

    private $client;

    private $text;

    private $location;

    private $userId = 1;

    public function __construct($key)
    {
        $this->key = $key;
        $this->client = new Client();
    }

    /**
     * 设置文字
     *
     * @param $text
     * @return $this
     */
    public function text($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * 设置坐标
     *
     * @param array $location
     * @return $this
     */
    public function location(array $location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * 设置用户ID
     *
     * @param $userId
     * @return $this
     */
    public function user($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    private function makeRequest()
    {
        return [
            'key' => $this->key,
            'info' => $this->text,
            'userid' => $this->userId,
            'loc' => $this->location
        ];
    }

    public function request($raw = false)
    {
        $params = $this->makeRequest();

        $response = $this->client->post('http://www.tuling123.com/openapi/api', [
            'json' => $params
        ]);

        $result = json_decode(strval($response->getBody()), true);

        return $raw ? $result : $result['text'];
    }
}