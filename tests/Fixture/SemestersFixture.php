<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SemestersFixture
 */
class SemestersFixture extends TestFixture
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
                'code' => 'Lorem ip',
                'name' => 'Lorem ipsum dolor sit amet',
                'status' => 1,
                'created' => '2025-05-18 15:02:30',
                'modified' => '2025-05-18 15:02:30',
            ],
        ];
        parent::init();
    }
}
