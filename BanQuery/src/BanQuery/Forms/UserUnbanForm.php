<?php

namespace BanQuery\Forms;

use BanQuery\BanQuery;
use dktapps\pmforms\ModalForm;
use pocketmine\Player;
use pocketmine\utils\TextFormat as C;

class UserUnbanForm extends ModalForm{

    /** @var BanQuery */
    private $plugin;

    /**
     * UserUnbanForm constructor.
     * @param BanQuery $plugin
     */
    public function __construct(BanQuery $plugin){
        $this->plugin = $plugin;

        parent::__construct(
            C::BOLD . C::DARK_GRAY . "Unban",
            "\n",

            function (Player $player, bool $selected): void{
                if ($selected){
                    $player->sendForm(new UserUnbanSearchForm($this->plugin));
                }else{
                    $player->sendForm(new UserUnbanAllForm($this->plugin));
                }
            },
            "Search Banned Player",
            "All Banned Players"
        );
    }
}
