<?php

namespace Anastasiia\FileStorageIterator;

class FileStorageIterator implements \Iterator {
    private $fileHandle;
    private string|null $currentLine;
    private bool $valid;

    private int $currentLineNumber;

    public function __construct($filePath) {
        $this->fileHandle = fopen($filePath, 'r');
        $this->currentLine = null;
        $this->valid = false;
        $this->currentLineNumber = 0;
    }

    public function __destruct() {
        if ($this->fileHandle) {
            fclose($this->fileHandle);
        }
    }

    public function rewind() : void
    {
        fseek($this->fileHandle, 0);
        $this->currentLineNumber = 0;
        $this->getNextLine();
    }

    public function valid() : bool
    {
        return $this->valid;
    }

    public function current() : mixed
    {
        return $this->currentLine;
    }

    public function key() : mixed
    {
        return $this->currentLineNumber;
    }

    public function next() : void
    {
        $this->currentLineNumber++;
        $this->getNextLine();
    }

    private function getNextLine()
    {
        $line = fgets($this->fileHandle);
        if ($line !== false) {
            $this->currentLine = trim($line);
            $this->valid = true;
        } else {
            $this->currentLine = null;
            $this->valid = false;
        }
    }
}
