<?php

namespace App\Helpers;

class RemoveDirectory
{
    /**
     * @param String $directoryPath
     *
     * @return bool
     */
    public function path(string $directoryPath): bool
    {
        if (!file_exists($directoryPath)) {
            return true;
        }

        if (!is_dir($directoryPath)) {
            return unlink($directoryPath);
        }

        foreach (scandir($directoryPath) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->path($directoryPath . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }

        }

        return rmdir($directoryPath);
    }
}

