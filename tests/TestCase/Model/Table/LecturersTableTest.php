<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LecturersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LecturersTable Test Case
 */
class LecturersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LecturersTable
     */
    protected $Lecturers;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Lecturers',
        'app.Appointments',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Lecturers') ? [] : ['className' => LecturersTable::class];
        $this->Lecturers = $this->getTableLocator()->get('Lecturers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Lecturers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\LecturersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
