<?php

namespace StringPhp\Gpt\Enums;

enum Model: string
{
    case GPT_4o = 'gpt-4o';
    case GPT_4o_2024_05_13 = 'gpt-4o-2024-05-13';
    case GPT_4_TURBO = 'gpt-4-turbo';
    case GPT_4_TURBO_2024_04_09 = 'gpt-4-turbo-2024-04-09';
    case GPT_3_5_TURBO = 'gpt-3.5-turbo';
    case GPT_3_5_TURBO_0125 = 'gpt-3.5-turbo-0125';
}
