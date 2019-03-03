<?php
namespace fare\core;

abstract class FareSystem
{
    protected $balance;
    protected $start;
    protected $end;
    protected $mode;
    private $zones = ['1' => ['5th', 'Pelham Parkway'], '2' =>
    ['Pelham Parkway', 'Guns Hill'], '3' => ['Bronx']];

    abstract protected function calculateFare();

    protected function getMode()
    {
        return $this->mode;
    }

    public function startTrip($start)
    {
        $this->start = $start;
    }
    
    public function endTrip($end = null)
    {
        $this->end = $end;
    }

    public function getSummary()
    {
        $this->calculateFare();
        return "From " . $this->getstart() . " to " . $this->getEnd() . " balance " . $this->getBalance() . " by " . $this->getMode();
    }

    protected function getStart()
    {
        return $this->start;
    }

    protected function getStartZone()
    {
        return $this->getZone($this->start);
    }

    protected function getEnd()
    {
        return $this->end;
    }

    protected function getEndZone()
    {
        return $this->getZone($this->end);
    }

    public function getBalance()
    {
        return $this->balance;
    }

    public function loadCard(int $amount)
    {
        return $this->balance = $amount;
    }

    private function getZone($station)
    {
        $bucket = [];

        foreach ($this->zones as $key => $value) {
            if (in_array($station, $value)) {
                array_push($bucket, $key);
            }
        }
        return $bucket;
    }
}
