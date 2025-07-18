<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Appointments Model
 *
 * @property \App\Model\Table\LecturersTable&\Cake\ORM\Association\BelongsTo $Lecturers
 * @property \App\Model\Table\SubjectsTable&\Cake\ORM\Association\BelongsTo $Subjects
 * @property \App\Model\Table\SemestersTable&\Cake\ORM\Association\BelongsTo $Semesters
 *
 * @method \App\Model\Entity\Appointment newEmptyEntity()
 * @method \App\Model\Entity\Appointment newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Appointment> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Appointment get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Appointment findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Appointment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Appointment> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Appointment|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Appointment saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Appointment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Appointment>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Appointment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Appointment> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Appointment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Appointment>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Appointment>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Appointment> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AppointmentsTable extends Table
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

        $this->setTable('appointments');
        $this->setDisplayField('location');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Lecturers', [
            'foreignKey' => 'lecturer_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Subjects', [
            'foreignKey' => 'subject_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Semesters', [
            'foreignKey' => 'semester_id',
            'joinType' => 'INNER',
        ]);
		$this->addBehavior('AuditStash.AuditLog');
		$this->addBehavior('Search.Search');
		$this->searchManager()
        
			->value('id')
            ->value('lecturer_id')
            ->value('subject_id')
            ->value('semester_id')
            ->value('status')
            ->value('start_date')
            ->value('end_date')


				->add('search', 'Search.Like', [
                'fieldMode' => 'OR',
                'multiValue' => true,
                'multiValueSeparator' => '|',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'fields' => ['status'],
            ])

                ->add('start_date_from', 'Search.Compare', [
                    'fields'=>[$this->aliasField('start_date')],
                    'operator' => '>='
                ])
                ->add('end_date_to', 'Search.Compare', [
                'fields'=>[$this->aliasField('end_date')],
                'operator' => '<='
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
        $validator
            ->integer('lecturer_id')
            ->notEmptyString('lecturer_id');

        $validator
            ->integer('subject_id')
            ->notEmptyString('subject_id');

        $validator
            ->integer('semester_id')
            ->notEmptyString('semester_id');

        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

        $validator
            ->scalar('location')
            ->maxLength('location', 255)
            ->requirePresence('location', 'create')
            ->notEmptyString('location');

        $validator
            ->integer('status')
            ->notEmptyString('status');

        $validator
            ->date('start_date')
            ->requirePresence('start_date', 'create')
            ->notEmptyDate('start_date');

        $validator
            ->date('end_date')
            ->requirePresence('end_date', 'create')
            ->notEmptyDate('end_date');

        $validator
            ->scalar('reference_no')
            ->maxLength('reference_no', 100)
            ->requirePresence('reference_no', 'create')
            ->notEmptyString('reference_no');

        $validator
            ->scalar('approval_no')
            ->maxLength('approval_no', 100)
            ->requirePresence('approval_no', 'create')
            ->notEmptyString('approval_no');

        $validator
            ->scalar('approval_name')
            ->maxLength('approval_name', 50)
            ->requirePresence('approval_name', 'create')
            ->notEmptyString('approval_name');

        $validator
            ->scalar('approval_post')
            ->maxLength('approval_post', 100)
            ->requirePresence('approval_post', 'create')
            ->notEmptyString('approval_post');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['lecturer_id'], 'Lecturers'), ['errorField' => 'lecturer_id']);
        $rules->add($rules->existsIn(['subject_id'], 'Subjects'), ['errorField' => 'subject_id']);
        $rules->add($rules->existsIn(['semester_id'], 'Semesters'), ['errorField' => 'semester_id']);

        return $rules;
    }
}
