<?php

namespace AyaQA\Core\Service;

use AyaQA\Core\Http\Request\AppSettingsRequest;
use AyaQA\Core\Settings\AppSettings;

class AppSettingsService
{
    private AppSettings $appSettings;

    public function __construct(AppSettings $appSettings)
    {
        $this->appSettings = $appSettings;
    }

    /**
     * If new testing sessions can be created
     *
     * @return bool
     */
    public function canCreateSession(): bool
    {
        return $this->appSettings->create_session;
    }

    /**
     * If list session endpoint will return all sessions without requiring password for it
     *
     * @return bool
     */
    public function canListCreatedSessions(): bool
    {
        return $this->appSettings->list_sessions;
    }

    /**
     * If for update settings will require password
     *
     * @return bool
     */
    public function areSettingsProtected(): bool
    {
        return $this->appSettings->is_protected;
    }

    /**
     * Total testing sessions limit.
     *
     * @return int
     */
    public function getSessionsLimit(): int
    {
        return $this->appSettings->session_limit;
    }

    /**
     * @param string $newPassword
     *
     * @return bool
     */
    public function updatePassword(string $newPassword): bool
    {
        $this->appSettings->password = $newPassword;

        $this->appSettings->save();

        return true;
    }

    /**
     * @param string $password
     *
     * @return bool
     */
    public function isPasswordEqualTo(string $password): bool
    {
        return $this->appSettings->password === $password;
    }

    /**
     * @param AppSettingsRequest $settingsRequest
     *
     * @return bool
     */
    public function updateFromRequest(AppSettingsRequest $settingsRequest): bool
    {
        $this->appSettings->create_session = $settingsRequest->get('can_create_session', $this->canCreateSession());
        $this->appSettings->list_sessions = $settingsRequest->get('can_list_sessions', $this->canListCreatedSessions());
        $this->appSettings->is_protected = $settingsRequest->get('is_protected', $this->areSettingsProtected());
        $this->appSettings->session_limit = $settingsRequest->get('session_limit', $this->getSessionsLimit());

        $this->appSettings = $this->appSettings->save();

        // update password only if new one is provided.
        if ($settingsRequest->has('new_password')) {
            $this->updatePassword($settingsRequest->get('new_password'));
        }

        return true;
    }

    public function toArray(): array
    {
        return $this->appSettings->asArray();
    }
}
