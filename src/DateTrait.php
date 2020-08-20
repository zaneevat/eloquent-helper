<?php


namespace Zaneevat\EloquentHelper;


use Carbon\Carbon;

trait DateTrait
{

    /**
     * Filter by post creation date (From)
     * @param $query
     * @param Carbon|null $date
     * @param string $column
     * @return mixed
     */
    public function scopeFilterDateFrom($query, Carbon $date = null, $column = 'created_at')
    {
        return $this->scopeFilterDate($query, $date, '>=', $column);
    }

    /**
     * Filter by post creation date (To)
     * @param $query
     * @param Carbon|null $date
     * @param string $column
     * @return mixed
     */
    public function scopeFilterDateTo($query, Carbon $date = null, $column = 'created_at')
    {
        return $this->scopeFilterDate($query, $date, '<=', $column);
    }

    /**
     * Filter by post creation date
     * @param $query
     * @param Carbon|null $date
     * @param string $operator
     * @param string $column
     * @return mixed
     */
    public function scopeFilterDate($query, Carbon $date = null, $operator = '=', $column = 'created_at')
    {
        return $query->when(!is_null($date), function($q) use ($date, $operator, $column){
            return $q->where($column, $operator, $date);
        });
    }

    /**
     * The method converts the required model attribute to an object of type Carbon and
     * returns data as a string of the required format or just Null
     * @param $column - Attribute to be converted to Carbon
     * @param string $format - Desired date format
     * @return string|null
     */
    public function getDate($column, $format = 'd.m.Y H:i:s')
    {
        return (!is_null($this->$column)) ? Carbon::parse($this->$column)->format($format) : null;
    }

    /**
     * The method returns the day of the week in the desired form
     * @param string $column - attribute (date) by which to get the day of the week
     * @param string $type - Desired day format, short - short entry, full - full entry
     * @return string|null
     */
    public function getDay(string $column, string $type = 'short')
    {
        $array = [
            [
                'full'  => 'Воскресенье',
                'short' => 'Вс',
            ],
            [
                'full'  => 'Понедельник',
                'short' => 'Пн',
            ],
            [
                'full'  => 'Вторник',
                'short' => 'Вт',
            ],
            [
                'full'  => 'Среда',
                'short' => 'Ср',
            ],
            [
                'full'  => 'Четверг',
                'short' => 'Чт',
            ],
            [
                'full'  => 'Пятница',
                'short' => 'Пт',
            ],
            [
                'full'  => 'Суббота',
                'short' => 'Сб',
            ],
        ];
        return (!is_null($this->$column)) ? $array[Carbon::parse($this->$column)->dayOfWeek][$type] : null;
    }
}
