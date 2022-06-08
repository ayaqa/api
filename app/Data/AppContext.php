<?php

namespace AyaQA\Data;

use AyaQA\Data\Dtos\SessionDTO;

class AppContext
{
    private SessionDto $sessionDto;

    public static function build()
    {
        $self = new self();

        $self->sessionDto = SessionDTO::build();

        return $self;
    }

    /**
     * @return SessionDTO
     */
    public function getSession(): SessionDTO
    {
        return $this->sessionDto;
    }
}
