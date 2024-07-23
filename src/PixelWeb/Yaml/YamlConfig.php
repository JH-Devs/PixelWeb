<?php

declare(strict_types=1);

namespace PixelWeb\Yaml;

use PixelWeb\Base\Exception\BaseException;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class YamlConfig 
{
    /**
     * Zkontroluje, zda zadaný konfigurační soubor yaml existuje v zadaném adresáři, jinak vyvolá výjimku
     * 
     * @param string $filename
     * @throws \PixelWeb\Base\Exception\BaseException
     * @return void
     */
    private function isFileExists(string $filename)
    {
        if (!file_exists($filename))
            throw new BaseException($filename . ' neexistuje');
    }
    /**
     * Načte konfiguraci yaml
     * 
     * @param string $yamlFile
     * @return mixed
     */
    public function getYaml(string $yamlFile)
    {
        foreach (glob(CONFIG_PATH . DS . '*.yaml') as $file) {
            $this->isFileExists($file);
            $parts = parse_url($file);
            $path = $parts['path'];
            if (strpos($path, $yamlFile) !== false) {
                return Yaml::parseFile($file);
            }
        }
    }
    /**
     * Načte konfiguraci yaml do analyzátoru yaml
     * 
     * @param string $yamlFile
     * @return mixed
     */
    public static function file(string $yamlFile)
    {
        return (array)(new YamlConfig) -> getYaml($yamlFile);
    }
    
}