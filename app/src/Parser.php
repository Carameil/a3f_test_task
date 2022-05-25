<?php

namespace App;

use DOMDocument;

class Parser
{
    private string $response;
    private string $error;
    private array  $elementDistribution = [];
    private object $dom;

    public function __construct(string $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        if (curl_exec($ch)) {
            $this->response = curl_exec($ch);
        } else {
            $this->error = curl_error($ch);
             die($this->error);
        }

        curl_close($ch);
    }

    public function loadDoc(): void
    {
        $this->dom = new DOMDocument;
        libxml_use_internal_errors(true);
        $this->dom->loadHTML($this->response);
        libxml_clear_errors();
    }

    public function calcTags(): array
    {
        $allElements = $this->dom->getElementsByTagName('*');
        foreach ($allElements as $element) {
            if (isset($this->elementDistribution[$element->tagName])) {
                $this->elementDistribution[$element->tagName] += 1;
            } else {
                $this->elementDistribution[$element->tagName] = 1;
            }
        }
        return $this->elementDistribution;
    }
}