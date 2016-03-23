<?php

namespace Newcamd;

class ConfigFactory
{
    public static function create($conf_string)
    {
        if (strpos($conf_string, 'CWS') === 0) {
            return self::createFromNewcamdList($conf_string);
        } elseif (strpos($conf_string, 'N:') === 0) {
            return self::createFromCccamCfg($conf_string);
        }

        return false;
    }

    private static function createFromNewcamdList($conf_string)
    {
        if (strpos($conf_string, 'CWS = ') === 0) {
            return self::createFromOneLine(substr($conf_string, 6));
        } elseif ((strpos($conf_string, 'CWS= ') === 0) || (strpos($conf_string, 'CWS =') === 0)) {
            return self::createFromOneLine(substr($conf_string, 5));
        } elseif (strpos($conf_string, 'CWS=') === 0) {
            return self::createFromOneLine(substr($conf_string, 4));
        }

        return false;
    }

    private static function createFromCccamCfg($conf_string)
    {
        if (strpos($conf_string, 'N: ') === 0) {
            return self::createFromOneLine(substr($conf_string, 3));
        }

        return false;
    }

    private static function createFromOscam($conf_string)
    {

    }

    private static function createFromOneLine($conf_string)
    {
        $ex = explode(' ', $conf_string);
        $config = new Config();
        $config->setHost($ex[0])
            ->setPort($ex[1])
            ->setUsername($ex[2])
            ->setPassword($ex[3]);

        $des_key = '';
        foreach (array_splice($ex, 4) as $des_part) {
            $des_key .= $des_part;
        }
        $config->setDesKey($des_key);

        return $config;
    }
}
