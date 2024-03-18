<?php

declare(strict_types=1);

namespace App\Core\Http;

class Response
{
    private StatusCode $statusCode = StatusCode::OK;

    private array $headers;

    private mixed $body;

    public function html(string $html): self
    {
        $this->headers['Content-Type'] = 'text/html';
        $this->body = $html;

        return $this;
    }

    public function render(string $fileName, array $params = []): string
    {
        ob_start();
        extract($params, EXTR_OVERWRITE); // TODO: very dangerous

        include VIEW_PATH . $fileName;
        $content = ob_get_clean();
        $this->html($content);
        return $content;
    }

    public function setStatusCode(StatusCode $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    public function send(): string
    {
        http_response_code($this->statusCode->value);

        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }

        return $this->body;
    }

    public function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }
}
