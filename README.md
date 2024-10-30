[contributors-shield]: https://img.shields.io/github/contributors/hassan7303/GF-meta-sync.svg?style=for-the-badge
[contributors-url]: https://github.com/hassan7303/GF-meta-sync/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/hassan7303/GF-meta-sync.svg?style=for-the-badge&label=Fork
[forks-url]: https://github.com/hassan7303/GF-meta-sync/network/members
[stars-shield]: https://img.shields.io/github/stars/hassan7303/GF-meta-sync.svg?style=for-the-badge
[stars-url]: https://github.com/hassan7303/GF-meta-sync/stargazers
[license-shield]: https://img.shields.io/github/license/hassan7303/GF-meta-sync.svg?style=for-the-badge
[license-url]: https://github.com/hassan7303/GF-meta-sync/blob/master/LICENCE.md
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-blue.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://www.linkedin.com/in/hassan-ali-askari-280bb530a/
[telegram-shield]: https://img.shields.io/badge/-Telegram-blue.svg?style=for-the-badge&logo=telegram&colorB=555
[telegram-url]: https://t.me/hassan7303
[instagram-shield]: https://img.shields.io/badge/-Instagram-red.svg?style=for-the-badge&logo=instagram&colorB=555
[instagram-url]: https://www.instagram.com/hasan_ali_askari
[github-shield]: https://img.shields.io/badge/-GitHub-black.svg?style=for-the-badge&logo=github&colorB=555
[github-url]: https://github.com/hassan7303
[email-shield]: https://img.shields.io/badge/-Email-orange.svg?style=for-the-badge&logo=gmail&colorB=555
[email-url]: mailto:hassanali7303@gmail.com

[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![MIT License][license-shield]][license-url]
[![LinkedIn][linkedin-shield]][linkedin-url]
[![Telegram][telegram-shield]][telegram-url]
[![Instagram][instagram-shield]][instagram-url]
[![GitHub][github-shield]][github-url]
[![Email][email-shield]][email-url]


# GF Meta Sync Plugin Documentation

## Overview
The **GF Meta Sync** plugin for WordPress allows admins to configure the plugin via the WordPress admin dashboard, where they can input a specific Gravity Form ID. When a form is submitted, the plugin dynamically syncs phone number data from the form submission to the user’s metadata. This data is saved into the WordPress database for future reference, making it easier to track and manage phone information submitted by users.

---

## Plugin Information

- **Plugin Name**: GF Meta Sync
- **Version**: 1.0.0
- **Author**: Hassan Ali Askari
- **Author URI**: [https://t.me/hassan7303](https://t.me/hassan7303)
- **Plugin URI**: [https://github.com/hassan7303](https://github.com/hassan7303)
- **License**: MIT
- **License URI**: [https://opensource.org/licenses/MIT](https://opensource.org/licenses/MIT)

---

## Features
- Admin panel to input Gravity Form ID.
- Automatically syncs phone number fields from Gravity Forms submissions to user meta data.
- Saves phone number data into the WordPress database under user meta.
- Dynamically detects and stores any field labeled as "phone" in the form submission.

---

## Installation
1. Download or clone the plugin files into your `wp-content/plugins` directory.
2. In the WordPress admin dashboard, navigate to **Plugins** > **Installed Plugins**.
3. Activate the **GF Meta Sync** plugin.

---

## Admin Settings
Once activated, a new menu item **GF Meta Sync** will appear in the WordPress admin dashboard. Follow these steps to configure the plugin:

1. Navigate to **GF Meta Sync** under the admin menu.
2. Enter the **Gravity Form ID** that you wish to sync phone data from.
3. Click **Save Changes**.

---

## Usage

1. The plugin listens for Gravity Forms submissions.
2. Upon form submission, if the form ID matches the one configured in the admin panel, the plugin will:
   - Search for fields in the form labeled "phone" or containing "phone" in their keys.
   - Save the phone number data into the current user's metadata.

---

## Code Details

### Admin Menu and Settings

The plugin adds a menu page in the WordPress admin dashboard where you can input and save a specific **Gravity Form ID**.

- **Menu Function**: `gf_meta_sync_menu()`  
  This function creates the **GF Meta Sync** admin menu page.

- **Settings Page**: `gf_meta_sync_page()`  
  Renders the settings page for entering the **Gravity Form ID**.

- **Settings Initialization**: `gf_meta_sync_settings_init()`  
  Registers the settings fields, including the form ID field, which is saved in the WordPress options table.

---

### Syncing Gravity Form Data

The plugin dynamically syncs phone-related data from a Gravity Form submission:

- **Function**: `save_seller_phone_info()`  
  This function is hooked into the `gform_after_submission` action, listening for Gravity Forms submissions. It checks if the form ID matches the one saved in the admin settings, searches for phone fields in the form, and updates the user meta with the phone number data.


### Helper

convert persian phone to en phone

```
/**
 * convert persian phone to en phone
 * 
 * @param string $string
 * 
 * @return string
 */
function convert(string $string):string

```

---



