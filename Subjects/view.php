<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Subject $subject
 */
?>
<!--Header-->
<div class="row text-body-secondary">
	<div class="col-10">
		<h1 class="my-0 page_title"><?php echo $title; ?></h1>
		<h6 class="sub_title text-body-secondary"><?php echo $system_name; ?></h6>
	</div>
	<div class="col-2 text-end">
		<div class="dropdown mx-3 mt-2">
			<button class="btn p-0 border-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fa-solid fa-bars text-primary"></i>
			</button>
				<div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
							<li><?= $this->Html->link(__('Edit Subject'), ['action' => 'edit', $subject->id], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?></li>
				<li><?= $this->Form->postLink(__('Delete Subject'), ['action' => 'delete', $subject->id], ['confirm' => __('Are you sure you want to delete # {0}?', $subject->id), 'class' => 'dropdown-item', 'escapeTitle' => false]) ?></li>
				<li><hr class="dropdown-divider"></li>
				<li><?= $this->Html->link(__('List Subjects'), ['action' => 'index'], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?></li>
				<li><?= $this->Html->link(__('New Subject'), ['action' => 'add'], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?></li>
							</div>
		</div>
    </div>
</div>
<div class="line mb-4"></div>
<!--/Header-->

<div class="row">
	<div class="col-md-9">
		<div class="card rounded-0 mb-3 bg-body-tertiary border-0 shadow">
			<div class="card-body text-body-secondary">
            <h3><?= h($subject->name) ?></h3>
    <div class="table-responsive">
        <table class="table">
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($subject->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($subject->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Credit Hour') ?></th>
                    <td><?= h($subject->credit_hour) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($subject->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $this->Number->format($subject->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($subject->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($subject->modified) ?></td>
                </tr>
            </table>
            </div>

			</div>
		</div>
		

            
            

            <div class="card rounded-0 mb-3 bg-body-tertiary border-0 shadow">
            <div class="card-body text-body-secondary">
                <h4><?= __('Related Appointments') ?></h4>
                <?php if (!empty($subject->appointments)) : ?>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Lecturer Id') ?></th>
                            <th><?= __('Subject Id') ?></th>
                            <th><?= __('Semester Id') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Location') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Start Date') ?></th>
                            <th><?= __('End Date') ?></th>
                            <th><?= __('Reference No') ?></th>
                            <th><?= __('Approval No') ?></th>
                            <th><?= __('Approval Name') ?></th>
                            <th><?= __('Approval Post') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($subject->appointments as $appointments) : ?>
                        <tr>
                            <td><?= h($appointments->id) ?></td>
                            <td><?= h($appointments->lecturer_id) ?></td>
                            <td><?= h($appointments->subject_id) ?></td>
                            <td><?= h($appointments->semester_id) ?></td>
                            <td><?= h($appointments->date) ?></td>
                            <td><?= h($appointments->location) ?></td>
                            <td><?= h($appointments->status) ?></td>
                            <td><?= h($appointments->start_date) ?></td>
                            <td><?= h($appointments->end_date) ?></td>
                            <td><?= h($appointments->reference_no) ?></td>
                            <td><?= h($appointments->approval_no) ?></td>
                            <td><?= h($appointments->approval_name) ?></td>
                            <td><?= h($appointments->approval_post) ?></td>
                            <td><?= h($appointments->created) ?></td>
                            <td><?= h($appointments->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Appointments', 'action' => 'view', $appointments->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Appointments', 'action' => 'edit', $appointments->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Appointments', 'action' => 'delete', $appointments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $appointments->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>

		
	</div>
	<div class="col-md-3">
	  Column
	</div>
</div>




