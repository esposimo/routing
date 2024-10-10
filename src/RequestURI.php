<?php

namespace smn\routing;

class RequestURI
{


    /**
     * Contiene il contesto
     * @var string
     */
    protected string $context;

    public function __construct(string $context = '/')
    {
        $this->context = $context;
    }


    /**
     * Restituisce il contesto
     * @return string
     */
    public function getContext(): string
    {
        return $this->context;
    }

}