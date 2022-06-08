<?php

namespace AyaQA\Data\Dtos;

use AyaQA\Data\Dtos\Core\PasswordDTO;

class SessionDTO
{
    private readonly PasswordDTO $corePassword;
    private readonly PasswordDTO $sessionPassword;

    public static function build(): self
    {
        $self = new self();

        $self->corePassword = new PasswordDTO();
        $self->sessionPassword = new PasswordDTO();

        return $self;
    }

    /**
     * @return PasswordDTO
     */
    public function getCorePassword(): PasswordDTO
    {
        return $this->corePassword;
    }

    /**
     * @return PasswordDTO
     */
    public function getSessionPassword(): PasswordDTO
    {
        return $this->sessionPassword;
    }
}
