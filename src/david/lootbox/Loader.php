<?php

namespace david\lootbox;

use david\lootbox\command\GiveLootBoxCommand;
use david\lootbox\types\LootboxManager;
use muqsit\invmenu\InvMenuHandler;
use pocketmine\plugin\PluginBase;

class Loader extends PluginBase {
class muqsit\invmenu\InvMenuHandler {

    /** @var self */
    private static $instance;

    /** @var LootboxManager */
    private $lootboxManager;

    public function onLoad() {
        if(!is_dir($this->getDataFolder())) {
            mkdir($this->getDataFolder());
        }
        if(!is_dir($this->getDataFolder() . "lootboxes")) {
            mkdir($this->getDataFolder() . "lootboxes");
        }
        $this->saveResource("lootboxes" . DIRECTORY_SEPARATOR . "test.yml");
        self::$instance = $this;
    }

    public function onEnable() {
        $this->lootboxManager = new LootboxManager($this);
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->getServer()->getCommandMap()->register("givelootbox", new GiveLootBoxCommand());
        if(!InvMenuHandler::isRegistered()){
            InvMenuHandler::register($this);
        }
    }

    /**
     * @return self
     */
    public static function getInstance(): self {
        return self::$instance;
    }

    /**
     * @return LootboxManager
     */
    public function getLootboxManager(): LootboxManager {
        return $this->lootboxManager;
    }
}
