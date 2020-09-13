<?php
use Carbon\Carbon;

/**
 * Verifica se o dia de uma determinada
 * data está em um fim de semana
 * @param $date
 * @return bool
 * @throws Exception
 */
function isWeekend ($date)
{
    try {
        if ((new Carbon($date))->dayName == 'sábado' ||
            (new Carbon($date))->dayName == 'domingo')
            return true;

        return false;
    } catch (Exception $e) {
        throw $e;
    }
}

/**
 * Valida se a data do prazo é maior que a data de ínicio
 * @param $start
 * @param $end
 * @return bool
 * @throws Exception
 */
function dateEndIsValid ($start, $end)
{
    try {
        if ((new Carbon($start))->diffInDays((new Carbon($end)), false) < 0)
            return true;

        return false;

    } catch (Exception $e) {
        throw $e;

    }
}

function getOnlyDate ($dateTime)
{
    return explode(' ', $dateTime)[0];
}
