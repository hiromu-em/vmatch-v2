<?php
declare(strict_types=1);

namespace Core;

class ViewRenderer
{
    private const string BASEPATH = __DIR__ . '/../public/resources/';

    public function __construct(private string $directoryPath = "views/")
    {
    }

    public function render(string $fileName, array $parameters = []): never
    {
        $path = self::BASEPATH . $this->directoryPath . $fileName . '.php';
        extract($parameters, EXTR_SKIP);

        require $path;
        exit;
    }
}