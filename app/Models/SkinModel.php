<?php

/*
 * This file is part of Jitamin.
 *
 * Copyright (C) 2016 Jitamin Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jitamin\Model;

use Jitamin\Core\Database\Model;

/**
 * Class Skin.
 */
class SkinModel extends Model
{
    /**
     * Get available skins.
     *
     * @param bool $prepend Prepend a default value
     *
     * @return array
     */
    public function getSkins($prepend = false)
    {
        // Sorted by value
        $skins = [
            'default' => t('Default'),
            'blue'    => t('Blue'),
            'green'   => t('Green'),
            'purple'  => t('Purple'),
            'red'     => t('Red'),
            'white'   => t('White'),
            'yellow'  => t('Yellow'),
        ];

        if ($prepend) {
            return ['' => t('Use system skin')] + $skins;
        }

        return $skins;
    }

    /**
     * Get current skin.
     *
     * @return string
     */
    public function getCurrentSkin()
    {
        if ($this->userSession->isLogged() && !empty($this->sessionStorage->user['skin'])) {
            return $this->sessionStorage->user['skin'];
        }

        return $this->settingModel->get('application_skin', 'default');
    }
}
