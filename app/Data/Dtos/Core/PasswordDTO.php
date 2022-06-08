<?php

namespace AyaQA\Data\Dtos\Core;

class PasswordDTO
{
    private bool $isVerified = false;

    /**
     * @return bool
     */
    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    /**
     * @param bool $verified
     *
     * @return PasswordDTO
     */
    public function setVerified(bool $verified): self
    {
        $this->isVerified = $verified;

        return $this;
    }
}
