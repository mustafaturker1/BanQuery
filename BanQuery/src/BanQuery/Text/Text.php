<?php

namespace BanQuery\Text;

use BanQuery\BanQuery;
use pocketmine\Player;

class Text{

    /** @var BanQuery */
    private $plugin;

    /**
     * @var string[]
     */
    private $codes = [
        "{player}",
        "&"
    ];

    public function __construct(BanQuery $plugin){
        $this->plugin = $plugin;
    }

    /**
     * @param string $text
     * @param Player $player
     * @return string|string[]
     */
    public function convertCodeInTheText(string $text, Player $player){
        $config = $this->plugin->getConfigData();
        return str_replace($this->codes, [$player->getName(), "§"], $config->get("Prefix")) . str_replace($this->codes, [$player->getName(), "§"], $text);
    }
}
