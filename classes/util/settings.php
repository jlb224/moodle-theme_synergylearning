<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Theme helper to load a theme configuration.
 *
 * @package    theme_synergylearning
 * @copyright  2022 Willian Mano
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_synergylearning\util;

use theme_config;
use moodle_url;

/**
 * Helper to load theme configuration.
 *
 * @package    theme_synergylearning
 * @copyright  2022 Willian Mano
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class settings {
    /**
     * @var \stdClass $theme The theme object.
     */
    protected $theme;
    /**
     * @var array $files Theme file settings.
     */
    protected $files = [
        'footerlogo'
    ];

    /**
     * Class constructor
     */
    public function __construct() {
        $this->theme = theme_config::load('synergylearning');
    }

    /**
     * Get theme settings
     *
     * @param string $name
     *
     * @return false|string|null
     */
    public function __get(string $name) {
        if (in_array($name, $this->files)) {
            return $this->theme->setting_file_url($name, $name);
        }

        if (empty($this->theme->settings->$name)) {
            return false;
        }

        return $this->theme->settings->$name;
    }

    /**
     * Get footer settings
     *
     * @return array
     */
    public function footer() {
        global $CFG;

        $templatecontext = [];

        $settings = [
            'footerlogo', 'copyright'
        ];

        foreach ($settings as $setting) {
            $templatecontext[$setting] = $this->$setting;
        }

        if (!empty($templatecontext['copyright'])) {
            $templatecontext['copyright'] = '&copy;' . $templatecontext['copyright'];
        }

        return $templatecontext;
    }
}

