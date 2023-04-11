# Craft volume filetypes plugin for Craft CMS 3.x

Decide what filetypes are allowed per volume.

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1.  Add a personal access token in the COMPOSER_AUTH env variable of the project (usually docker-compose) (If you have already done this, you can skip this step)

        COMPOSER_AUTH='{"gitlab-token":{"gitlab.born05.com":"<gitlab_personal_access_token>"}}'

2.  Merge the repo in your composer.json
        "repositories": [
            {
                "type": "composer",
                "url": "https://gitlab.born05.com/api/v4/group/99/-/packages/composer/packages.json"
            }
        ],

3. Then tell Composer to load the plugin:

        composer require born05/craft-volume-filetypes

4. In the Control Panel, go to Settings → Plugins and click the “Install” button for Craft volume filetypes.


Brought to you by [Born05](https://born05.com)
