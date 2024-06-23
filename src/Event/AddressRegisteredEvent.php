<?php

namespace App\Event;

use App\Entity\Address;

use Symfony\Contracts\EventDispatcher\Event;



class AddressRegisteredEvent extends Event
{

    public const NAME = 'address.registered';

    public function __construct(private Address $address)
    {
    }

    public function getAddress(): Address
    {
        return $this->address;
    }
}