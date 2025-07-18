<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LecturersFixture
 */
class LecturersFixture extends TestFixture
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
                'salutation' => 'Lorem ipsum dolor sit amet',
                'name' => 'Lorem ipsum dolor sit amet',
                'staff_no' => 'Lorem ip',
                'email' => 'Lorem ipsum dolor sit amet',
                'phone' => 'Lorem ipsum d',
                'created' => '2025-05-18 15:02:14',
                'modified' => '2025-05-18 15:02:14',
            ],
        ];
        parent::init();
    }
}
