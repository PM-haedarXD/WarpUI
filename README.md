<div align="center">

<img src="https://raw.githubusercontent.com/PM-haedarXD/WarpUI/main/icon.png" width="120" style="border-radius: 20px; box-shadow: 0 0 30px rgba(0,0,0,0.3);" />

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

<div align="center">
<p><em>Click on any image to open it right here</em></p>
</div>

<div align="center">

| <a href="#modal1"><img src="screenshots/1.jpg" alt="Main Menu" width="200" style="border-radius: 12px;"></a> | <a href="#modal2"><img src="screenshots/2.jpg" alt="Warp List" width="200" style="border-radius: 12px;"></a> | <a href="#modal3"><img src="screenshots/3.jpg" alt="Create Warp" width="200" style="border-radius: 12px;"></a> | <a href="#modal4"><img src="screenshots/4.jpg" alt="Delete Warp" width="200" style="border-radius: 12px;"></a> | <a href="#modal5"><img src="screenshots/5.jpg" alt="Teleport Effect" width="200" style="border-radius: 12px;"></a> |
|:---:|:---:|:---:|:---:|:---:|
| 📋 Main Menu | 🌍 Warp List | ✨ Create | 🗑️ Delete | 🚀 Effect |

</div>

<div class="modal" id="modal1" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.95); z-index:9999; text-align:center; padding-top:20px;">
  <a href="#" style="position:fixed; top:20px; right:30px; color:#fff; font-size:40px; text-decoration:none;">&times;</a>
  <img src="screenshots/1.jpg" style="max-width:95%; max-height:85%; border-radius:20px; margin-top:30px;">
  <p style="color:#8b949e; margin-top:20px;">📋 Main Menu — Clean warp selection interface</p>
</div>

<div class="modal" id="modal2" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.95); z-index:9999; text-align:center; padding-top:20px;">
  <a href="#" style="position:fixed; top:20px; right:30px; color:#fff; font-size:40px; text-decoration:none;">&times;</a>
  <img src="screenshots/2.jpg" style="max-width:95%; max-height:85%; border-radius:20px; margin-top:30px;">
  <p style="color:#8b949e; margin-top:20px;">🌍 Warp List — All warps at a glance</p>
</div>

<div class="modal" id="modal3" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.95); z-index:9999; text-align:center; padding-top:20px;">
  <a href="#" style="position:fixed; top:20px; right:30px; color:#fff; font-size:40px; text-decoration:none;">&times;</a>
  <img src="screenshots/3.jpg" style="max-width:95%; max-height:85%; border-radius:20px; margin-top:30px;">
  <p style="color:#8b949e; margin-top:20px;">✨ Create Warp — Customizable titles & messages</p>
</div>

<div class="modal" id="modal4" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.95); z-index:9999; text-align:center; padding-top:20px;">
  <a href="#" style="position:fixed; top:20px; right:30px; color:#fff; font-size:40px; text-decoration:none;">&times;</a>
  <img src="screenshots/4.jpg" style="max-width:95%; max-height:85%; border-radius:20px; margin-top:30px;">
  <p style="color:#8b949e; margin-top:20px;">🗑️ Delete Warp — Easy dropdown selection</p>
</div>

<div class="modal" id="modal5" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.95); z-index:9999; text-align:center; padding-top:20px;">
  <a href="#" style="position:fixed; top:20px; right:30px; color:#fff; font-size:40px; text-decoration:none;">&times;</a>
  <img src="screenshots/5.jpg" style="max-width:95%; max-height:85%; border-radius:20px; margin-top:30px;">
  <p style="color:#8b949e; margin-top:20px;">🚀 Teleport Effect — Smooth sounds & titles</p>
</div>

## 📖 Overview

> **WarpUI** transforms the clunky command-based warp system into a **beautiful UI experience**. No more typing long commands — just click, select, and teleport.

