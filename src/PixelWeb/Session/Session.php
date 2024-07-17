<?php

declare(strict_types=1);

namespace PixelWeb\Session;

use PixelWeb\Session\Exception\SessionException;
use PixelWeb\Session\Exception\SessionInvalidArgumentException;
use PixelWeb\Session\SessionInterface;
use PixelWeb\Session\Storage\SessionStorageInterface;
use Throwable;

class Session implements SessionInterface
{
    protected SessionStorageInterface $storage;
    protected string $sessionName;

    protected const SESSION_PATTERN = '/^[a-zA-Z0-9_\.]{1,64}$/';

    /**
     * Moje konstrukční třída
     *
     * @param SessionStorageInterface $storage
     * @param string $sessionName
     */
    public function __construct(SessionStorageInterface $storage, string $sessionName)
    {
        if ($this->isSessionKeyValid($sessionName) === false) {
            throw new SessionInvalidArgumentException($sessionName . ' neplatný název relace.');
        }
        $this->storage = $storage;
        $this->sessionName = $sessionName;
    }
    /**
     * @inheritdoc
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, $value) :void
    {
        $this->ensureSessionKeyIsValid($key);
        try {
            $this->storage->setSession($key, $value);
        } catch (Throwable $throwable) {
            throw new SessionException('Při načítání klíče z úložiště relace byla vyvolána výjimka.' . $throwable);
        }
    }
    /**
     * @inheritdoc
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function setArray(string $key, $value) :void
    {
        $this->ensureSessionKeyIsValid($key);
        try {
              $this->storage->setArraySession($key, $value);
        } catch (Throwable $throwable) {
            throw new SessionException('Při načítání klíče z úložiště relace byla vyvolána výjimka.' . $throwable);
        }
    }
    /**
     * @inheritdoc
     *
     * @param string $key
     * @param mixed $default
     * @return void
     */
    public function get(string $key, $default = null)
    {
        try {
            return $this->storage->getSession($key, $default);
        } catch (Throwable $throwable) {
            throw new SessionException();
        }
    }
    /**
     * @inheritdoc
     *
     * @param string $key
     * @return boolean
     */
    public function delete(string $key) : bool
    {
        $this->ensureSessionKeyIsValid($key);
        try {
            $this->storage->deleteSession($key);
        } catch (Throwable $throwable) {
            throw new SessionException();
        }
        return true;
    }
    /**
     * @inheritdoc
     *
     * @return void
     */
    public function invalidate(): void
    {
        $this->storage->invalidate();
    }
    /**
     * @inheritdoc
     *
     * @param string $key
     * @param [type] $value
     * @return void
     */
    public function flush(string $key, $value = null)
    {
        $this->ensureSessionKeyIsValid($key);
        try {
            $this->storage->flush($key, $value);
        } catch (Throwable $throwable) {
            throw new SessionException();
        }
    }
    /**
     * @inheritdoc
     *
     * @param string $key
     * @return boolean
     */
    public function has(string $key) : bool
    {
        $this->ensureSessionKeyIsValid($key);
        return $this->storage->hasSession($key);
    }
    /**
     * Zkontroluje, zda je náš klíč relace platný podle definovaného regulárního výrazu
     *
     * @param string $key
     * @return boolean
     */
    protected function isSessionKeyValid(string $key) : bool
    {
        return (preg_match(self::SESSION_PATTERN, $key) === 1);
    }
    /**
     * Zkontroluje, zda máme klíč relace
     *
     * @param string $key
     * @return void
     */
    protected function ensureSessionKeyIsvalid(string $key) : void
    {
        if ($this->isSessionKeyValid($key) === false) {
            throw new SessionInvalidArgumentException($key . ' není platný klíč relace');
        }
    }
}