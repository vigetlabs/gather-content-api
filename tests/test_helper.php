<?php

require_once __DIR__ . "/../vendor/autoload.php";

\VCR\VCR::configure()
  ->enableLibraryHooks(['curl'])
  ->setMode('once');

\VCR\VCR::turnOn();
