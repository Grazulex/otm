<?php

namespace App\Services;

use DateTimeImmutable;
use DateInterval;
use DateTimeZone;
use IteratorAggregate;
use ArrayIterator;

class HolidayService implements IteratorAggregate {
    protected static $years = [];
    protected $year;
    protected $easter;
    protected $list;
    protected $timezone;

    public static function get(int $year = null): HolidayService {
        $year = $year ?? date('Y');
        if (!array_key_exists($year, static::$years)) {
            static::$years[$year] = new HolidayService($year);
        }
        return static::$years[$year];
    }

    protected function __construct(int $year) {
        $this->year = $year;

        $this->timezone = new DateTimeZone('Europe/Brussels');
        $days = easter_days($this->year);
        $this->easter = $this->makeDate(3, 21)->add(
            new DateInterval("P{$days}D"),
        );
        $this->list = $this->generateList();
    }

    public function getEaster(): DateTimeImmutable {
        return $this->easter;
    }

    protected function makeDate(int $month, int $day): DateTimeImmutable {
        return new DateTimeImmutable(
            "{$this->year}-{$month}-{$day} 00:00:00",
            $this->timezone,
        );
    }

    protected function generateList(): array {
        $list = [
            [
                'date' => $this->makeDate(1, 1),
                'name' => [
                    'nl' => 'Nieuwjaar',
                    'fr' => 'Nouvel an',
                    'de' => 'Neujahr',
                    'en' => "New Year's day",
                ],
            ],
            [
                'date' => $this->makeDate(5, 1),
                'name' => [
                    'nl' => 'Dag van de arbeid',
                    'fr' => 'Fête du travail',
                    'de' => 'Tag der Arbeit',
                    'en' => 'Labour day',
                ],
            ],
            [
                'date' => $this->makeDate(7, 21),
                'name' => [
                    'nl' => 'Nationale feestdag',
                    'fr' => 'Fête Nationale',
                    'de' => 'Nationalfeiertag',
                    'en' => 'Belgian National Day',
                ],
            ],
            [
                'date' => $this->makeDate(8, 15),
                'name' => [
                    'nl' => 'Onze-Lieve-Vrouw-Hemelvaart',
                    'fr' => 'Assomption',
                    'de' => 'Mariä Himmelfahrt',
                    'en' => 'Assumption of Mary',
                ],
            ],
            [
                'date' => $this->makeDate(11, 1),
                'name' => [
                    'nl' => 'Allerheiligen',
                    'fr' => 'Toussaint',
                    'de' => 'Allerheiligen',
                    'en' => "All Saint's day",
                ],
            ],
            [
                'date' => $this->makeDate(11, 11),
                'name' => [
                    'nl' => 'Wapenstilstand',
                    'fr' => "Jour de l'Armistice",
                    'de' => 'Waffenstillstand',
                    'en' => 'Armisitice Day',
                ],
            ],
            [
                'date' => $this->makeDate(12, 25),
                'name' => [
                    'nl' => 'Kerstmis',
                    'fr' => 'Noël',
                    'de' => 'Weihnachten',
                    'en' => 'Christmas',
                ],
            ],
        ];

        $list[] = [
            'date' => $this->easter->add(new DateInterval('P1D')),
            'name' => [
                'nl' => 'Paasmaandag',
                'fr' => 'Lundi de Pâques',
                'de' => 'Ostermontag',
                'en' => 'Easter Monday',
            ],
        ];
        $list[] = [
            'date' => $this->easter->add(new DateInterval('P39D')),
            'name' => [
                'nl' => 'Onze-Lieve-Heer-Hemelvaart',
                'fr' => 'Ascension',
                'de' => 'Christi Himmelfahrt',
                'en' => 'Ascension',
            ],
        ];
        $list[] = [
            'date' => $this->easter->add(new DateInterval('P50D')),
            'name' => [
                'nl' => 'Pinkstermaandag',
                'fr' => 'Lundi de Pentecôte',
                'de' => 'Pfingstmontag',
                'en' => 'Pentecost Monday',
            ],
        ];

        usort($list, function ($a, $b) {
            return $a['date'] <=> $b['date'];
        });

        $this->list = [];
        array_map(function ($item) {
            $this->list[$item['date']->format('m-d')] = $item;
        }, $list);
        return $this->list;
    }

    public function getIterator(): ArrayIterator {
        return new ArrayIterator($this->list);
    }

    public function toArray(): array {
        return $this->list;
    }

    public function isHoliday(int $month, int $day) {
        $key = $this->makeDate($month, $day)->format('m-d');
        return array_key_exists($key, $this->list);
    }
}
