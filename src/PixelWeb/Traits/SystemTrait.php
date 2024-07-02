<?php

declare(strict_types=1);

namespace PixelWeb\Traits;

use PixelWeb\Base\Exception\BaseLogicException;
use PixelWeb\GlobalManager\GlobalManager;
use PixelWeb\Session\SessionManager;

trait SystemTrait
{
    public static function sessionInit(bool $useSessionGlobal = false)
    {
        $session = SessionManager::initialize();
        if (!$session) {
            throw new BaseLogicException('Povolte prosím relaci ve své relaci. konfigurační soubor yaml.');
        } else if ($useSessionGlobal === true) {
            GlobalManager::set('global_session', $session);
        } else {
            return $session;
        }
        return false;
    }
}