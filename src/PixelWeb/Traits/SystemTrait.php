<?php

declare(strict_types=1);

namespace PixelWeb\Traits;

use PixelWeb\Base\Exception\BaseLogicException;
use PixelWeb\GlobalManager\GlobalManager;
use PixelWeb\Session\SessionManager;
use PixelWeb\Session\SessionInterface; // Import SessionInterface

trait SystemTrait
{
    public static function sessionInit(bool $useSessionGlobal = false): ?SessionInterface
    {
        try {
            $session = SessionManager::initialize(); // Vytvoření instance session
            if ($session !== null) {
                if ($useSessionGlobal) {
                    GlobalManager::set('global_session', $session);
                }
                return $session;
            } else {
                throw new BaseLogicException('Relace není správně inicializována. Zkontrolujte konfiguraci.');
            }
        } catch (\Throwable $e) {
            throw new BaseLogicException('Chyba při inicializaci relace: ' . $e->getMessage());
        }
    }
}
