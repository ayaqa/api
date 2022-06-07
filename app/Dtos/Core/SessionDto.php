<?php

namespace AyaQA\Dtos\Core;

class SessionDto
{
    private bool $verifiedPassword = false;

    /**
     * @return bool
     */
    public function isVerifiedPassword(): bool
    {
        return $this->verifiedPassword;
    }

    /**
     * @param bool $verifiedPassword
     */
    public function setVerifiedPassword(bool $verifiedPassword): void
    {
        $this->verifiedPassword = $verifiedPassword;
    }
}
