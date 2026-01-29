<?php
declare(strict_types=1);

namespace Core;

class Request
{
    private array $get;

    private array $post;
    
    /**
     * サーバー情報および実行時の環境情報
     */
    private array $server;

    public function __construct(
        ?array $get = null,
        ?array $post = null,
        ?array $server = null
    ) {
        $this->get = $get ?? [];
        $this->post = $post ?? [];
        $this->server = $server ?? [];
    }

    /**
     * keyに該当する値を文字列で取得する(GET, POST)</br>
     * keyが該当しない場合、空文字を返す
     */
    public function fetchInputStr(string $key): string
    {
        if (isset($this->post[$key])) {
            return $this->post[$key];
        }

        if (isset($this->get[$key])) {
            return $this->get[$key];
        }

        return '';
    }
}
