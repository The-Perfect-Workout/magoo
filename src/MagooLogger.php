<?php

namespace Pachico\Magoo;

use Psr\Log\LoggerInterface;
use Stringable;

/**
 * MagooLogger acts as a middleware between your application and a PSR3 logger
 * masking every message passed to it
 */
class MagooLogger implements LoggerInterface
{
    private LoggerInterface $logger;

    private MaskManagerInterface $maskManager;

    private MagooArray $magooArray;

    public function __construct(LoggerInterface $logger, MaskManagerInterface $maskManager)
    {
        $this->logger = $logger;
        $this->maskManager = $maskManager;
        $this->magooArray = new MagooArray($maskManager);
    }

    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    public function getMaskManager(): MaskManagerInterface
    {
        return $this->maskManager;
    }

    public function emergency(string|Stringable $message, array $context = []): void
    {
        [$maskedMessage, $maskedContext] = $this->maskLogArguments($message, $context);
        $this->logger->emergency($maskedMessage, $maskedContext);
    }

    public function alert(string|Stringable $message, array $context = []): void
    {
        [$maskedMessage, $maskedContext] = $this->maskLogArguments($message, $context);
        $this->logger->alert($maskedMessage, $maskedContext);
    }

    public function critical(string|Stringable $message, array $context = []): void
    {
        [$maskedMessage, $maskedContext] = $this->maskLogArguments($message, $context);
        $this->logger->critical($maskedMessage, $maskedContext);
    }

    public function error(string|Stringable $message, array $context = []): void
    {
        [$maskedMessage, $maskedContext] = $this->maskLogArguments($message, $context);
        $this->logger->error($maskedMessage, $maskedContext);
    }

    public function warning(string|Stringable $message, array $context = []): void
    {
        [$maskedMessage, $maskedContext] = $this->maskLogArguments($message, $context);
        $this->logger->warning($maskedMessage, $maskedContext);
    }

    public function notice(string|Stringable $message, array $context = []): void
    {
        [$maskedMessage, $maskedContext] = $this->maskLogArguments($message, $context);
        $this->logger->notice($maskedMessage, $maskedContext);
    }

    public function info(string|Stringable $message, array $context = []): void
    {
        [$maskedMessage, $maskedContext] = $this->maskLogArguments($message, $context);
        $this->logger->info($maskedMessage, $maskedContext);
    }

    public function debug(string|Stringable $message, array $context = []): void
    {
        [$maskedMessage, $maskedContext] = $this->maskLogArguments($message, $context);
        $this->logger->debug($maskedMessage, $maskedContext);
    }

    public function log($level, string|Stringable $message, array $context = []): void
    {
        [$maskedMessage, $maskedContext] = $this->maskLogArguments($message, $context);
        $this->logger->log($level, $maskedMessage, $maskedContext);
    }

    /**
     * @return array{0: string, 1: array}
     */
    private function maskLogArguments(string|Stringable $message, array $context): array
    {
        return $this->magooArray->getMasked([(string) $message, $context]);
    }
}
