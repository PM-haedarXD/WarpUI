<?php
declare(strict_types=1);

namespace haedarXD;

use pocketmine\plugin\PluginBase;
use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;
use pocketmine\world\Position;
use pocketmine\world\sound\EndermanTeleportSound;
use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;
use pocketmine\Server;

class WarpUI extends PluginBase {

    public Config $warps;

    public function onEnable(): void {
        @mkdir($this->getDataFolder());

        $this->saveDefaultConfig();

        if(!file_exists($this->getDataFolder() . "warps.yml")){
            $this->warps = new Config($this->getDataFolder() . "warps.yml", Config::YAML, []);
            $this->warps->save();
        }

        $this->warps = new Config($this->getDataFolder() . "warps.yml", Config::YAML);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if(!$sender instanceof Player) return false;

        switch(strtolower($command->getName())){
            case "warp":
                $this->showWarpUI($sender);
                return true;
            case "setwarp":
                $this->showSetWarpForm($sender);
                return true;
            case "delwarp":
                $this->showDelWarpForm($sender);
                return true;
        }
        return false;
    }

    public function showWarpUI(Player $player): void {
        $warps = $this->warps->getAll();
        $title = $this->getConfig()->get("warp-menu-title", "Warps");
        $icon = $this->getConfig()->get("warp-icon", "textures/items/compass");

        $form = new SimpleForm(function(Player $player, $data) use ($warps) {
            if(!is_int($data)) return;
            $keys = array_keys($warps);
            if(!isset($keys[$data])) return;

            $warp = $warps[$keys[$data]];
            $world = Server::getInstance()->getWorldManager()->getWorldByName($warp["level"]);
            if(!$world) return;

            $pos = new Position($warp["x"], $warp["y"], $warp["z"], $world);
            $player->teleport($pos);

            if(($warp["title_enabled"] ?? true) === true) $player->sendTitle($warp["title"] ?? "Warped!", "");
            if(($warp["message_enabled"] ?? true) === true && !empty($warp["message"])) $player->sendMessage($warp["message"]);

            $player->getWorld()->addSound($player->getPosition(), new EndermanTeleportSound());
        });

        $form->setTitle($title);
        foreach($warps as $name => $warp){
            $form->addButton("§b".$name." §aGo", -1, $icon);
        }
        $player->sendForm($form);
    }

    public function showSetWarpForm(Player $player): void {
        $form = new CustomForm(function(Player $player, $data) {
            if(!is_array($data)) return;

            $name = trim($data[0] ?? "");
            $titleEnabled = (bool)($data[1] ?? true);
            $title = trim($data[2] ?? "");
            $messageEnabled = (bool)($data[3] ?? true);
            $message = trim($data[4] ?? "");

            if($name === "" || isset($this->warps->getAll()[$name])) return;

            $pos = $player->getPosition();

            $warpData = [
                "x" => $pos->getX(),
                "y" => $pos->getY(),
                "z" => $pos->getZ(),
                "level" => $player->getWorld()->getFolderName(),
                "title" => $title,
                "title_enabled" => $titleEnabled,
                "message" => $message,
                "message_enabled" => $messageEnabled
            ];

            $this->warps->set($name, $warpData);
            $this->warps->save();
            $player->sendMessage("Warp $name has been set!");
        });

        $form->setTitle("Set Warp");
        $form->addInput("Warp Name");
        $form->addToggle("Enable Title", true);
        $form->addInput("Title on Teleport");
        $form->addToggle("Enable Message", true);
        $form->addInput("Message on Teleport");
        $player->sendForm($form);
    }

    public function showDelWarpForm(Player $player): void {
        $warps = array_keys($this->warps->getAll());

        $form = new CustomForm(function(Player $player, $data) use ($warps) {
            if(!is_array($data) || !isset($warps[$data[0]])) return;

            $name = $warps[$data[0]];
            $this->warps->remove($name);
            $this->warps->save();
            $player->sendMessage("Warp $name deleted.");
        });

        $form->setTitle("Delete Warp");
        $form->addDropdown("Select a warp to delete", $warps);
        $player->sendForm($form);
    }
}