<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AppointmentsFixture
 */
class AppointmentsFixture extends TestFixture
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
                'lecturer_id' => 1,
                'subject_id' => 1,
                'semester_id' => 1,
                'date' => '2025-05-18',
                'location' => 'Lorem ipsum dolor sit amet',
                'status' => 1,
                'start_date' => '2025-05-18',
                'end_date' => '2025-05-18',
                'reference_no' => 'Lorem ipsum dolor sit amet',
                'approval_no' => 'Lorem ipsum dolor sit amet',
                'approval_name' => 'Lorem ipsum dolor sit amet',
                'approval_post' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-05-18 15:01:56',
                'modified' => '2025-05-18 15:01:56',
            ],
        ];
        parent::init();
    }
}
