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
namespace Authentication\Identifier\Resolver;

use Authentication\Identifier\Resolver\ResolverInterface;
use Doctrine\Common\Persistence\ObjectRepository;

class DoctrineResolver implements ResolverInterface
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $repository;

    /**
     * @var array
     */
    protected $conditions = [];

    /**
     * Constructor.
     *
     * @param \Doctrine\Common\Persistence\ObjectRepository $repository Repository.
     * @param array $conditions Extra conditions.
     */
    public function __construct(ObjectRepository $repository, array $conditions = [])
    {
        $this->repository = $repository;
        $this->conditions = $conditions;
    }

    /**
     * {@inheritDoc}
     */
    public function find(array $conditions)
    {
        return $this->repository->findOneBy($conditions + $this->conditions);
    }
}
