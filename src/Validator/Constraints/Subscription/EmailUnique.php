<?php declare(strict_types=1);

namespace App\Validator\Constraints\Subscription;

use Symfony\Component\Validator\Constraint;

/** @Annotation */
class EmailUnique extends Constraint
{
    public $message = 'Already existing e-mail';

    public function getTargets()
    {
        return array(self::CLASS_CONSTRAINT, self::PROPERTY_CONSTRAINT);
    }
}
