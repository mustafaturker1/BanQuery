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
                new MenuOption(C::BOLD . C::DARK_GRAY . "Ban" . C::RESET),
                new MenuOption(C::BOLD . C::DARK_GRAY . "Unban" . C::RESET),
                new MenuOption(C::BOLD . C::DARK_GRAY . "Ban List" . C::RESET)
            ],

            function (Player $player, ?int $response): void {
                switch (C::clean($this->getOption($response)->getText())) {
                    case "Ban":
                        $player->sendForm(new UserBanForm($this->plugin));
                        break;
                    case "Unban":
                        $player->sendForm(new UserUnbanForm($this->plugin));
                }
            });
    }
}
