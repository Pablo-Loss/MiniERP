<?php

namespace App\Enums;

enum MovementType: string {
    case Balanco = "balanco";
    case Entrada = "entrada";
    case Saida = "saida";
}