<?php
declare(strict_types=1);

namespace Core;

class Session
{
    private bool $started = false;

    public function start()
    {
        if ($this->started) {
            return;
        }

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $this->started = true;
    }

    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key): mixed
    {
        return $_SESSION[$key];
    }

    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function getOnce(string $key): mixed
    {
        $value = $_SESSION[$key];
        unset($_SESSION[$key]);

        return $value;
    }

    public function clear()
    {
        $_SESSION = [];
    }
}