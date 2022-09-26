<?php

namespace AyaQA\Support\BugFramework\Manifest\Dto;

class KeyLabelDTO implements \JsonSerializable
{
    public function __construct(
        private string $key,
        private string $label,
    ){}

    public static function from(string $key, string $label)
    {
        return new self($key, $label);
    }

    public function toArray(): array
    {
        return [
            'id'    => $this->key,
            'text'  => $this->label,
        ];
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
