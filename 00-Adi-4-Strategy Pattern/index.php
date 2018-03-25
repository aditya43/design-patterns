<?php

/**
 *  Strategy Design Pattern | Aditya Hajare
 */

interface Logger
{
    public function log($message);
}

class LogToFile implements Logger
{
    public function log($message)
    {
        var_dump('Logging to file: ' . $message);
    }
}

class LogToDatabase implements Logger
{
    public function log($message)
    {
        var_dump('Logging to database: ' . $message);
    }
}

class LogToSass implements Logger
{
    public function log($message)
    {
        var_dump('Logging to Saas: ' . $message);
    }
}

class AdiApp
{
    protected $logger = null;

    public function __construct($logger = null)
    {
        $this->logger = $logger;
    }

    public function authenticate()
    {
        $this->logger = (null == $this->logger) ? new LogToFile() : $this->logger;
        $this->logger->log('Authentication successfull.');
    }
}

(new AdiApp(new LogToSass()))->authenticate();
