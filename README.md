<div align="center">

<img src="https://raw.githubusercontent.com/PM-haedarXD/WarpUI/main/icon.png" width="120" style="border-radius: 20px; box-shadow: 0 0 30px rgba(0,0,0,0.3);">

# ⚡ WarpUI

<p><em>A pixel-perfect warp management experience for PocketMine-MP</em></p>

<p>
  <img src="https://img.shields.io/github/downloads/PM-haedarXD/WarpUI/total?style=for-the-badge&logo=github&color=blueviolet" alt="Downloads">
  <img src="https://img.shields.io/github/stars/PM-haedarXD/WarpUI?style=for-the-badge&logo=github&color=yellow" alt="Stars">
  <img src="https://img.shields.io/github/license/PM-haedarXD/WarpUI?style=for-the-badge&color=success" alt="License">
</p>

<p>
  <img src="https://img.shields.io/badge/Made_with-❤️-red?style=for-the-badge&logo=heart" alt="Made with love">
  <img src="https://img.shields.io/badge/Code-PHP-777bb3?style=for-the-badge&logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/Game-Minecraft-62b47a?style=for-the-badge&logo=minecraft" alt="Minecraft">
  <img src="https://img.shields.io/badge/API-5.0.0-fb8c00?style=for-the-badge" alt="API">
</p>

</div>

---

## 📸 Gallery

<p align="center"><em>Click any image to view full size</em></p>

<p align="center">
  <a href="screenshots/1.jpg"><img src="screenshots/1.jpg" width="180" style="border-radius:12px; margin:5px;" alt="Main Menu"></a>
  <a href="screenshots/2.jpg"><img src="screenshots/2.jpg" width="180" style="border-radius:12px; margin:5px;" alt="Warp List"></a>
  <a href="screenshots/3.jpg"><img src="screenshots/3.jpg" width="180" style="border-radius:12px; margin:5px;" alt="Create Warp"></a>
  <a href="screenshots/4.jpg"><img src="screenshots/4.jpg" width="180" style="border-radius:12px; margin:5px;" alt="Delete Warp"></a>
  <a href="screenshots/5.jpg"><img src="screenshots/5.jpg" width="180" style="border-radius:12px; margin:5px;" alt="Teleport Effect"></a>
</p>

<p align="center">
  📋 Main Menu &nbsp;|&nbsp;
  🌍 Warp List &nbsp;|&nbsp;
  ✨ Create &nbsp;|&nbsp;
  🗑️ Delete &nbsp;|&nbsp;
  🚀 Effect
</p>

---

## 📖 Overview

> **WarpUI** transforms the clunky command-based warp system into a **beautiful UI experience**. No more typing long commands — just click, select, and teleport.

| Form Type | Function | Style |
|:---------:|:--------:|:-----:|
| SimpleForm | Warp list | Gradient buttons |
| CustomForm | Create Warp | Toggle + Input |
| CustomForm | Delete Warp | Dropdown select |

### 🧠 Architecture

<pre>
Player
  │
  ├── /warp ────> SimpleForm (Warp List) ──> Teleport + Sound + Title
  │
  ├── /setwarp ─> CustomForm (Create) ──────> Save to warps.yml
  │
  └── /delwarp ─> CustomForm (Delete) ──────> Remove from warps.yml
</pre>

---

## 🧬 Core Methods

<strong>onEnable(): void</strong><br>
Initializes the plugin. Creates data folder if missing, loads config.yml, and sets up warps.yml storage.

<strong>onCommand(CommandSender $sender, Command $command, string $label, array $args): bool</strong><br>
Command router. Returns false for console senders. Routes /warp, /setwarp, and /delwarp to their respective form methods.

<strong>showWarpUI(Player $player): void</strong><br>
Builds a SimpleForm listing all warps as buttons. On click: validates warp exists → loads world → teleports player → sends title + message + EndermanTeleportSound.

<strong>showSetWarpForm(Player $player): void</strong><br>
Builds a CustomForm with inputs for warp name, title toggle/text, and message toggle/text. Saves warp data including coordinates and world to warps.yml.

