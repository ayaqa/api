<?php

namespace AyaQA\Data\Dtos\Core;

class Session
{
    private readonly VerifiedPassword $core;
    private readonly VerifiedPassword $session;

    public static function init(): self
    {
        $self = new self();

        $self->core = new VerifiedPassword();
        $self->session = new VerifiedPassword();

        return $self;
    }

    public function getCorePasswordVerification(): VerifiedPassword
    {
        return $this->core;
    }

    public function getSessionPasswordVerification(): VerifiedPassword
    {
        return $this->session;
    }
}
