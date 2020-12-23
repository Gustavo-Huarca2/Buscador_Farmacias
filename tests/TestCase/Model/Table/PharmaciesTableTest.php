<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PharmaciesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PharmaciesTable Test Case
 */
class PharmaciesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PharmaciesTable
     */
    protected $Pharmacies;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Pharmacies',
        'app.Users',
        'app.Comments',
        'app.Products',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Pharmacies') ? [] : ['className' => PharmaciesTable::class];
        $this->Pharmacies = $this->getTableLocator()->get('Pharmacies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Pharmacies);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
