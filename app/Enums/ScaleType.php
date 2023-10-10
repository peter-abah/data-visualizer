<?php

namespace App\Enums;

enum ScaleType: string
{
    case Category = 'category';
    case Linear = 'linear';
    case Logarithmic = 'logarithmic';
    case Time = 'time';
}
