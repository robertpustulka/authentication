<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Authentication\PasswordHasher;

/**
 * Default password hashing class.
 */
class DefaultPasswordHasher extends AbstractPasswordHasher
{

    /**
     * Default config for this object.
     *
     * ### Options
     *
     * - `hashType` - Hashing algo to use. Valid values are those supported by `$algo`
     *   argument of `password_hash()`. Defaults to `PASSWORD_DEFAULT`
     * - `hashOptions` - Associative array of options. Check the PHP manual for
     *   supported options for each hash type. Defaults to empty array.
     *
     * @var array
     */
    protected $defaultConfig = [
        'hashType' => PASSWORD_DEFAULT,
        'hashOptions' => []
    ];

    /**
     * Generates password hash.
     *
     * @param string $password Plain text password to hash.
     * @return bool|string Password hash or false on failure.
     */
    public function hash($password)
    {
        return password_hash(
            $password,
            $this->config['hashType'],
            $this->config['hashOptions']
        );
    }

    /**
     * Check hash. Generate hash for user provided password and check against existing hash.
     *
     * @param string $password Plain text password to hash.
     * @param string $hashedPassword Existing hashed password.
     * @return bool True if hashes match else false.
     */
    public function check($password, $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
    }

    /**
     * Returns true if the password need to be rehashed, due to the password being
     * created with anything else than the passwords generated by this class.
     *
     * @param string $password The password to verify
     * @return bool
     */
    public function needsRehash($password)
    {
        return password_needs_rehash($password, $this->config['hashType'], $this->config['hashOptions']);
    }
}
