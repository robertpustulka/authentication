<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         1.0.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Authentication\Identity;

use Authentication\Identity;
use Authentication\IdentityInterface;

class DefaultIdentityFactory implements IdentityFactoryInterface
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * Constructor.
     *
     * @param array $config Config.
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * {@inheritDoc}
     */
    public function create($data): IdentityInterface
    {
        return new Identity($data, $this->config);
    }
}