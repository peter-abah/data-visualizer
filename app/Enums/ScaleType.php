<?php

namespace App\Enums;

enum ScaleType: string {
    case Time = 'time';
    case Linear = 'linear';
    case Category = 'category';
    case Logarithmic = 'logarithmic';
}
