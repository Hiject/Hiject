<?php

/*
 * This file is part of Hiject.
 *
 * Copyright (C) 2016 Hiject Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Hiject\Validator;

use SimpleValidator\Validator;
use SimpleValidator\Validators;
use Gregwar\Captcha\CaptchaBuilder;

/**
 * Authentication Validator
 */
class AuthValidator extends BaseValidator
{
    /**
     * Validate user login form
     *
     * @access public
     * @param  array   $values           Form values
     * @return array   $valid, $errors   [0] = Success or not, [1] = List of errors
     */
    public function validateForm(array $values)
    {
        return $this->executeValidators(['validateFields', 'validateLocking', 'validateCaptcha', 'validateCredentials'], $values);
    }

    /**
     * Validate credentials syntax
     *
     * @access protected
     * @param  array   $values           Form values
     * @return array   $valid, $errors   [0] = Success or not, [1] = List of errors
     */
    protected function validateFields(array $values)
    {
        $v = new Validator($values, [
            new Validators\Required('username', t('The username is required')),
            new Validators\MaxLength('username', t('The maximum length is %d characters', 50), 50),
            new Validators\Required('password', t('The password is required')),
        ]);

        return [
            $v->execute(),
            $v->getErrors(),
        ];
    }

    /**
     * Validate user locking
     *
     * @access protected
     * @param  array   $values           Form values
     * @return array   $valid, $errors   [0] = Success or not, [1] = List of errors
     */
    protected function validateLocking(array $values)
    {
        $result = true;
        $errors = [];

        if ($this->userLockingModel->isLocked($values['username'])) {
            $result = false;
            $errors['login'] = t('Your account is locked for %d minutes', BRUTEFORCE_LOCKDOWN_DURATION);
            $this->logger->error('Account locked: '.$values['username']);
        }

        return [$result, $errors];
    }

    /**
     * Validate password syntax
     *
     * @access protected
     * @param  array   $values           Form values
     * @return array   $valid, $errors   [0] = Success or not, [1] = List of errors
     */
    protected function validateCredentials(array $values)
    {
        $result = true;
        $errors = [];

        if (! $this->authenticationManager->passwordAuthentication($values['username'], $values['password'])) {
            $result = false;
            $errors['login'] = t('Bad username or password');
        }

        return [$result, $errors];
    }

    /**
     * Validate captcha
     *
     * @access protected
     * @param  array   $values           Form values
     * @return boolean
     */
    protected function validateCaptcha(array $values)
    {
        $result = true;
        $errors = [];

        if ($this->userLockingModel->hasCaptcha($values['username'])) {
            if (! isset($this->sessionStorage->captcha)) {
                $result = false;
            } else {
                $builder = new CaptchaBuilder;
                $builder->setPhrase($this->sessionStorage->captcha);
                $result = $builder->testPhrase(isset($values['captcha']) ? $values['captcha'] : '');

                if (! $result) {
                    $errors['login'] = t('Invalid captcha');
                }
            }
        }

        return [$result, $errors];
    }
}
