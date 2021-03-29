<?php

namespace BanQuery\Forms;

use BanQuery\BanQuery;
use dktapps\pmforms\CustomForm;
use dktapps\pmforms\CustomFormResponse;
use dktapps\pmforms\element\Dropdown;
use dktapps\pmforms\element\Label;
use pocketmine\Player;
use pocketmine\utils\TextFormat as C;

class UserBanForm extends CustomForm{

    /** @var BanQuery */
    private $plugin;

    public function __construct(BanQuery $plugin){
        $this->plugin = $plugin;

        parent::__construct(
            C::BOLD . C::DARK_GRAY . "Ban",

            [
                new Label("element0", "\n"),
                new Dropdown("element1", "Players:", $this->getAllPlayers())
            ],

            function (Player $player, CustomFormResponse $response): void{
                $dropdown =;
            }
        );
    }

    /**
     * @return array
     */
    public function getAllPlayers(){
        $array = [];

        foreach ($this->plugin->getServer()->getOnlinePlayers() as $players){
            $array = [$players->getName()];
        }
        return $array;
    }
}