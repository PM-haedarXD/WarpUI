<div align="center">
  <h1>⚡ WarpUI</h1>
  <p><em>A sleek and fast warp management plugin for PocketMine-MP 5.0.0</em></p>
  
  [![PocketMine-MP](https://img.shields.io/badge/PocketMine--MP-5.0.0-fb8c00?style=for-the-badge&logo=github)](https://pmmp.io)
  [![Version](https://img.shields.io/badge/version-1.0.8-blue?style=for-the-badge)](https://github.com/PM-haedarXD/WarpUI)
  [![License](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)](LICENSE)
  [![PHP](https://img.shields.io/badge/PHP-8.0%2B-777bb3?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
</div>

---

## 📸 Screenshots

<div align="center">

### 🖥️ Main Menu & Warp Selection
<img src="screenshots/1.jpg" alt="Main Menu" width="400"/>
<img src="screenshots/2.jpg" alt="Warp Selection" width="400"/>

### ⚙️ Creating & Deleting Warps
<img src="screenshots/3.jpg" alt="Create Warp" width="400"/>
<img src="screenshots/4.jpg" alt="Delete Warp" width="400"/>

### ✨ Teleport Effect
<img src="screenshots/5.jpg" alt="Teleport Effect" width="400"/>

</div>

---

## 📖 Overview

**WarpUI** provides an intuitive **UI-driven warp system** for your Minecraft Bedrock server. Players can create, delete, and teleport to warps through elegant forms — no need to memorize commands.

---

## ✨ Features

- 🖥️ **Form UI** – All warp actions happen through interactive menus
- ⚡ **Lightning Fast** – Optimized for high-performance servers
- 🔐 **Permission Nodes** – Fine-grained control over every action
- 🧩 **Developer Friendly** – Clean, object-oriented codebase
- 📁 **Persistent Storage** – Warps are saved and survive server restarts
- 🌐 **Customizable** – Easy to edit messages and configurations

---

## 📥 Installation

1. Download the latest `WarpUI.phar` from [Releases](https://github.com/PM-haedarXD/WarpUI/releases)
2. Drop the `.phar` file into your server's **`plugins/`** folder
3. Restart your server
4. Done! 🎉

---

## 🔧 Commands & Permissions

| Command | Description | Permission Node |
|--------|-------------|-----------------|
| `/warp` | Open the warp selection menu | `warpui.use` |
| `/setwarp <name>` | Create a new warp at your location | `warpui.create` |
| `/delwarp <name>` | Delete an existing warp | `warpui.delete` |

---

## ⚙️ Configuration

```yaml
# config.yml (auto-generated)
version: "1.0.8"

# Enable/disable sound effects on warp
sound: true

# Cooldown between warps (seconds)
cooldown: 5
