<?php

namespace BanQuery\Provider;

use BanQuery\BanQuery;
use PDO;
use pocketmine\utils\TextFormat as C;

class MySQL{

    /** @var BanQuery */
    private $plugin;

    /** @var PDO  */
    private $mysql;

    public const MYSQL_INFO = [
        "Hostname" => "localhost",
        "Databasename" => "banlist",
        "Username" => "root",
        "Password" => ""
    ];

    /**
     * MySQL constructor.
     * @param BanQuery $plugin
     */
    public function __construct(BanQuery $plugin){
        $this->plugin = $plugin;

        try {
            $this->mysql = new PDO("mysql:host=" . self::MYSQL_INFO["Hostname"] . ";dbname=" . self::MYSQL_INFO["Databasename"] . ";", self::MYSQL_INFO["Username"], self::MYSQL_INFO["Password"]);
            $this->plugin->getLogger()->info(C::GREEN . "MySQL Connection Successful!");
        }catch (\PDOException $e){
            $this->plugin->getLogger()->alert("MySQL Connection failed!\n\n" . $e->getMessage());
            $this->plugin->getServer()->getPluginManager()->disablePlugin($this->plugin);
        }
    }

    /**
     * @param string $user
     * @param string $reason
     * @param string $day
     * @param bool $unlimited
     * @return bool
     */
    public function addBanUser(string $user, string $reason, string $day, bool $unlimited = false): bool{
        // Board Name: bannedlist
        $control = null;
        date_default_timezone_set('Europe/Istanbul');

        if ($unlimited){
            $data = $this->mysql->prepare("INSERT INTO bannedlist SET ban_name=?, ban_reason=?, ban_time=?, unban_time=?, ban_status=?");
            $control = $data->execute([
                strtolower($user),
                $reason,
                date("d.m.Y H:i:s"),
                null,
                1
            ]);
        }else {
            $unban = strtotime("+{$day} Day");
            $data = $this->mysql->prepare("INSERT INTO bannedlist SET ban_name=?, ban_reason=?, ban_time=?, unban_time=?, ban_status=?");
            $control = $data->execute([
                strtolower($user),
                $reason,
                date("d.m.Y H:i:s"),
                date("d.m.Y H:i:s", $unban),
                0
            ]);
        }

        if ($control){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param string $user
     * @return bool
     */
    public function deleteBanUser(string $user): bool{
        // Board Name: bannedlist
        $data = $this->mysql->prepare("DELETE FROM bannedlist WHERE ban_name=?");
        $control = $data->execute([
            strtolower($user)
        ]);

        if ($control){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param string $user
     * @return mixed
     */
    public function listBanUser(string $user): mixed{
        // Board Name: bannedlist
        $data = $this->mysql->prepare("SELECT * FROM bannedlist WHERE ban_name=?");
        $data->execute([
            strtolower($user)
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

    /**
     * @param string $user
     * @return bool
     */
    public function isBanned(string $user): bool{
        // Board Name: bannedlist
        $data = $this->mysql->prepare("SELECT * FROM bannedlist WHERE ban_name=?");
        $control = $data->execute([
            strtolower($user)
        ]);

        if ($control){
            return true;
        }else{
            return false;
        }
    }
}
