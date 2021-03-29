<?php

namespace BanQuery\Forms;

use BanQuery\BanQuery;
use BanQuery\Text\Text;
use dktapps\pmforms\MenuForm;
use dktapps\pmforms\MenuOption;
use pocketmine\Player;
use pocketmine\utils\TextFormat as C;

class UserUnbanAllForm extends MenuForm{

    /** @var BanQuery */
    private $plugin;

    /**
     * UserUnbanAllForm constructor.
     * @param BanQuery $plugin
     */
    public function __construct(BanQuery $plugin){
        $this->plugin = $plugin;
        $mysql = $this->plugin->getMySQL();
        $option = [];
        foreach ($mysql->listAllBanUser() as $users){
            $option[] = new MenuOption(C::BOLD . C::DARK_GRAY . $users['ban_name'] . C::RESET);
        }

        parent::__construct(
            C::BOLD . C::DARK_GRAY . "Unban",
            "\n",

            $option,

            function (Player $player, int $selected): void{
                $button = C::clean($this->getOption($selected)->getText());
                $player->sendForm(new UserUnbanConfirmForm($this->plugin, $button));
            }
        );
    }
}
