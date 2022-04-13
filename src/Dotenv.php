<?php

namespace Dotenv;

class Dotenv
{
    /**
     * The path instance.
     *
     * @var string
     */
    private $path;

    /**
     * Create a new dotenv instance.
     *
     * @param string @path
     * 
     * @throws \InvalidArgumentException
     *
     * @return void
     */
    public function __construct(string $path)
    {
        if (!file_exists($path)) {
            throw new \InvalidArgumentException(sprintf('The file %s does not exist', $path));
        }
        $this->path = $path;
    }

    /**
     * Read and load environment file(s).
     *
     * @throws \RuntimeException
     *
     * @return void
     */
    public function load(): void
    {
        if (!is_readable($this->path)) {
            throw new \RuntimeException(sprintf('The file %s is not readable', $this->path));
        }
        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}
