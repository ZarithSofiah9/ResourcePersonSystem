<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Appointment Entity
 *
 * @property int $id
 * @property int $lecturer_id
 * @property int $subject_id
 * @property int $semester_id
 * @property \Cake\I18n\Date $date
 * @property string $location
 * @property int $status
 * @property \Cake\I18n\Date $start_date
 * @property \Cake\I18n\Date $end_date
 * @property string $reference_no
 * @property string $approval_no
 * @property string $approval_name
 * @property string $approval_post
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Lecturer $lecturer
 * @property \App\Model\Entity\Subject $subject
 * @property \App\Model\Entity\Semester $semester
 */
class Appointment extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'lecturer_id' => true,
        'subject_id' => true,
        'semester_id' => true,
        'date' => true,
        'location' => true,
        'status' => true,
        'start_date' => true,
        'end_date' => true,
        'reference_no' => true,
        'approval_no' => true,
        'approval_name' => true,
        'approval_post' => true,
        'created' => true,
        'modified' => true,
        'lecturer' => true,
        'subject' => true,
        'semester' => true,
        'approval_status' => true
    ];
}
