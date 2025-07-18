<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Lecturers Model
 *
 * @property \App\Model\Table\AppointmentsTable&\Cake\ORM\Association\HasMany $Appointments
 *
 * @method \App\Model\Entity\Lecturer newEmptyEntity()
 * @method \App\Model\Entity\Lecturer newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Lecturer> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Lecturer get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Lecturer findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Lecturer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Lecturer> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Lecturer|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Lecturer saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Lecturer>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Lecturer>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Lecturer>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Lecturer> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Lecturer>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Lecturer>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Lecturer>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Lecturer> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LecturersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('lecturers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Appointments', [
            'foreignKey' => 'lecturer_id',
        ]);
		$this->addBehavior('AuditStash.AuditLog');
		$this->addBehavior('Search.Search');
		$this->searchManager()
			->value('id')
            ->value('name')
            ->value('staff_no')
            ->value('status')
				->add('search', 'Search.Like', [
					//'before' => true,
					//'after' => true,
					'fieldMode' => 'OR',
					'multiValue' => true,
					'multiValueSeparator' => '|',
					'comparison' => 'LIKE',
					'wildcardAny' => '*',
					'wildcardOne' => '?',
					'fields' => ['id'],
				]);

        $this->searchManager()
            ->add('status', 'Search.Value', [
                'multiValue' => true,
                'fields' => 'status'
            ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        // $validator
        //     ->scalar('salutation')
        //     ->maxLength('salutation', 50)
        //     ->requirePresence('salutation', 'create')
        //     ->notEmptyString('salutation');

        // $validator
        //     ->scalar('name')
        //     ->maxLength('name', 50)
        //     ->requirePresence('name', 'create')
        //     ->notEmptyString('name');

        // $validator
        //     ->scalar('staff_no')
        //     ->maxLength('staff_no', 10)
        //     ->requirePresence('staff_no', 'create')
        //     ->notEmptyString('staff_no');

        // $validator
        //     ->email('email')
        //     ->requirePresence('email', 'create')
        //     ->notEmptyString('email');

        // $validator
        //     ->scalar('phone')
        //     ->maxLength('phone', 15)
        //     ->requirePresence('phone', 'create')
        //     ->notEmptyString('phone');

        $validator
            ->integer('status')
            ->notEmptyString('status');

        return $validator;
    }
}
