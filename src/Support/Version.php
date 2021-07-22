<?php

namespace Firebird\Support;

class Version
{
    public const FIREBIRD_15 = '1.5';
    public const FIREBIRD_25 = '2.5';

    public const SUPPORTED_VERSIONS = [
        self::FIREBIRD_15,
        self::FIREBIRD_25,
    ];
}
