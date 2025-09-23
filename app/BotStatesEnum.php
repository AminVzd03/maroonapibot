<?php

namespace App;

enum BotStatesEnum : string
{
    case START = 'start';
    case RESTART = '/restart';
    case PRODUCT_NAME = 'productName';


}
