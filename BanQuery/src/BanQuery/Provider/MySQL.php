<?php

namespace BanQuery\Provider;

use BanQuery\BanQuery;
use PDO;
use pocketmine\Player;

class MySQL{

    /** @var BanQuery */
    private $plugin;

    /** @var PDO  */
    private $mysql;

    public const MYSQL_INFO = [
        "Hostname" => "localhost",
        "Databasename" => "banlist",
        "Username" => "root",
        "Password" => "12345678"
    ];

    /**
     * MySQL constructor.
     * @param BanQuery $plugin
     */
    public function __construct(BanQuery $plugin){
        $this->plugin = $plugin;
        try {
            $this->mysql = new PDO("mysql:host=" . self::MYSQL_INFO["Hostname"] . ";dbname=" . self::MYSQL_INFO["Databasename"] . ";", self::MYSQL_INFO["Username"], self::MYSQL_INFO["Password"]);
            $plugin->getLogger()->info("PDO Connection Successful!");
        }catch (\PDOException $e){
            $plugin->getLogger()->info("Connection failed!\n\n" . $e->getMessage());
        }
    }

    /**
     * @param Player $user
     * @return bool
     */
    public function addBanUser(Player $user): bool{
        // Board Name: bannedlist
        $data = $this->mysql->prepare("INSERT INTO bannedlist SET ban_name=?");
        $control = $data->execute([
            strtolower($user->getName())
        ]);

        if ($control){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param Player $user
     * @return bool
     */
    public function deleteBanUser(Player $user): bool{
        // Board Name: bannedlist
        $data = $this->mysql->prepare("DELETE FROM bannedlist WHERE ban_name=?");
        $control = $data->execute([
            strtolower($user->getName())
        ]);

        if ($control){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param Player $user
     * @return mixed
     */
    public function listBanUser(Player $user): mixed{
        // Board Name: bannedlist
        $data = $this->mysql->prepare("SELECT * FROM bannedlist WHERE ban_name=?");
        $data->execute([
            strtolower($user->getName())
        ]);

        return $data->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @return mixed
     */
    public function listAllBanUser(): mixed{
        // Board Name: bannedlist
        $data = $this->mysql->prepare("SELECT * FROM bannedlist");
        $data->execute();

        return $data->fetch(PDO::FETCH_ASSOC);
    }
}
