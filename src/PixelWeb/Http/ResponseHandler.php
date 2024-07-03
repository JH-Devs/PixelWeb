<?php

declare(strict_types=1);

namespace PixelWeb\Http;

use Symfony\Component\HttpFoundation\Response;

class ResponseHandler
{

    /**
     * Obalová metoda pro objekt HTTP odpovědi v Symfony
     *
     * @return Response
     */
    public function handler() : Response
    {
        if (!isset($response)) {
            $response = new Response();
            if ($response) {
                return $response;
            }
        }
        return false;
    }

}