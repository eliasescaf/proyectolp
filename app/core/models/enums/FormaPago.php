<?php

namespace app\core\models\enums;

enum FormaPago: string {
    case EFECTIVO = 'Efectivo';
    case DEBITO = 'Debito';
    case CREDITO = 'Credito';
    case TRANSFERENCIA = 'Transferencia';
}