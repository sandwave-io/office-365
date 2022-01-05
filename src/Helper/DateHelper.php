<?php declare(strict_types=1);

namespace Kpn\Helper;

class DateHelper
{
    public static function UTC()
    {
        $timezone = new \DateTimeZone('UTC');
        return (new \DateTime())->setTimezone($timezone);
    }

    public static function date()
    {
        return (new \DateTime());
    }
}
