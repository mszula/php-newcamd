<?php

namespace Newcamd\ServerMessage\Response;

use Newcamd\Card\Caid;
use Newcamd\Card\Provider;
use Newcamd\ServerMessageInterface;
use Newcamd\ServerMessageResponse;

class Card extends ServerMessageResponse implements ServerMessageInterface
{
    const MESSAGE_ID = "\xe4";

    /**
     * @var Caid
     */
    protected $caid;
    /**
     * @var Provider[]
     */
    protected $providers = [];
    
    public function setMessage($message)
    {
        parent::setMessage($message);

        $this->prepareCaid()->prepareProviders();
    }

    /**
     * @return array
     */
    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * @return mixed
     */
    public function getCaid()
    {
        return $this->caid;
    }

    protected function prepareCaid()
    {
        $this->caid = new Caid(2);
        $this->caid->set($this->getMessage()->getRange(4, 2));

        return $this;
    }

    protected function prepareProviders()
    {
        for ($i=0; $i<$this->getMessage()->getOne(14)->dec(); $i++) {
            $provider = new Provider(3);
            $provider->set($this->getMessage()->getRange(15+11*$i, 3));
            $this->providers[] = $provider;
        }

        return $this;
    }
}
