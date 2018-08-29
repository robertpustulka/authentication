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
namespace Authentication\Identifier;

use Authentication\Identifier\Resolver\ResolverInterface;

/**
 * Token Identifier
 */
class TokenIdentifier extends AbstractIdentifier
{

    /**
     * Resolver
     *
     * @var \Authentication\Identifier\Resolver\ResolverInterface
     */
    protected $resolver;

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $defaultConfig = [
        'tokenField' => 'token',
        'dataField' => self::CREDENTIAL_TOKEN,
    ];

    /**
     * Configuration
     *
     * @var array
     */
    protected $config = [];

    /**
     * Constructor
     *
     * @param array $config Configuration
     */
    public function __construct(ResolverInterface $resolver, array $config = [])
    {
        $this->config = array_merge($this->defaultConfig, $config);
        $this->resolver = $resolver;
    }

    /**
     * {@inheritDoc}
     */
    public function identify(array $data)
    {
        $dataField = $this->config['dataField'];
        if (!isset($data[$dataField])) {
            return null;
        }

        $conditions = [
            $this->config['tokenField'] => $data[$dataField]
        ];

        return $this->resolver->find($conditions);
    }
}
