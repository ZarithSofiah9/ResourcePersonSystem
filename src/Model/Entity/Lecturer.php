<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Lecturer Entity
 *
 * @property int $id
 * @property string $salutation
 * @property string $name
 * @property string $staff_no
 * @property string $email
 * @property string $phone
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Appointment[] $appointments
 */
class Lecturer extends Entity
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
        'salutation' => true,
        'name' => true,
        'staff_no' => true,
        'email' => true,
        'phone' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'appointments' => true,
    ];
}
