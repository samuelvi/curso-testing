<?php declare(strict_types=1);

namespace App\Tests\Common\Util;

final class Spins
{
    public static function spins(callable $anonymous, $seconds = 10, $fraction = 4)
    {
        $max = $seconds * $fraction;
        $i = 1;
        $exception = null;
        while ($i++ <= $max) {
            try {
                if ($anonymous()) {
                    return true;
                }
            } catch (\Exception $e) {
                $exception = $e;
                return false;
            }

            usleep((int)((1 / $fraction) * 1000000));
        }

        if ($exception instanceof \Exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode(), $exception->getPrevious());
        }

        $backtrace = debug_backtrace();
        throw new \Exception(
            sprintf("Timeout thrown by %s::%s()\n%s, line %s",
                $backtrace[0]['class'], $backtrace[0]['function'], $backtrace[0]['file'], $backtrace[0]['line']
            )
        );
    }
}
