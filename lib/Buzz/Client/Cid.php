<?php

namespace Buzz\Client;

use Rhumsaa\Uuid\Uuid;
use Rhumsaa\Uuid\Exception\UnsatisfiedDependencyException;

class Cid
{
    /**
     * Adds Cid to a request object if it doesn't already exist
     *
     * @param Request $request
     */
    public static function processRequest($request)
    {
        if ($request instanceof \Symfony\Component\HttpFoundation\Request) {
            // For now, we are only using
            if (!$request->headers->has('Cid')) {
                $cid = Cid::generateCid();
                $request->headers->set('Cid', $cid);
            }
        }

        return $request;
    }

    public static function generateCid()
    {
        $cid = '';

        try {
            $cid = Uuid::uuid4()->toString(); // 25769c6c-d34d-4bfe-ba98-e0ee856f3e7a
        } catch (UnsatisfiedDependencyException $e) {
            // Some dependency was not met. Either the method cannot be called on a
            // 32-bit system, or it can, but it relies on Moontoast\Math to be present.
            // Ignoring the exception...
        }

        return $cid;
    }
}
