<?php
namespace App\Enums;
enum TaskStatus :int {
    case todo = 0;
    case done = 1;

    public static function fromName(string $name): string|false
    {
        foreach (self::cases() as $status) {
            if( $name === $status->name ){
                return $status->value;
            }
        }
       return false;
    }
}