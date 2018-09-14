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
namespace Authentication\Test\TestCase\Identifier\Resolver;

use Authentication\Identifier\Resolver\DoctrineResolver;
use Authentication\Test\TestCase\AuthenticationTestCase;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use TestApp\Doctrine\User;

class DoctrineResolverTest extends AuthenticationTestCase
{
    protected $repository;


    public function setUp()
    {
        parent::setUp();

        $config = Setup::createAnnotationMetadataConfiguration(array(ROOT . 'TestApp/Doctrine'), true);
        $dbalConfig = new Configuration();
        $connectionParams = [
            'url' => env('db_dsn'),
        ];

        $conn = DriverManager::getConnection($connectionParams, $dbalConfig);

        $this->repository = EntityManager::create($conn, $config)->getRepository(User::class);
    }

    public function testFind()
    {
        $resolver = new DoctrineResolver($this->repository);

        $user = $resolver->find([
            'username' => 'mariano'
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('mariano', $user['username']);
    }

    public function testFindConditions()
    {
        $resolver = new DoctrineResolver($this->repository, [
            'id' => 1,
        ]);

        $user = $resolver->find([
            'username' => 'mariano'
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('mariano', $user['username']);
    }

    public function testFindConditionsMissing()
    {
        $resolver = new DoctrineResolver($this->repository, [
            'id' => 2,
        ]);

        $user = $resolver->find([
            'username' => 'mariano'
        ]);

        $this->assertNull($user);
    }

    public function testFindMissing()
    {
        $resolver = new DoctrineResolver($this->repository);

        $user = $resolver->find([
            'id' => 1,
            'username' => 'luigiano'
        ]);

        $this->assertNull($user);
    }

    public function testFindMultipleValues()
    {
        $resolver = new DoctrineResolver($this->repository);

        $user = $resolver->find([
            'username' => [
                'luigiano',
                'mariano'
            ]
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals(1, $user['id']);
    }
}
