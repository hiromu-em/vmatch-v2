<?php
declare(strict_types=1);

namespace Core;

class ViewRenderer
{
    private const string BASEPATH = __DIR__ . '/../public/resources/';

    public function __construct(private string $directoryPath = "")
    {
    }

    public function render(string $fileName, array $parameters = [])
    {
        $path = self::BASEPATH . $this->directoryPath . $fileName . '.php';

        require $path;
    }
}