| Form Type | Function | Style |
|:---------:|:--------:|:-----:|
| `SimpleForm` | Warp list | Gradient buttons |
| `CustomForm` | Create Warp | Toggle + Input |
| `CustomForm` | Delete Warp | Dropdown select |

### 🧠 Architecture

graph LR
    A[Player] -->|/warp| B[SimpleForm]
    A -->|/setwarp| C[CustomForm: Create]
    A -->|/delwarp| D[CustomForm: Delete]
    B --> E[Teleport + Sound + Title]
    C --> F[Save to YAML]
    D --> G[Remove from YAML]

## 🧬 Core Methods

### `onEnable()`
Initializes the plugin. Creates data folder if missing, loads `config.yml`, and sets up `warps.yml` storage.

### `onCommand(CommandSender $sender, Command $command, string $label, array $args): bool`
Command router. Returns false for console senders. Routes `/warp`, `/setwarp`, and `/delwarp` to their respective form methods.

### `showWarpUI(Player $player): void`
Builds a `SimpleForm` listing all warps as buttons. On click: validates warp exists → loads world → teleports player → sends title + message + EndermanTeleportSound.

### `showSetWarpForm(Player $player): void`
Builds a `CustomForm` with inputs for warp name, title toggle/text, and message toggle/text. Saves warp data including coordinates and world to `warps.yml`.

### `showDelWarpForm(Player $player): void`
Builds a `CustomForm` with a dropdown of existing warps. On submit, removes selected warp from `warps.yml`. Shows error if no warps exist.

## ✨ Features

| Category | Detail |
|---------|--------|
| 🖥️ GUI | SimpleForm + CustomForm via libFormAPI |
| ⚡ Performance | Direct world lookup, no loops |
| 🔐 Permissions | 3 nodes: `use`, `create`, `delete` |
| 💾 Storage | YAML flat file (`warps.yml`) |
| 🔊 Sound | EndermanTeleportSound on teleport |
| 📝 Title | Per-warp customizable title screen |
| 💬 Message | Per-warp customizable chat message |
| 🛡️ Validation | Empty name check, duplicate prevention, world existence |

## 📥 Installation

| Step | Action |
|:---:|--------|
| 1 | Download from [Releases](https://github.com/PM-haedarXD/WarpUI/releases) |
| 2 | Place `WarpUI.phar` in `plugins/` |
| 3 | Ensure [libFormAPI](https://github.com/jojoe77777/FormAPI) is installed |
| 4 | Restart server |


## 🔧 Commands & Permissions

| Command | Permission | Default |
|---------|-----------|:-------:|
| `/warp` | `warpui.use` | Everyone |
| `/setwarp` | `warpui.create` | OP only |
| `/delwarp` | `warpui.delete` | OP only |

## ⚙️ Configuration

warp-menu-title: "Warps"
warp-icon: "textures/items/compass"


## 💾 Data Format

Hub:
  x: 0.0
  y: 100.0
  z: 0.0
  level: world
  title: "§aWelcome!"
  title_enabled: true
  message: "§eYou have arrived at Hub!"
  message_enabled: true

## 🔧 Troubleshooting

**🔴 Class FormAPI not found**
→ Install [libFormAPI](https://github.com/jojoe77777/FormAPI) in plugins folder.

**🔴 No warps to delete**
→ Create at least one warp with `/setwarp` first.

**🔴 Teleport fails silently**
→ Verify world is loaded and `warps.yml` coordinates are valid.


## 📁 Project Structure

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


## 👤 Author

<div align="center">

<img src="https://github.com/PM-haedarXD.png" width="80" style="border-radius: 50%;" />

### haedarXD

[![GitHub](https://img.shields.io/badge/GitHub-PM--haedarXD-24292e?style=flat-square&logo=github)](https://github.com/PM-haedarXD)

</div>

## 📜 License

MIT — Free to use, modify, and distribute.

<div align="center">
  <sub>Made with ❤️ for the PocketMine community</sub>
</div>
