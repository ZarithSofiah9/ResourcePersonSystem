<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SubjectsFixture
 */
class SubjectsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'code' => 'Lorem ip',
                'status' => 1,
                'credit_hour' => 'Lorem ip',
                'created' => '2025-05-18 15:02:22',
                'modified' => '2025-05-18 15:02:22',
            ],
        ];
        parent::init();
    }
}
