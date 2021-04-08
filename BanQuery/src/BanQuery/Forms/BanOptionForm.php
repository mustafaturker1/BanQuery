<?php

namespace BanQuery\Forms;

use BanQuery\BanQuery;
use dktapps\pmforms\MenuForm;
use dktapps\pmforms\MenuOption;
use pocketmine\Player;
use pocketmine\utils\TextFormat as C;

class BanOptionForm extends MenuForm{

    /** @var BanQuery */
    private $plugin;

    /**
     * BanOptionForm constructor.
     * @param BanQuery $plugin
     */
    public function __construct(BanQuery $plugin){
        $this->plugin = $plugin;

        parent::__construct(
            C::BOLD . C::DARK_GRAY . "Ban Option Form",
            "\n",
            [
                new MenuOption(C::DARK_GRAY . "BAN" . C::RESET),
                new MenuOption(C::DARK_GRAY . "UNBAN" . C::RESET)
            ],

            function (Player $player, int $selected): void {
                $button = C::clean($this->getOption($selected)->getText());

                if ($button == "Ban"){
                    $player->sendForm(new UserBanForm($this->plugin));
                }
                if ($button == "Unban"){
                    $player->sendForm(new UserUnbanForm($this->plugin));
                }
            });
    }
}
