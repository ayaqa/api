<?php

namespace AyaQA\Data;

use AyaQA\Data\Dtos\Core\Session;

class AppContext
{
    private Session $sessionDto;

    public static function build()
    {
        $self = new self();

        $self->sessionDto = Session::init();

        return $self;
    }

    /**
     * @return Session
     */
    public function getSession(): Session
    {
        return $this->sessionDto;
    }
}
