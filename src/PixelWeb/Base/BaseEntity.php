<?php 

declare(strict_types=1);

namespace PixelWeb\Base;

use PixelWeb\Base\Exception\BaseInvalidArgumentException;
use PixelWeb\Utility\Sanitizer;

class BaseEntity
{
    public function __construct()
    {
        if (empty($dirtyData)) {
            throw new BaseInvalidArgumentException('Nebyla odeslána žádná data.');
        }
        if (is_array($dirtyData)) {
            foreach ($this->cleanData($dirtyData) as $key => $value) {
                $this->$key = $value;
            }
        }
    }
    private function cleanData(array $dirtyData) : array
    {
        $cleanData = Sanitizer::clean($dirtyData);
        if ($cleanData) {
            return $cleanData;
        }
    }
	
}