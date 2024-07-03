<?php 

declare(strict_types=1);

namespace PixelWeb\Http;

use Symfony\Component\HttpFoundation\Request;

class RequestHandler 
{
    /**
     * Obalová metoda pro objekt HTTP požadavku v Symfony
     *
     * @return Request
     */
    public function handler() : Request
    {
        if (!isset($request)) {
            $request = new Request();

            if ($request) {
                $create= $request->createFromGlobals();
                if ($create) {
                    return $create;
                }
            }
        }
        return false;
    }
}