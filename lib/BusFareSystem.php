<?php
namespace fare;

use fare\core\FareSystem;

class BusFareSystem extends FareSystem
{
    const CHARGE = 1.80;

    public function __construct() {
        $this->mode = "bus";
    }

    protected function calculateFare()
    {
        $balance = $this->getBalance();
        if ($balance > BusFareSystem::CHARGE) {
            $this->balance = $balance - BusFareSystem::CHARGE;
            return;
        }
        throw new \Exception("Insufficient balance. please top up your account");
        
    }
}