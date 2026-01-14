<?php
declare(strict_types=1);

namespace Controller;

use Requests\Requests;

class TopController
{
    public function __construct(private Requests $request)
    {
    }

    public function showTop(): void
    {
        include __DIR__ . '/../../public/resources/views/top.php';
    }
}