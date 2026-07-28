<div align="center">
  <h1>⚡ WarpUI</h1>
  <p><em>A sleek, UI-driven warp management plugin for PocketMine-MP 5.0.0</em></p>
  
  [![PocketMine-MP](https://img.shields.io/badge/PocketMine--MP-5.0.0-fb8c00?style=for-the-badge&logo=github)](https://pmmp.io)
  [![Version](https://img.shields.io/badge/version-1.0.8-blue?style=for-the-badge)](https://github.com/PM-haedarXD/WarpUI/releases)
  [![License](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)](LICENSE)
  [![PHP](https://img.shields.io/badge/PHP-8.0%2B-777bb3?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
  [![FormAPI](https://img.shields.io/badge/libFormAPI-2.1.1-red?style=for-the-badge)](https://github.com/jojoe77777/FormAPI)
</div>

---

## 📸 Screenshots

<details open>
<summary><strong>🎨 Click to expand gallery (5 screenshots)</strong></summary>
<br>

<div align="center">

| <a href="screenshots/1.jpg" target="_blank"><img src="screenshots/1.jpg" alt="Main Menu" width="250"/></a> | <a href="screenshots/2.jpg" target="_blank"><img src="screenshots/2.jpg" alt="Warp Selection" width="250"/></a> |
|:--:|:--:|
| **📋 Main Menu** | **🌍 Warp Selection** |

| <a href="screenshots/3.jpg" target="_blank"><img src="screenshots/3.jpg" alt="Create Warp" width="250"/></a> | <a href="screenshots/4.jpg" target="_blank"><img src="screenshots/4.jpg" alt="Delete Warp" width="250"/></a> |
|:--:|:--:|
| **✨ Create Warp** | **🗑️ Delete Warp** |

| <a href="screenshots/5.jpg" target="_blank"><img src="screenshots/5.jpg" alt="Teleport Effect" width="250"/></a> |
|:--:|
| **🚀 Teleport Effect** |

> 💡 Click on any image to view full size

</div>
</details>

---

## 📖 Overview

**WarpUI** provides an intuitive **UI-driven warp system** for your Minecraft Bedrock server. Players can create, delete, and teleport to warps through elegant forms — no need to memorize commands.

Key features include:
- 🖥️ Interactive **SimpleForm** warp list
- ⚙️ **CustomForm** for creating/deleting warps
- 🔔 **Title & Message** customization per warp
- 🔊 **EndermanTeleportSound** effect on teleport

---

## ✨ Features

| Feature | Description |
|--------|------------|
| 🖥️ **Form UI** | All warp actions via interactive menus |
| ⚡ **Lightning Fast** | Optimized for high-performance servers |
| 🔐 **Permission Nodes** | Granular control with `plugin.yml` |
| 📁 **Persistent Storage** | YAML-based warp data |
| 🎨 **Customizable** | Configurable titles, messages, icons |
| 🔊 **Sound Effects** | EndermanTeleportSound on warp |

---

## 📥 Installation

1. Download the latest `WarpUI.phar` from [**Releases**](https://github.com/PM-haedarXD/WarpUI/releases)
2. Place the `.phar` into your server's **`plugins/`** folder
3. Start your server
4. 🎉 **Done!**

> ⚠️ **Requirement:** This plugin depends on [**libFormAPI**](https://github.com/jojoe77777/FormAPI). Make sure it's installed on your server.

---

## 🔧 Commands & Permissions

| Command | Description | Permission |
|--------|-------------|-----------|
| `/warp` | Open the warp selection menu | `warpui.use` |
| `/setwarp` | Open the create warp form | `warpui.create` |
| `/delwarp` | Open the delete warp form | `warpui.delete` |

### Permission Nodes

```yaml
permissions:
  warpui.use:
    description: "Use /warp command"
    default: true
  warpui.create:
    description: "Use /setwarp command"
    default: op
  warpui.delete:
    description: "Use /delwarp command"
    default: op
```

---

⚙️ Configuration

```yaml
# config.yml
warp-menu-title: "Warps"              # Title of the main warp menu
warp-icon: "textures/items/compass"   # Button icon for warps
```

---

📂 Data Storage

Warps are stored in plugin_data/WarpUI/warps.yml:

```yaml
Lobby:
  x: 100
  y: 64
  z: 200
  level: "world"
  title: "Welcome to Lobby!"
  title_enabled: true
  message: "Have a great time!"
  message_enabled: true
```

---

🧠 Full Source Code

<details>
<summary><strong>📄 Click to expand — WarpUI.php</strong></summary>
<br>

```php
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
```

</details>

---

🔧 Troubleshooting & Common Errors

<details>
<summary><strong>🔴 libFormAPI not found</strong></summary>
<br>

Error:

```
Class "jojoe77777\FormAPI\SimpleForm" not found
```

Fix:

· Download libFormAPI and place it in your plugins/ folder
· Make sure it's loaded before WarpUI (restart server)

</details>

<details>
<summary><strong>🔴 Permission denied for /setwarp or /delwarp</strong></summary>
<br>

Issue: Non-OP players cannot use the commands

Fix:

· Grant OP status: /op <player>
· Or set permissions via a permissions plugin (PurePerms, etc.)

</details>

<details>
<summary><strong>🔴 Warps not saving after restart</strong></summary>
<br>

Cause: plugin_data/WarpUI/warps.yml not writable

Fix:

· Ensure folder permissions allow writing
· Check if @mkdir succeeded

</details>

---

🏗️ Technical Stack

Technology Usage
PHP 8.0+ Core logic
PocketMine-MP 5.0.0 Plugin framework
libFormAPI 2.1.1 UI rendering
YAML Data storage

---

📁 Project Structure

```
WarpUI/
├── plugin.yml              # Plugin manifest
├── resources/
│   └── config.yml          # Default configuration
├── screenshots/            # Gallery images
│   ├── 1.jpg
│   ├── 2.jpg
│   ├── 3.jpg
│   ├── 4.jpg
│   └── 5.jpg
└── src/
    └── haedarXD/
        └── WarpUI.php      # Main plugin class
```

---

👤 Author

haedarXD — GitHub

📧 Found a bug? Open an issue

---

📜 License

This project is open-sourced under the MIT License.

---

<div align="center">
  <sub>❤️ Made with love for the PocketMine community</sub>
</div>
```

---

🚀 آپلود کن

همین الآن با nano بازش کن و جایگزین کن:

```bash
nano README.md
```

(قدیمیه رو پاک کن، اینو paste کن، CTRL+X → Y → Enter)

بعد Push:

```bash
git add README.md
git commit -m "Professional README with gallery & code"
git push origin main
```