<strong>showDelWarpForm(Player $player): void</strong><br>
Builds a CustomForm with a dropdown of existing warps. On submit, removes selected warp from warps.yml. Shows error if no warps exist.

---

## ✨ Features

| Category | Detail |
|---------|--------|
| 🖥️ GUI | SimpleForm + CustomForm via libFormAPI |
| ⚡ Performance | Direct world lookup, no loops |
| 🔐 Permissions | 3 nodes: use, create, delete |
| 💾 Storage | YAML flat file (warps.yml) |
| 🔊 Sound | EndermanTeleportSound on teleport |
| 📝 Title | Per-warp customizable title screen |
| 💬 Message | Per-warp customizable chat message |
| 🛡️ Validation | Empty name check, duplicate prevention, world existence |

---

## 📥 Installation

| Step | Action |
|:---:|--------|
| 1 | Download from <a href="https://github.com/PM-haedarXD/WarpUI/releases">Releases</a> |
| 2 | Place WarpUI.phar in plugins/ |
| 3 | Ensure <a href="https://github.com/jojoe77777/FormAPI">libFormAPI</a> is installed |
| 4 | Restart server |

---

## 🔧 Commands & Permissions

| Command | Permission | Default |
|---------|-----------|:-------:|
| /warp | warpui.use | Everyone |
| /setwarp | warpui.create | OP only |
| /delwarp | warpui.delete | OP only |

<details>
<summary><strong>📄 plugin.yml Permission Nodes</strong></summary>
<br>
<pre>
permissions:
  warpui.use:
    description: "Access /warp menu"
    default: true
  warpui.create:
    description: "Create warps"
    default: op
  warpui.delete:
    description: "Delete warps"
    default: op
</pre>
</details>

---

## ⚙️ Configuration

<pre>
# config.yml — generated on first run

warp-menu-title: "Warps"
warp-icon: "textures/items/compass"
</pre>

> 💡 Change warp-icon to any Minecraft texture path or leave as default.

---

## 💾 Data Format

<pre>
Hub:
  x: 0.0
  y: 100.0
  z: 0.0
  level: world
  title: "§aWelcome!"
  title_enabled: true
  message: "§eYou have arrived at Hub!"
  message_enabled: true
</pre>

| Field | Type | Description |
|------|:----:|------------|
| x,y,z | float | Coordinates |
| level | string | World folder name |
| title | string | Title screen text |
| title_enabled | bool | Show title? |
| message | string | Chat message |
| message_enabled | bool | Show message? |

---

## 🔧 Troubleshooting

<strong>🔴 Class FormAPI not found</strong><br>
→ Install <a href="https://github.com/jojoe77777/FormAPI">libFormAPI</a> in plugins folder and restart.

<strong>🔴 No warps to delete</strong><br>
→ Create at least one warp with /setwarp first.

<strong>🔴 Teleport fails silently</strong><br>
→ Verify world is loaded and warps.yml coordinates are valid.

---

## 📁 Project Structure

<pre>
WarpUI/
├── plugin.yml
├── resources/
│   └── config.yml
├── screenshots/
│   ├── 1.jpg
│   ├── 2.jpg
│   ├── 3.jpg
│   ├── 4.jpg
│   └── 5.jpg
└── src/
    └── haedarXD/
        └── WarpUI.php
</pre>

---

## 👤 Author

<div align="center">

<img src="https://github.com/PM-haedarXD.png" width="80" style="border-radius: 50%;">

### haedarXD

<a href="https://github.com/PM-haedarXD"><img src="https://img.shields.io/badge/GitHub-PM--haedarXD-24292e?style=flat-square&logo=github" alt="GitHub"></a>

📧 <a href="https://github.com/PM-haedarXD/WarpUI/issues">Report Bug</a> • 💡 <a href="https://github.com/PM-haedarXD/WarpUI/issues">Feature Request</a>

</div>

---

## 📜 License

<div align="center">

MIT — Free to use, modify, and distribute.

<img src="https://img.shields.io/badge/License-MIT-yellow.svg" alt="License: MIT">

</div>
