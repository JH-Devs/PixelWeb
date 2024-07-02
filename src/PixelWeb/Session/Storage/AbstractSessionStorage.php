<?php
declare(strict_types=1);

namespace PixelWeb\Session\Storage;

abstract class AbstractSessionStorage implements SessionStorageInterface
{
    protected array $options = [];

    /**
     * Moje abstraktní konstrukční třída
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        if ($options)
            $this->options = $options;
        $this->iniSet();
        // Zničí všechny existující relace zahájené pomocí session.auto_start
        if ($this->isSessionStarted()) {
            session_unset();
            session_destroy();
        }
        $this->start();
    }
    /**
     * Nastaví název relace
     *
     * @param string $sessionName
     * @return void
     */
    public function setSessionName(string $sessionName) : void
    {
        session_name($sessionName);
    }

    /**
     * Vrátí název aktuální relace
     *
     * @return string
     */
    public function getSessionName() : string
    {
        return session_name();
    }

    /**
     * Nastaví název ID relace
     *
     * @param [type] $sessionId
     * @return void
     */
    public function setSessionId($sessionId) : void
    {
        session_id($sessionId);
    }

    /**
     * Vrátí aktuální ID relace
     *
     * @return string
     */
    public function getSessionId()
    {
        return session_id();
    }
	
	public function iniSet()
    {
        ini_set('session.gc_maxlifetime', $this->options['gc_maxlifetime']);
        ini_set('session.gc_divisor', $this->options['gc_divisor']);
        ini_set('session.gc_probability', $this->options['gc_probability']);
        ini_set('session.lifetime', $this->options['lifetime']);
        ini_set('session.use_cookies', $this->options['use_cookies']);
    }
    /**
     * Zabraňuje relaci v CLI. I když nemůže spouštět relace v příkazovém řádku, kontroluje, zda má ID relace a zda není prázdné, jinak vrací false
     *
     * @return boolean
     */
    public function isSessionStarted()
    {
        return php_sapi_name() !== 'cli' ? $this->getSessionId() !=='' : false;
    }
    /**
     * Začněte naši relaci, pokud ještě nemáme php relaci
     *
     * @return void
     */
    public function startSession()
    {
        if (session_status() == PHP_SESSION_NONE)
            session_start();
    }
    /**
     * Definuje naši metodu session_set_cookie_params pomocí parametrů $this->options, které budou definovány v našem základním konfiguračním adresáři
     *
     * @return void
     */
    public function start() : void
    {
        $this->setSessionName($this->options['session_name']);
        $domain = (isset($this->options['domain']) ? $this->options['domain'] : isset($_SERVER['SERVER_NAME']));
        $secure = (isset($this->options['secure']) ? $this->options['secure'] : isset($_SERVER['HTTPS']));

        session_set_cookie_params($this->options['lifetime'], $this->options['path'], $domain, $secure, $this->options['httponly']);

        $this->startSession();
    }
}