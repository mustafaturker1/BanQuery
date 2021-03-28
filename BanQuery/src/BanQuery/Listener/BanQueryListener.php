<?php

namespace BanQuery\Listener;

use BanQuery\BanQuery;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerPreLoginEvent;

class BanQueryListener implements Listener
{
    /** @var BanQuery */
    private $plugin;

    public function __construct(BanQuery $plugin)
    {
        $this->plugin = $plugin;
    }

    public function event(PlayerPreLoginEvent $event)
    {
        // TODO
    }
}