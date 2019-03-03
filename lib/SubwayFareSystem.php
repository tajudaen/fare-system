<?php
namespace fare;

use fare\core\FareSystem;

class SubwayFareSystem extends FareSystem
{
    const BASE_CHARGE = 3.20;
    private $prices = [
        'Z.1.1' => 2.50, 
        'Z.2/3.2/3' => 2.00, 
        'Z.1.2/3' => 3.00,
        'Z.2/3.3/2' => 2.25,
        'Z.*' => 3.20
    ];

    public function __construct() {
        $this->mode = "subway";
    }

    protected function calculateFare()
    {
        $balance = $this->getBalance();
        if (!$this->getEnd()) {
            $this->balance = $balance - SubwayFareSystem::BASE_CHARGE;
        } else {
            $zoneTravelledCode = '';
            if (count($this->getStartZone()) == 1 && count($this->getEndZone()) == 1) {
                if ($this->getStartZone()[0] == 1 && $this->getEndZone()[0] == 1) {
                    $zoneTravelledCode = 'Z.1.1';
                } elseif (($this->getStartZone()[0] == 1 && $this->getEndZone() != 1) || ($this->getEndZone()[0] == 1 && $this->getStartZone() != 1)) {
                    $zoneTravelledCode =  'Z.1.2/3';
                } elseif (($this->getStartZone()[0] != 1 && $this->getEndZone() != 1) || ($this->getEndZone()[0] != 1 && $this->getStartZone() != 1)) {
                    if ($this->getStartZone()[0] == $this->getEndZone()[0]) {
                        $zoneTravelledCode = 'Z.2/3.2/3';
                    } else {
                        $zoneTravelledCode = 'Z.2/3.3/2';                    
                    }
                }
            } elseif (count($this->getStartZone()) > 1 || count($this->getEndZone()) > 1) {
                if (count($this->getStartZone()) > 1 && count($this->getEndZone()) == 1) {
                    if(in_array($this->getEndZone()[0], $this->getStartZone())) {
                        if ($this->getEndZone()[0] == 1) {
                            $zoneTravelledCode = 'Z.1.1';
                        } else {
                            $zoneTravelledCode = 'Z.2/3.2/3'; 
                        }   
                    }
                } elseif (count($this->getStartZone()) == 1 && count($this->getEndZone()) > 1) {
                    if (in_array($this->getStartZone()[0], $this->getEndZone())) {
                        if ($this->getStartZone()[0] == 1) {
                            $zoneTravelledCode = 'Z.1.1';
                        } else {
                            $zoneTravelledCode = 'Z.2/3.2/3';
                        }
                    }
                }
                
            }

            switch ($zoneTravelledCode) {
                case 'Z.1.1':
                    $this->balance = $balance - $this->prices['Z.1.1'];
                    break;
                case 'Z.2/3.2/3':
                    $this->balance = $balance - $this->prices['Z.2/3.2/3'];
                    break;
                case 'Z.1.2/3':
                    $this->balance = $balance - $this->prices['Z.1.2/3'];
                    break;
                case 'Z.2/3.2/3':
                    $this->balance = $balance - $this->prices['Z.2/3.2/3'];
                    break;
                default:
                    $this->balance = $balance - $this->prices['Z.*'];
                    break;
            }
        }
        
    }

    
}