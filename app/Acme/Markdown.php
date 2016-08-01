<?php
namespace Acme;


use HTMLPurifier;
use ParsedownExtra;

class Markdown extends ParsedownExtra
{
    protected $purifier;

    /**
     * Markdown constructor.
     */
    public function __construct()
    {
        $this->purifier = new HTMLPurifier;
    }

    function text($raw)
    {
        return $this->purifier->purify(
            parent::text($raw)
        );
    }
}